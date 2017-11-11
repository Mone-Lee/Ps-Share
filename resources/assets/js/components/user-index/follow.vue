
<template>
<div>
    <div class="panel" v-if="ok">
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
                    </a>
                </div>
        </div>
    </div>
    <div v-else id="user">
        <button class="btn btn-info " v-on:click="backing">返回</button>
        <div v-for="(list,index) in AllFollowsByClassifications" class="user_item">
           <h2><span class="glyphicon glyphicon-user"></span>{{list.followed_name}}</h2>
        </div>
</div>
</template>

<script>
    import {mapState} from 'vuex';
    export default{
        name: 'follow',
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
        computed:mapState([
            'userMsg'
        ]),
        mounted () {
            this.getfollowClassification();
            this.getIndexUserMsg();
        },
        methods: {

            getfollowClassification() {
                this.$http.get(this.$homeUrl('getAllFollwClassification')+'/'+this.userMsg.user_id).then((response) => {

                    this.$set(this, 'followClassifications', response.body);

                }, (response) => {

                });
            },
            addClassificationName() {
                this.$http.post(this.$adminUrl('followClassification'), this.newClassification).then((response) => {
                    this.newClassification.id = response.body;
                }, (response) => {

                });
                this.$alert("新建成功","s");
                window.location.reload();
            },
            delClassificationName(id) {
                this.$http.delete(this.$adminUrl('followClassification')+'/'+id).then((response) => {
                }, (response) => {

                });
                this.$alert("删除关注类","e");
                window.location.reload();
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

                    list.$alert("fail in getting data!","e");

                });
            },
            getAllFollowsByClassification(){
                this.$http.get(this.$homeUrl('getAllFollowsByClassification'),{params:this.pb}).then((response) => {
                    this.$set(this, 'AllFollowsByClassifications', response.body.data);
                },
                (response) => {

                });
                this.$alert("fail in getting data!","e");
            },
            delUser(id) {
                this.$http.delete(this.$adminUrl('follow')+'/'+id).then((response) => {
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
.panel{
    height: 100%;
}
#user{
    height: 600px;
    width: 800px;
    margin: 100px auto; 
}
.user_item{
    width: 800px;
    display:inline-block;
}
.user_item h2{
    display: block;
    float: left;
}
.user_item button{
    float: right;
}
.newfollow{
    position: relative;
    float: right;
}
.panel input{
    margin:5px 0;
}

#item{
    height: 600px;
    width: 800px;
    margin: 60px auto;
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
    background-color:#e0e0e0;
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
    border: 1px solid black;
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
    height: 105px;
    width: 105px;
    display: block;
    float: left;
}
.items img{
    height: 105px;
    width: 105px;
    display: block;
    margin: 0px;
    border: 0px;
}
</style>

