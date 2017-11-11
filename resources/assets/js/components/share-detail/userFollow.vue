<template>
    <div>
        <!-- <section class="userInfo">
            <div class="userInfo__left">
                <img :src="'/'+shareUser.pic" alt="用户头像" class="userPortrait userPortrait-mid">
            </div>
            <div class="userInfo__right">
                <p>{{ shareUser.name }}&nbsp;&nbsp;{{ shareUser.sex == 0 ? '♂' :'♀'}} <small class="userInfo__link"><a href="" class="fadeIn">关注 {{ user.followings }}</a></small> </p>
                <p class="userInfo__intro">{{ shareUser.introduction }}</p>
            </div>
        </section>  -->
        <div class="select-follow">
            <span class="userInfo__follow" href="" v-show="!share.statusFollow" @click="toFollow" v-if="!(followUserId == user.id)">关注用户</span>
            <popFrame :isShow="isCollect">
                <div class="content-head">
                    <p><span class="follow-title">关注</span>
                    <span @click="closeCreate" class="close-button">x</span></p>
                </div>
                <div class="content-wrap">
                    <div class="createClassification" v-show="isCreate">
                        <input type="text" name="collectionClassification" id="followName" class="new-input" placeholder="请输入关注分类的名字">
                        <div class="new-buttons">
                            <button @click="createCollect" class="new-sure">新建并关注</button>
                            <button @click="cancelCreate" class="new-cancel">取消</button>
                        </div>
                    </div>
                    <div class="content-list">
                        <p class="user-collection" 
                       v-for="collection in followCollection">
                           <span @click="follow(collection.followClassification.id)">{{collection.followClassification.name}}</span>
                        </p>
                    </div>

                    <div class="content-create">
                        <p v-show="createButton" @click="createClassification" class="create-button">新建关注分类</p>
                    </div>
                </div>
            </popFrame>
            <span class="userInfo__unfollow" href="" v-show="share.statusFollow" @click="judgeDeleteCollect" v-if="!(followUserId == user.id)">取消关注</span>
            <popFrame :isShow="isJudge">
                <div class="d-titleBar">
                    <div class="d-title" style="display: block;">删除确认</div>
                    <a class="d-close" href="javascript:;" style="display: block;" @click="closeJudge">×</a>
                </div>
                <div class="judge-frame">
                    <div class="d-content" style="padding: 20px 25px;">你确定要取消关注该用户吗？</div>
                    <div class="d-button">
                        <button @click="deleteFollow(true)" class="sure">确定</button>
                        <button @click="deleteFollow(false)" class="cancel">取消</button>
                    </div>
                </div>
            </popFrame>
        </div>
    </div>

</template>
<style>
        .userPortrait{
            border: 1px dashed #aaa;
            background: #fff;
            margin: 10px 0px; 
            border-radius: 5px;
        }
        .userPortrait-mid{
            width: 72px;
        }
        .userPortrait-small{
            width: 56px;
        }
        .userInfo{
            overflow: hidden;
            background: #fff;
            padding:0px 30px; 
            position: relative;
            /*border:1px solid #eee;*/
            margin:10px 0px;
        }
        .userInfo__left{
            margin-right:25px;
            float: left;
        }
        .userInfo__right{
            vertical-align: middle;
            line-height: 32px;
            margin-top: 10px;
        }
        .userInfo__follow,.userInfo__unfollow{
            font-size: .8em;
            background: #fff;
            border:2px solid #b6b6b6;
            border-radius: 3px;
            padding:5px 20px; 
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }
        .userInfo__follow:hover,.userInfo__unfollow:hover{
            background: #b6b6b6;
            color:#fff;
            cursor: pointer;
        }
        .userInfo__link{
            font-size: 0.8em;
            /*margin-left: 20px;*/
        }
        .userInfo__link a{
            margin-right:15px;
        }
        .userInfo__intro{
            font-size: 0.8em;
        }
        .c-pop__content{
            color: #6d757a;
            position:fixed;
            top:200px;
            left:400px;
            width: 280px;
            background-color: #fff;
            border-radius: 10px;
            z-index: 10100;
            font-size: 12px;
            border: 1px solid #e5e9ef;
            box-shadow: rgba(0,0,0,0.16) 0 2px 4px;
            text-align: left;
        }
        .content-head{
            border-bottom: 1px solid #e5e9ef;
            position: relative;
            margin: 0 20px;
            height: 50px;
        }
        .follow-title{
            line-height: 50px;
            font-size: 18px;
            color: #333;
            margin-left: 5px;
        }
        .close-button{
            position: absolute;
            right: 0;
            top: 16px;
            width: 16px;
            height: 16px;
        }
        .close-button:hover{
            cursor: pointer;
            border:1px dotted #ccc;
        }
        .content-wrap{
            padding: 10px 0;
        }
        .content-list{
            height: 228px;
            overflow: auto;
            margin-right: -5px;
            padding-right: 5px;
            padding-bottom: 10px;
        }
        .user-collection{
            padding: 0 10px;
        }
        .user-collection span{
            display:block;
            background-color: #fff;
            height: 24px;
            line-height: 24px;
            cursor: pointer;
            padding: 0 5px;
            border-radius: 4px;
            position: relative;
            font-size: 14px;
            margin: 4px 10px;
        }
        .user-collection span:hover{
            cursor: pointer;
            color:#2ca8dc;
            background-color: #edf2f9;
        }
        .content-create{
            padding: 0 20px;
        }
        .create-button{
            border: 1px solid #aaa;
            height: 32px;
            padding: 0 10px;
            border-radius: 4px;
            text-align: center;
            line-height: 32px;
        }
        .create-button:hover{
            cursor: pointer;
            border:1px solid #2ca8dc;
            color:#000;
        }
        .createClassification{
            padding: 0 20px 20px 20px;
            border-bottom: 1px solid #c6d8f2;
            margin-bottom: 10px;
        }
        .new-input{
            border: 1px solid #ccd0d7;
            background-color: #eee;
            position: relative;
            vertical-align: middle;
            display: inline-block;
            border-radius: 4px;
            box-shadow: none;
            height: 34px;
            line-height: 36px;
            padding: 0 40px 0 10px;
            margin: 0;
            transition: .2s border;
            width: 188px;
            box-sizing: content-box;
            font-family: "Microsoft YaHei",Arial,Helvetica,sans-serif;
            font-size: 14px;
        }
        .new-buttons,.d-button{
            margin-top: 20px;
            overflow: hidden;
            font-size: 14px;
        }
        .d-button{
            margin-bottom: 20px;
        }
        .new-buttons button,.sure,.cancel{
            cursor: pointer;
            height: 36px;
            transition: .2s;
            border-radius: 5px;
        }
        .sure{
            color: #fff;
            width: 70px;
            background-color: #00a1d6;
            border: 1px solid #00a1d6;
            float: left;
            margin-left: 30px;
        }
        .new-sure{
            color: #fff;
            width: 120px;
            background-color: #00a1d6;
            border: 1px solid #00a1d6;
            float: left;
        }
        .new-sure:hover,.sure:hover{
            background-color: #00b5e5;
        }
        .cancel{
            width: 70px;
            background-color: #fff;
            border: 1px solid #aaa;
            color: #666;
            float: right;
            margin-right: 30px;
        }
        .new-cancel{
            width: 100px;
            background-color: #fff;
            border: 1px solid #aaa;
            color: #666;
            float: right;
        }
        .new-cancel:hover,.cancel:hover{
            color: #4abcec;
            border:1px solid #4abcec;
        }
        .d-titleBar{
            font: 12px/1.11 'Microsoft Yahei',Tahoma,Arial,Helvetica,STHeiti;
        }
        .d-title {
            font-size: 16px;
            line-height: 48px;
            padding: 0 20px;
            border-bottom: 1px solid #ddd;
        }
        .d-title {
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: default;
        }
        .d-close {
            margin-top: 17px;
            top: -2px;
            right: 12px;
            width: 20px;
            height: 20px;
            display: block;
            position: absolute;
            text-decoration: none;
        }
        .d-close:hover{
            border:1px dotted #ccc;
        }
        .d-content{
            font-size: 14px;
            text-align: center;
            min-width: 9em;
        }
</style>
<script>
    import popFrame from '../index/popFrame.vue';

    export default{
        name: 'userFollow',
        props:{
           followUserId:""
        },
        data(){
            return {
                // user:{
                //     name:"Samyze",
                //     sex:"♀",
                //     portrait:"/images/add.png",
                //     followings:10,
                //     favorites:20,
                // },
                shareIntro:"啦啦啦",

                // 当前登录用户的信息
                user: {
                    'id': 0,
                    'pic': '',
                    'name': ''
                },
                // 分享拥有者的信息
                shareUser: {
                    'id': 0,
                    'name': '',
                    'pic': '',
                    'introduction': '',
                    'sex': 0
                },
                // 分享的详细信息
                share: {
                    'id': 0,
                    'pictures': [],
                    'abstract': '',
                    'content': '',
                    'created_at': '',
                    'sc_id': 0,
                    'sc_name': '',
                    'likes': 0,
                    'collections': 0,
                    'statusLike':'',
                    'statusCollection':'',
                    'statusFollow':'',
                },
                shareId: 0,
                followCollection:[],
                isCollect:false,
                isCreate:false,
                createButton:true,
                createdClassificationId:-1,

                isJudge:false,

                isSelf:false,
            }
        },
        mounted () {
            this.getShareId();
            this.getShareDetail();
            this.getUserFollow();
            this.getUserMsg();
        },
        components: {
           popFrame,
        },
        methods: {
            getShareId(){
                let href = [];
                href = location.href.split('/');
                let shareId = href[href.length-1];
                this.shareId = Number(shareId);
            },
            /**
            * 获取分享的详细信息
            */
            getShareDetail () {
                this.$http.get(this.$homeUrl('getShareDetail')+'/'+this.shareId).then((response) => {

                    this.shareUser.id = response.body.user_id;
                    this.shareUser.name = response.body.user_name;
                    this.shareUser.pic = response.body.pic;
                    this.shareUser.introduction = response.body.introduction;
                    this.shareUser.sex = response.body.sex;

                    this.share.id = response.body.share_id;
                    this.share.pictures = response.body.pictures;
                    this.share.abstract = response.body.abstract;
                    this.share.content = response.body.content;
                    this.share.created_at = response.body.created_at;
                    this.share.sc_id = response.body.sc_id;
                    this.share.sc_name = response.body.sc_name;
                    this.share.likes = response.body.likes;
                    this.share.collections = response.body.collections;
                    this.share.statusLike = response.body.statusLike;
                    this.share.statusCollection = response.body.statusCollection;
                    this.share.statusFollow = response.body.statusFollow;

                },(response) => {

                })
            },
            /*获取用户关注分类*/
            getUserFollow(){
                this.$http.get(this.$adminUrl('followClassification')).then((response)=>{
                    this.$set(this,'followCollection',response.body);
                },(response)=>{
                    alert('fail in getting followCollection!');
                })
            },
            /**
            * 获取用户信息
            */
            getUserMsg () {
                this.$http.get(this.$adminUrl('getUserMsg')).then((response)=>{
                    this.user.id = response.body.user_id;
                    this.user.pic = response.body.pic;
                    this.user.name = response.body.name;
                },(response) => {

                });
            },

            toFollow(){
                this.isCollect = true;
            },
            /*点击‘x’按钮*/
            closeCreate(){
                this.isCollect = false;
            },
            /*点击‘新建关注分类’按钮*/
            createClassification(){
                this.createButton = false;
                this.isCreate = true;
            },
            /*点击‘取消’按钮*/
            cancelCreate(){
                document.getElementById('followName').value='';
                this.isCreate = false;
                this.createButton = true;
            },
            /*关注*/
            follow(follow_id){
                this.$http.post(this.$adminUrl('follow'),{'followed_id':this.followUserId,'follow_classification_id':follow_id}).then((response)=>{
                    if(response.body != 'false') {
                        this.isCollect = false;
                        this.share.statusFollow = true;
                        this.$alert('关注成功', 's');
                        console.log('关注成功! 啦啦啦啦~~撒花~~');
                    }else {
                        console.log('fail in following!');
                    }
                },(response)=>{
                    console.log(response.body);
                })
            },
            /*新建关注分类*/
            createFollowClassification(){
                var followName = document.getElementById('followName').value;
                this.$http.post(this.$adminUrl('followClassification'),{'name':followName}).then((response)=>{
                    if(!isNaN(response.body)) {
                        console.log('新建成功! 啦啦啦啦~~撒花~~');
                        this.createdClassificationId = response.body;
                    }else {
                        console.log('fail in creating followClassification!');
                    }
                })
            },
            /*新建关注分类并关注*/
            createCollect(){
                this.createFollowClassification();
                this.follow(this.createdClassificationId);
                this.cancelCreate();
            },
            /*取消关注*/
            deleteFollow(isDelete){
                if(isDelete){
                   this.$http.delete(this.$adminUrl('follow/') + this.shareUser.id ).then((response) => {
                        if(response.body != 'false'){
                            this.share.statusFollow = false;
                            this.$alert('取消关注成功', 's');
                        }else{
                            console.log('fail in deleteFollowing!');
                        }
                    },(response) => {
                            return false;
                    })
                }

                this.isJudge = false;

            },
            judgeDeleteCollect(){
                this.isJudge = true;
            },
            /*点击‘x’按钮*/
            closeJudge(){
                this.isJudge = false;
            },
        }
    }
</script>
