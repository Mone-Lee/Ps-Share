<template>
	<div class="panel">
				<ul id="myTab" class="nav nav-tabs">
				    <li class="active">
				        <a href="#home" data-toggle="tab">
				            修改个人信息
				        </a>
				    </li>
				    <li>
				    	<a href="#ios" data-toggle="tab">
				    		修改密码
				    	</a>
				    </li>
				</ul>
				<div id="myTabContent" class="tab-content">
				    <div class="tab-pane fade in active home" id="home" >
				        <form @submit.prevent="changeUserMsg" enctype="multipart/form-data" style="overflow: hidden;">
				            <img :src="$img(user.pic)" class="img-circle">
				            <div class="editForm">
				            	<input @change="getPicture" type="file" name="picture">
				                <label>性别&nbsp;</label>
				                <input v-model="user.sex" type="radio" value="1" name="sex" id="male">
				                <label for="male">男</label>
				                <input v-model="user.sex" type="radio" value="0" name="sex" id="female">
				                <label for="female">女</label>
				            
				            <div class="form-inline ">
				                <label for="introduction">简介</label>
				                <input v-model="user.introduction" type="text" name="introduction" id="introduction" class="form-control">
				                 <button type="submit" class="btn btn-success">提交</button>
				            </div>
				            </div>
				           
				        </form>
				    </div>
				    <div class="tab-pane fade" id="ios">
				    <div class="form-group">
				        <form @submit.prevent="changePassword" enctype="multipart/form-data">
				            <div class="form-horizontal">
					            <div class="form-inline">
					                <label for="password" class="col-md-3 control-label">新密码</label>
					                <input
					                        v-model="password.password"
					                        data-as="新密码"
					                        type="password" name="password" id="password" class="form-control">
					            </div>
					            <div class="form-inline">
					                <label for="password_confirmation" class="col-md-3 control-label">确认密码</label>
					                <input
					                        v-model="password.password_confirmation"
					                        v-validate.initial="password.password_confirmation"
					                        data-rules="confirmed:password"
					                        data-as="确认密码"
					                        type="password" name="password_confirmation" id="password_confirmation"
					                        class="form-control">
					                <span v-show="errors.has('password.password_confirmation')">{{ errors.first('password.password_confirmation') }}</span>
					            </div>
					            <div class="form-inline" >
					            <label for="password" class="col-md-4"></label>
				            		<input type="submit" class="btn btn-success" >
								</div>	
				            </div>
				        </form>
				        </div>
				    </div>
				</div>
	</div>
</template>

<script>
    export default{
        name: 'userinfo',
        data(){
            return{
            	user: {
                    'pic':'',
                    'sex': 0,
                    'introduction': ''
                },
                password: {
                    'password': '',
                    'password_confirmation': ''
                },
            }
        },
        mounted () {
            this.getUserMsg();
        },
        methods: {
            getUserMsg () {
                this.$http.get(this.$adminUrl('getUserMsg')).then((response) => {
                    this.$set(this,'user',response.body);
                }, (response) => {

                });
            },
            changeUserMsg () {
                let form = new FormData();
                form.append('sex', this.user.sex);
                form.append('introduction', this.user.introduction);
                form.append('picture', this.picture);

                this.$http.post(this.$adminUrl('saveUserMsg'), form, {headers:{'Content-Type':'multipart/form-data'}}).then((response) => {

                }, (response) => {

                });
            this.$alert("修改信息成功","s");
            window.location.reload();                
            },
            changePassword () {
                // 验证表单
                this.$validator.validateAll();
                // 如果表单报错则不提交
                if(this.errors.any()) {
                    return false;
                }else {
                    this.$http.post(this.$adminUrl('changePassword'), this.password).then((response) => {

                    }, (response) => {

                    });
                }
            this.$alert("修改密码成功","s");
            window.location.reload();
            },
            getPicture (event) {
                this.picture = event.target.files[0];
            },
        }
 }	
</script>

<style type="text/css">
.panel{
    margin: 100px auto; 
}
.editForm{
	margin-top: 25px;
}
.home img{
	margin: 20px auto;
    height: 120px;
    width: 120px;
    float: left;
    margin-right: 20px;
}
#ios{
	padding-top: 20px;
}
.editForm{
	margin-top: 20px;
}
</style>