<template>
<div>
    <div class="followPanel" v-if="ok">
        <div class="form-group addItemBox">
            <p class="form-inline">
                 <input class="form-control" v-model="newClassification.name" type="text" name="classificationName">
                <button @click="addClassificationName" class="btn btn-info">新增</button>
            </p>
        </div>
        <div id="item">
                <div v-for="(list,index) in followClassifications" class="boxitem">
                    <a v-on:mouseout="Mouseout" v-on:mouseover="Mouseover(index)" >
                            <div class="boxitem_img" v-on:click="itempicture(list.followClassification.id)">
                                <div v-for="userPic in list.userPics" class="items">
                                <img :src="$img(userPic.pic)">
                                </div>
                                <div style="clear: both;"></div>
                            </div>
                        <h4>{{list.followClassification.name}}</h4>
                        <p v-show="flag && index == item && index!=0" @click="delClassificationName(list.followClassification.id,index)" style="text-align:right;margin-right:10px">取消收藏</p>
                    </a>
                </div>
        </div>
    </div>
    <div v-else id="user">
        <button class="btn btn-info" v-on:click="backing">返回</button>
        <div v-for="(list,index) in AllFollowsByClassifications" class="user_item">
           <p><span class="glyphicon glyphicon-user"></span>{{list.followed_name}}</p>
           <button @click="delUser(list.followed_id)" class="btn btn-default cancelFollowBtn" type="button">取消关注</button>
        </div>
</div>
</template>

<script>
    import userFollow from '../share-detail/userFollow.vue';
    export default{
        name: 'follow',
        components: {
            userFollow
        },
        data(){
            return{
                followClassification :{
                    'id':0,
                    'name':'',
                    'user_id':0,
                },
                userPic:{
                    'name':'',
                    'pic':'',
                },
                userPics:[],
                followClassifications:[],
                newfollowclassification:'',
                newClassification: {
                    'id': 0,
                    'name': ''
                },
                item:-1,
                flag:false,
                ok:true,
                pb:{
                    userId:0,
                    followClassificationId:0,
                },
                userMsg: {
                    'user_id':0,
                    'name':'',
                    'introduction':'',
                    'sex':0,
                    'pic':''
                },
                AllFollowsByClassifications:[],
            }
        },
        mounted () {
            this.getfollowClassification();
            this.getIndexUserMsg();
        },
        methods: {

            getfollowClassification() {
                this.$http.get(this.$adminUrl('followClassification')).then((response) => {

                    this.$set(this, 'followClassifications', response.body);

                }, (response) => {

                });
            },
            addClassificationName() {
                this.$http.post(this.$adminUrl('followClassification'), this.newClassification).then((response) => {
                    this.newClassification.id = response.body;
                    this.getfollowClassification();
                    this.followClassifications.push(this.followClassification);
                    this.$alert("新建成功","s");
                    this.newClassification.name=""
                }, (response) => {

                });
            },
            delClassificationName(id,index) {
                this.$http.delete(this.$adminUrl('followClassification')+'/'+id).then((response) => {
                   this.$alert("取消关注","e");
                   
                   this.followClassifications.splice(index,1);
                }, (response) => {
                });
            },
            Mouseover(x){
                this.flag=true;
                this.item=x;
            },
            Mouseout(){
                this.flag=false;
                this.item=-1;
            },
            itempicture(x){
                this.pb.followClassificationId=x;
                this.pb.userId=this.userMsg.user_id;
                this.ok=false;
                 this.getAllFollowsByClassification();
            }, 
            getIndexUserMsg(){
                this.$http.get(this.$adminUrl('getUserMsg')).then((response) => {

                    this.$set(this, 'userMsg', response.body);

                },
                (response) => {


                });
            },
            getAllFollowsByClassification(){
                this.$http.get(this.$homeUrl('getAllFollowsByClassification'),{params:this.pb}).then((response) => {
                    this.$set(this, 'AllFollowsByClassifications', response.body.data);
                },
                (response) => {

                });
            },
            delUser(id) {
                this.$http.delete(this.$adminUrl('follow')+'/'+id).then((response) => {
                     this.getAllFollowsByClassification();
                }, (response) => {


                });
                this.$alert("取消关注","s");
                 document.getElementById("box").innerHTML = "";
            },
            backing(){
                this.ok=true;
            }
   }     
}

</script>

<style>
.followPanel{
    height: 100%;
     margin-top: 100px; 
}
#user{
    height: 600px;
    width: 800px;
    margin: 100px auto; 
}
.user_item{
    width: 800px;
    background: #f5f5f5;
    padding: 10px;
    position: relative;
    margin-top: 10px;
    box-shadow: 0px 0px 5px #ccc;
}
.user_item>p{
    display: inline-block;
}
.user_item button{
    right: 10px;

}
.newfollow{
    position: relative;
    float: right;
}
.panel input{
    margin:5px 0;
}

#item{
    width: 800px;
    padding-left: 10px;
}
.addItemBox{
    text-align: right;
    margin-right: 10px; 
}
.cancelFollowBtn{
    float: right;
}
.boxitem{
    height:320px;
    width:250px;
    display:block;
    float:left;
    overflow: hidden; 
    border-radius: 8px;
}
.boxitem a{
    height:320px;
    width:250px;
    display: block;
    text-align: center;
    border-radius: 8px;
}

.boxitem a:hover{
    background-color:#f5f5f5;
    box-shadow: 0px 0px 5px #ccc;
    border-radius: 8px;
}
.boxitem p{
     text-align: left;
    margin-left: 20px;   
    cursor: pointer;
    margin-top: 5px;
}
.boxitem_img{
    background: no-repeat;
    height:212px;
    width: 212px;
    margin:20px;
    cursor: pointer;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: white;
    position: relative;
    top: 20px;
}
.boxitem h4{
    position: relative;
    top: 10px;
    font-weight: bold;
    color: black;
}
.items{
    height: 100px;
    width: 100px;
}
.items img{
    height: 100%;
    width: 100%;
    margin: 5px;
}
</style>