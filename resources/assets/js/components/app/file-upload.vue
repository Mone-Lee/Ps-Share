<template>
    <div>
        <form @submit.prevent="changeUserMsg" enctype="multipart/form-data">
            <img :src="$img(user.pic)">
            <input @change="previewPicture" type="file" name="picture">
            <div>
                <label>性别</label>
                <input v-model="user.sex" type="radio" value="1" name="sex" id="male">
                <label for="male">男</label>
                <input v-model="user.sex" type="radio" value="0" name="sex" id="female">
                <label for="female">女</label>
            </div>
            <div>
                <label for="introduction">简介</label>
                <input v-model="user.introduction" type="text" name="introduction" id="introduction">
            </div>
            <input type="submit" value="提交">
        </form>
    </div>
</template>
<style>

</style>
<script>
    export default{
        name:'FileUpload',
        data(){
            return{
                picture: null,
                user: {
                    'pic':'',
                    'sex': 0,
                    'introduction': ''
                },
            }
        },
        mounted () {
            this.getUserMsg();
        },

        methods: {

            /**
             *  获取用户基本信息
             */
            getUserMsg () {
                this.$http.get(this.$adminUrl('getUserMsg')).then((response) => {
                    this.$set(this,'user',response.body);
                }, (response) => {

                });
            },

            /**
             *  修改用户基本信息
             */
            changeUserMsg () {
                let form = new FormData();
                form.append('sex', this.user.sex);
                form.append('introduction', this.user.introduction);
                form.append('picture', this.picture);

                this.$http.post(this.$adminUrl('saveUserMsg'), form, {headers:{'Content-Type':'multipart/form-data'}, progress: this.progress}).then((response) => {

                }, (response) => {

                });
            },

            progess (event) {
                if(event.lengthComputable) {
                  console.log(event.total);
                  console.log(event.loaded);
                }
                
            },

            /**
             *  获取图片
             */
            previewPicture (event) {
                this.picture = event.target.files[0];
                // 开始读取选中的图片，添加预览到页面
                let reader = new FileReader();
                reader.readAsDataURL(this.picture);
                reader.onload = e => {
                    this.user.pic = e.target.result;
                }
            },
        },
    }
</script>
