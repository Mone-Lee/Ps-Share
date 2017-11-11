<template>
<div>
    <div class="main" v-if="ok">
        <div v-for="(list,index) in collectionClassifications" class="collectionBoxItem">
            <a v-on:mouseout="Mouseout" v-on:mouseover="Mouseover(index)">
                        <div v-if="list.sharePics.length!=0" class="myitem_img myitem_img-small">
                            <div v-for="hello in list.sharePics" class="items">
                                <img :src="$img(hello.pic)" v-on:click="itempicture(list.collectionClassification.id)">
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                        <div v-else class="myitem_img ">
                                <img src="/images/upload/default.png" v-on:click="itempicture(list.collectionClassification.id)">
                        </div>
            <h4>{{list.collectionClassification.name}}</h4>
            <div class="collectionBoxItem_p" v-show="index!=0" style="float:right;margin-right:10px" >
                <p  v-show="flag && index == item" @click="delCollectionClassification(list.collectionClassification.id,index)">&nbsp;删除</p>
                <p v-show="flag && index == item" data-toggle="modal" data-target="#myModal" v-on:click="setId(list.collectionClassification.id)">编辑</p>              
            </div>
            </a>
                        <!-- 模态框（Modal） -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">修改收藏夹</h4>
                            </div>
                            <div class="modal-body">  
                                <label>新的名字</label>                       
                                <input v-model="chgCollectionClassification.name" type="text" name="classificationName">
                                <label>是否隐藏</label>
                                    <input type="checkbox" v-model="hideflag" />

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"@click="ChgCollectionClassification(id),hideCollectionClassification(id)" >提交更改</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                </div>
        </div>
        <div class="boxadd">
            <img data-toggle="modal" data-target="#Modals" src="/images/add.png">
                <!-- 模态框（Modal） -->
                <div class="modal fade" id="Modals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">新建收藏夹</h4>
                            </div>
                            <div class="modal-body">
                                <input v-model="newCollectionClassification.name" type="text" name="classificationName" placeholder="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="addCollectionClassification">提交更改</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                </div>
        </div>
    </div>

    <div class="innerContent" v-else>
    <button type="button" class="btn btn-info back" v-on:click="backing">返回</button>
        <div class="item">
             <div v-for="(list,index) in AllCollectionsByClassifications.data" class="collectionBoxItem">
                <a :href="$homeUrl('share-detail', 'p')+'/'+list.share.share_id" target="_blank" v-on:mouseout="Mouseout" v-on:mouseover="Mouseover(index)">
                <img :src="$img(list.pictures[0].path)">
                <h4>{{list.share.abstract}}</h4>
                <p  v-show="flag && index == item" @click="cancelCollection(list.share.share_id)">&nbsp;取消收藏</p>
                </a>            
            </div>           
        </div>
    </div>
</div>
</template>

<script>
    import {mapState} from 'vuex';
    import {mapMutations} from 'vuex';
	export default{
        name:'collection',
        data(){
        	return{
                id:0,
                newClassification: {
                    'id': 0,
                    'name': '',
                    'sharePics': [],
                    'collectionClassification': {}
                },
                classification: {
                    'id': 0,
                    'name': '',
                    'sharePics': [],
                    'collectionClassification': {}
                },
                picture:[],
                collectionClassifications:[],
                collectionClassification: {
                    'id':0,
                    'name':'',
                    'user_id':0,
                },
                sharePic:{
                    'pic':'',
                    'share_id':0,
                },
                sharePics:[],
                newCollectionClassification: {
                    'id':0,
                    'name':'',
                },
                chgCollectionClassification: {
                    'id':0,
                    'name':'',                    
                },
                flag:false,
                item:-1,
                ok:true,
                number:0,
                userMsg: {
                    'user_id':0,
                    'name':'',
                    'introduction':'',
                    'sex':0,
                    'pic':''
                },
                share: {
                    'id':0,
                    'abstract':'',
                    'content':'',
                    'sc_id':'',
                    'sc_name':'',
                    'status':0,
                    'created_at':'',
                },
                pictures:[],
                picture:{
                    'id':0,
                    'order':0,
                    'path':'',
                },
                pb:{
                    userId:0,
                    collectionClassificationId:0,
                },
                AllCollectionsByClassifications:[],
                lists:{
                    'pic':'',
                    'share_id':0,
                },
                hideflag:false,
        	}
        },

        mounted () {
            this.getcollectionClassification();
            this.getIndexUserMsg();
            
        },

         components: {   
        },
        computed:mapState([
            'pictures',
        ]),

        methods: {

            getcollectionClassification() {
                this.$http.get(this.$adminUrl('collectionClassification')).then((response) => {

                    this.$set(this, 'collectionClassifications', response.body);

                }, (response) => {

                });
            },
            getIndexUserMsg(){
                this.$http.get(this.$adminUrl('getUserMsg')).then((response) => {

                    this.$set(this, 'userMsg', response.body);

                },
                (response) => {

                    alert('fail in getting data!');

                });
            },
            getAllCollectionsByClassification(){
                this.$http.get(this.$homeUrl('getAllCollectionsByClassification'),{params:this.pb}).then((response) => {
                    this.$set(this, 'AllCollectionsByClassifications', response.body);
                },
                (response) => {

                    alert('fail in getting data!');

                });
            },
            addCollectionClassification() {
                this.$http.post(this.$adminUrl('collectionClassification'), this.newCollectionClassification).then((response) => {
                    this.newClassification.id = response.body;
                    this.getcollectionClassification();
                    this.collectionClassifications.push(this.collectionClassification);
                    this.$alert("新建成功","s");
                }, (response) => {

                });
                this.newCollectionClassification.name="";
            },
            delCollectionClassification(id,index) {
                this.$http.delete(this.$adminUrl('collectionClassification')+'/'+id).then((response) => {
                    this.collectionClassifications.splice(index,1);
                    this.$alert("删除成功","e");
                }, (response) => {
                });
                
            },
            hideCollectionClassification(id) {

                if(this.hideflag==true){
                    this.$http.delete(this.$adminUrl('collectionClassification/triggle')+'/'+id).then((response) => {
                    this.$alert("隐藏成功","s");
                }, (response) => {
                });
                }
                
            },
            cancelCollection(id){
                this.$http.delete(this.$adminUrl('collection')+'/'+id).then((response) => {
                }, (response) => {

                });
                this.$alert("取消收藏","e");
                window.location.reload();                
            },
            ChgCollectionClassification(id) {
                this.$http.put(this.$adminUrl('collectionClassification')+'/'+id, this.chgCollectionClassification).then((response) => {
                }, (response) => {
                    this.getcollectionClassification();
                    this.collectionClassifications.push(this.newClassification);
                    this.$alert("修改成功","s");
                    this.hideCollectionClassification(id);
                });
                this.chgCollectionClassification.name="";
            },
            setId(ids){
                this.id=ids;
                this.chgCollectionClassification.id=ids;
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
                this.pb.collectionClassificationId=x;
                this.pb.userId=this.userMsg.user_id;
                this.ok=false;
                this.getAllCollectionsByClassification();
            },       
            backing(){
                this.ok=true;
            }
   }        
}
</script>

<style>
.items{
    height: 105px;
    width: 105px;
    display: block;
    float: left;
}
.innerContent{
    margin-top: 32px;
}
.main{
    height: 600px;
    width: 800px;
    margin: 100px auto;
}
.item{
    height: 600px;
    width: 800px;
    margin: 100px auto;
}
.collectionBoxItem{
    height:320px;
    width:250px;
    display:block;
    float:left;
    overflow: hidden; 
    border-radius: 8px;
}
.innerContent img{
    background:no-repeat;
    height:210px;
    width: 210px;
    margin:20px;
    border-radius:8px;
    box-shadow: 0px 0px 8px #ccc;
    cursor: pointer;
}
.collectionBoxItem a{
    height:320px;
    width:250px;
    display: block;
}
.collectionBoxItem_p {
    text-align: left;
    margin-left: 10px;
    display: -webkit-inline-box
}
.collectionBoxItem h4{
    font-weight: bold;
    color:#000;
    text-align: center;    
}
.boxadd{
    display: block;
    float: left;
    height: 250px;
    width: 250px;
}

.boxadd img{
    height: 210px;
    width: 210px;
    padding:50px;
    margin: 20px;
    border: 2px dashed #1d6d1d;
    border-radius: 8px;
}
.back{
    position: relative;
    top: 70px;
    left: 60px;
}
.myitem_img img{
    background: no-repeat;
    height:212px;
    width: 212px;
    cursor: pointer;
    border: 1px solid #ccc !important;
    border-radius: 8px;
    background-color: white;
}
.myitem_img-small img{
    width: 105px;
    height: 105px;
}
</style>