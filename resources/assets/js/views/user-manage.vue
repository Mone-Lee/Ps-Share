<template xmlns:v-validate="http://www.w3.org/1999/xhtml">
        <div>
        <div class="header">
            <navbar></navbar>
        </div>
         <div class="container">
        <div class="layout">
            <aside class="layout__aside">
                <sidebar
                        :navbars="navbars"
                ></sidebar>
            </aside>
            <div class="layout__main">

                        <div class="layout__main__title">
                                <div class=" form-inline searchBox">
                                    <input v-model="shareSearch.abstract" type="text" class="form-control"
                                           placeholder="请输入关键字.." >
                                    <select v-model="shareSearch.status" class="form-control">
                                        <option value="-1">全部</option>
                                        <option value="1">正常</option>
                                        <option value="2">屏蔽</option>
                                        <option value="0">未发布</option>
                                    </select>
                                    <button v-on:click="searchShare" class="btn btn-info btn-search">查找</button>
                                </div>
                            
                        </div>
                <div v-if="ok">
                    <router-view></router-view>
                </div>
                <div v-else>
                        <button type="button" class="btn btn-info back" v-on:click="backing">返回</button>
                            <div class="item">
                                 <div v-for="(datas,index) in list" class="boxitem">
                                    <a :href="$homeUrl('share-detail', 'p')+'/'+datas.share.id" target="_blank" v-on:mouseout="Mouseout" v-on:mouseover="Mouseover(index)">
                                        <img :src="$img(datas.pictures[0].path)">
                                        <h4>{{datas.share.content}}</h4>
                                    </a>            
                                </div>           
                            </div>
                </div>
            </div>
        </div>
        </div>
</template>

<script>
    import navbar from '../components/index/navbar.vue';
    import sidebar from '../components/public/sidebar.vue'; 
    import PictureUpload from '../components/public/picture-upload.vue';
    import Picturepanel from '../components/public/Picturepanel';
    import {mapState} from 'vuex';
    import {mapMutations} from 'vuex';

    export default{
        name:'Usermanage',
        mounted () {
            this.getShareClassifications();
        },
        data () {
            return {
                navbars: [
                    {
                        path: '/share',
                        name: '分享管理',
                        show: true
                    },
                    {
                        path: '/follow',
                        name: '关注管理',
                        show: true
                    },
                    {
                        path: '/collection',
                        name: '收藏管理',
                        show: true
                    },
                    {
                        path: '/receive',
                        name: '消息',
                        show: true
                    },
                    {
                        path: '/history',
                        name: '我的足迹',
                        show: true
                    },
                    {
                        path: '/userinfo',
                        name: '用户信息',
                        show: true
                    },
                ],
                ShareClassification: {
                    id: 0,
                    name: ''
                },
                ShareClassifications: [],
                share: {
                    'share_classification_id':0,
                    'abstract':'',
                    'content':'',
                    'pics':[],
                    'status':1,
                    'sc_id':0,
                    'sc_name':'',
                    'id':0,
                    'created_at':'',
                },
                shareSearch: {
                    'abstract':'',
                    'status':-1
                },
                ok:true,
                item:-1,
                pictures:{
                    'id':0,
                    'path':'',
                    'order':0,
                }
            }
        },
        computed:mapState([
            'pictures',
            'list',
        ]),
        components: {
            PictureUpload,
            navbar,sidebar,
            Picturepanel,

        },
        methods: {
            ...mapMutations([
                'setList',
                'setPaginatorParams'
            ]),
            getShareClassifications () {

                this.$http.get(this.$adminUrl('getAllShareClassifications')).then((response) => {

                    this.$set(this, 'ShareClassifications', response.body);

                },
                (response) => {

                    alert('fail in getting data!');

                });
            },
            validateBeforeSubmit() {
                let form = new FormData();
                form.append('share_classification_id', this.share.share_classification_id);
                form.append('abstract', this.share.abstract);
                form.append('content', this.share.content);
                form.append('status',this.share.status);
                for(let picture of this.pictures){
                    form.append('pictures[]', picture);
                }

                this.$http.post(this.$adminUrl('share'), form, {headers:{'Content-Type':'multipart/form-data'}}).then((response) => {

                }, (response) => {

                });
            },
            searchShare () {
                this.$http.get(this.$adminUrl('share/query'), {params:this.shareSearch}).then((response) => {

                    // 搜索中一定要用这个全局方法设置分页器的参数
                    this.setPaginatorParams(this.shareSearch)
                    // 设置分页的总页数
                    this.total = response.body.last_page;
                    // 更新全局list
                    this.setList(response.body.data);

                },(response) => {

                });
                this.ok=false;
            },
            clearform(){
                window.location.reload();

            },
            backing(){
                this.ok=true;
            },
            Mouseover(x){
                this.flag=true;
                this.item=x;
            },
            Mouseout(){
                this.flag=false;
                this.item=-1;
            },
        }
    }


</script>

<style>
.boxitem h4{
    font-weight: bold;
    color: black;
}
/*.boxitem img{
    background:no-repeat;
    height:210px;
    width: 210px;
    margin:20px;
    border-radius:8px;
    cursor: pointer;
    border: 1px solid black;
}*/
.boxitem a{
    height:320px;
    width:250px;
    display: block;
}
.boxitem{
    height:320px;
    width:250px;
    display:block;
    float:left;
    overflow: hidden; 
    text-align: center;
}
.item{
    height: 600px;
    width: 800px;
    margin: 100px auto;
}

.layout__main__title{
    position: fixed;
    height: 85px;
    line-height: 85px;
    font-size: 1.2em;
    padding: 20px 0px;
    width: inherit;
    border-bottom: 1px solid #ccc;
    background: #fff;
    padding-left: 10px;
    display: block;
    z-index: 90;
}
.searchBox{
line-height: 24px;
float: right;
}
.layout__main__title button{
    margin: 5px 10px;
}

.header{
        height: 54px;
        width:100%;
        position: fixed;
        top:0px;
        z-index: 99;

}
.container{
    width:1080px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    margin: 0 auto;
}
.layout {
    width: 1080px;
    margin-top: 52px;
    background: #fff;
}
.layout__aside {
    width: 200px;
    height: 100%;
    position: fixed;
}
.layout__main {
    width: 880px;
    margin: 0px;
    margin-top: 10px;
    margin-left: 200px;
    overflow: auto;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
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


#panelright{
    display:block;
    float:left;
    height:880px;
    width:1000px;
    background:blue;
}

.panelright_head{
    height:40px;
    width:730px;
    margin:30px 50px;
}


.panelright_head input{
    margin:5px 0;
}

.panelright_head select{
    display: block;
    float: right;
    height: 30px;
    width: 80px;
    margin: 4px; 
}

.panelright_head_search{
    display:block;
    float:right;
}




</style>


