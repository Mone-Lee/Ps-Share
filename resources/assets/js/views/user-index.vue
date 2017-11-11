<template  xmlns:v-validate="http://www.w3.org/1999/xhtml">
    <div >
        <div class="header">
            <navbar
                @getUserMsg="getUserMsg"
            ></navbar>
        </div>
        <div class="content">
            <div class="userPanel">
                <div class="userpanel__left">
                    <div  class="userpanel__portrait" id="userPortrait"></div>
                    <p>
                        <template v-if="visitedUserMsg.user_id == userMsg.user_id">
                            <a :href="$adminUrl('user-manage#/follow', 'p')">关注{{follows}}</a>
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <a :href="$adminUrl('user-manage#/collection', 'p')">收藏{{collections}}</a>
                        </template>
                        <template v-else>
                            <router-link to="/follow">关注{{follows}}</router-link>
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <router-link to="/collection">收藏{{collections}}</router-link>
                        </template>
                    </p>
                </div>
                <div class="userpanel__right">
                        <p class="userpanel__userName">{{userMsg.name}}&nbsp;&nbsp;&nbsp;&nbsp;<span v-text="getSex(userMsg.sex)"></span></p>
                        <p  class="userpanel__userIntro">{{userMsg.introduction}}</p>
                        <userFollow :followUserId="userMsg.user_id" style=" margin-top: -60px;margin-left: 100px;"></userFollow>
                </div>
            </div>
            
            <router-view></router-view>

        </div>
    </div>

</template>
<style>

    .userPanel{
        width: 100%;
        margin-top: 58px;
        margin-bottom: 10px;
        background: #F5F5F5;
        overflow: hidden;
    }
    .userpanel__left,.userpanel__right{
        display:inline-block;
    }
    .userpanel__left{
        text-align: center;
        float: left;
        vertical-align: middle;
    }
    .userpanel__left a{
        font-size: 18px;
    }
    .userpanel__portrait{
        height:180px;
        width:180px; 
        border-radius: 50%;
        margin:10px 20px;
        background: url(/images/pic1.jpg) center no-repeat;
        background-size:300px;
    }
    .userpanel__right{
        margin-left: 20px;
    }
    .userpanel__userName{
        font-size: 18px;
        line-height: 180px;
    }
    .userpanel__userIntro{
        margin-top: -80px;
    }
    .header{
        height: 54px;
        width:100%;
        position: fixed;
        top:0px;
        z-index:999;
    }
    .content{
        width:1080px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        margin: 0 auto;
    }

    .sharepanel{
        width:inherit;
        overflow: hidden; 
        background:#eee;
    }

    .sharepanel_itembox{
        height:520px;
        width:1040px;
        margin:20px 20px;
        background:#f0f0f0;
    }
</style>

<script>
    import {mapState} from 'vuex';
    import {mapMutations} from 'vuex';
    import paginator from '../components/public/paginator.vue'; 
    import navbar from '../components/index/navbar.vue';
    import sidebar from '../components/public/sidebar.vue';
    import userPanel from '../components/user-index/userPanel.vue';
    import collection from '../components/user-index/collection.vue'
    import userindexTab from '../components/user-index/userindexTab.vue';
    import userFollow from '../components/share-detail/userFollow.vue';


    export default{
        name:'Userindex',
        data(){
            return{
                // 个人空间拥有者的个人信息
                userMsg: {},
                // 访问者的个人信息
                visitedUserMsg: {},
                shares: [],
                shareClassifications: [],
                collections: 0,
                follows: 0
            }
        },

        mounted () {
            this.getUserInfo();
        },
        components: {
            paginator,   
            navbar,
            userPanel,
            userindexTab,
            userFollow
        },
        
        methods: {

            ...mapMutations([
                'setShares',
                'setShareClassifications',
                'setUserMsg'
            ]),

            showPortait(){
                var portrait = document.getElementById("userPortrait");
                portrait.style.backgroundImage="url("+this.userMsg.pic+")";
                portrait.style.backgroundImage="url(/images/pic1.jpg)";
            },
            getUserInfo(){

                let href = [];
                href = location.href.split('/');
                let userId = href[href.length-2];
                userId = userId.substring(0, userId.length-1);

                this.$http.get(this.$homeUrl('getIndexUserMsg')+'/'+userId).then((response) => {
                    this.$set(this, 'userMsg', response.body.userMsg);
                    this.setShares(response.body.shares.data);
                    this.setUserMsg(response.body.userMsg);
                    this.setShareClassifications(response.body.shareClassifications);
                    this.$set(this, 'shareClassifications', response.body.shareClassifications);
                    this.follows = response.body.follows;
                    this.collections = response.body.collections;
                    this.showPortait();
                },
                (response) => {
                    alert('fail in getting userMsg!');
                });
            },

            getSex(x){
                if(x==1)
                    return "♂";
                else
                    return "♀";
            },
            getUserMsg(userMsg){
                this.visitedUserMsg = userMsg;
            }
          }        
}


</script>
