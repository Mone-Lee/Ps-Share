<template xmlns:v-validate="http://www.w3.org/1999/xhtml">
    <div class="container">
        <div class="header">
            <navbar></navbar>
        </div>
        <div class="layout">
            <aside class="layout__aside">
                <sidebar
                        :navbars="navbars"
                ></sidebar>
            </aside>
            <div class="layout__main">
                <router-view></router-view>
            </div>
        </div>

</template>

<script>
    import navbar from '../components/admin-manage/navbar.vue';
    import sidebar from '../components/admin-manage/sidebar.vue';
    import {mapState} from 'vuex';
    import {mapMutations} from 'vuex';
    export default{
        name:'AdminManage',
        mounted () {

        },
        data () {
            return {
                navbars: [
                    {
                        path: '/shareClassification',
                        name: '分类管理',
                        show: true
                    },
                    {
                        path: '/keyword',
                        name: '关键字管理',
                        show: true
                    },
                    {
                        path: '/reportClassification',
                        name: '举报分类管理',
                        show: true
                    },
                    {
                        path: '/report',
                        name: '举报管理',
                        show: true
                    },
                    {
                        path: '/user',
                        name: '用户管理',
                        show: true
                    },
                    {
                        path: '/role',
                        name: '角色管理',
                        show: window.isAdmin
                    }
                ]
            }
        },
        components: {
            navbar,
            sidebar,
        },
        computed:mapState([

        ]),
        methods: {

        },
    }


</script>

<style>
    #app {
        height: 100%;
    }

.header{
    height: 52px;
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
}
    .container{
        width:100%;
        height: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        margin: 0 auto;
}
    .layout {
        width: 100%;
        height: 100%;
        background: #fff;
    }
    .layout__aside {
        float: left;
        width: 200px;
        height: 100%;
        background: white;
        border-right: 1px solid #E8E8E8;
    }
    .layout__main {
        width: 880px;
        margin: 0 auto;
        padding-top: 87px;
        overflow: auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;

                }
    .layout__main__title{
        position: fixed;
        height: 48px;
        line-height: 48px;
        margin: 0px;
        width: inherit;
        border-bottom: 1px solid #ccc;
        background: #fff;
        padding-left: 10px;
    }
    .layout__main__content{
        margin-top: 58px;
        height: 1000px;
        background: #0a0;
    }
#panel{
    height:850px;
    width:1080px;
    margin:0 auto;
}
#panelleft{
    display:block;
    float:left;
    height:850px;
    width:250px;
    background:red;
    text-align:center;
}

#panelleft img{
    margin:30px 40px;
    height:170px;
    width:170px;
}

#panelleft_nav{

}

#panelright{
    display:block;
    float:left;
    height:850px;
    width:830px;
    background:blue;
}

.panelright_head{
    height:40px;
    width:730px;
    background:green;
    margin:30px 50px;
}

.panelright_head p{
    font-size: 25px;
    height: 40px;
    float: left;
    width: 100px;
    display: block;
    margin: 10px auto;
}

.panelright_head input{
    margin:5px 0;
}

.panelright_head_search{
    display:block;
    float:right;
}

.panelright_itembox{
    height:260px;
    width:780px;
    background:black;
    margin:10px 25px;
}

.panelright_itembox_creatshare{
    height:260px;
    width:260px;
    background:white;
    display:block;
    float:left;
}

.panelright_itembox_item{
    height:260px;
    width:520px;
    background:yellow;
    display:block;
    float:left;
}

.panelright_newshare {
    height: 300px;
    width: 500px;
    background: black;
    margin: 80px 165px;
    overflow:hidden;
}

.panelright_newshare_picture{
    height:260px;
    width:200px;
    background:yellow;
    margin:20px 10px 20px 20px;
    display:block;
    float:left;
    overflow :auto
}

.panelright_newshare_info{
    height:260px;
    width:240px;
    background:red;
    margin:20px 20px 20px 10px;
    display:block;
    float:left;
    text-align:left;
}



</style>


