<template>
<div>
    <div class="main" v-if="ok">
        <div v-for="(list,index) in collectionClassifications" class="boxitem">
            <a v-on:mouseout="Mouseout" v-on:mouseover="Mouseover(index)">
                        <div v-if="list.sharePics.length!=0" class="myitem_img">

                            <div v-for="hello in list.sharePics" class="items">
                                <img :src="$img(hello.pic)" v-on:click="itempicture(list.collectionClassification.id)" class="littleimg">
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                        <div v-else>
                                <img src="/images/upload/default.png" v-on:click="itempicture(list.collectionClassification.id)">
                        </div>
            <h4>{{list.collectionClassification.name}}</h4>

            </a>

        </div>

    </div>

    <div v-else>
    <button type="button" class="btn btn-info back" v-on:click="backing">返回</button>
        <div class="item">
             <div v-for="(list,index) in AllCollectionsByClassifications.data" class="boxitem">
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
            'userMsg'
        ]),

        methods: {

            getcollectionClassification() {
                this.$http.get(this.$homeUrl('getAllCollectionClassification')+'/'+this.userMsg.user_id).then((response) => {

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
                    this.collectionClassifications.push(this.newClassification);
                    document.getElementById("Modals").reset();
                    this.$alert("新建成功","s");
                }, (response) => {

                });
                this.newCollectionClassification.name="";
            },
            delCollectionClassification(index,id) {
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
.littleimg{
    margin: 0px !important;
    height: 105px !important;
    width: 105px !important;
    border: 0px !important;    
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
.boxitem{
    height:320px;
    width:250px;
    display:block;
    float:left;
    overflow: hidden; 
    border-radius: 8px;
}
.boxitem img{
    background:no-repeat;
    height:210px;
    width: 210px;
    margin:20px;
    border-radius:8px;
    cursor: pointer;
    border: 1px solid black;
}
.boxitem a{
    height:320px;
    width:250px;
    display: block;
}
.boxitem_p {
    text-align: left;
    margin-left: 10px;
    display: -webkit-inline-box
}
.boxitem h4{
    font-weight: bold;
    color: black;
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
    margin: 20px;
    border: 5px dashed #1d6d1d;
    border-radius: 8px;
}
.back{
    position: relative;
    top: 70px;
    left: 60px;
}
.myitem_img{
    background: no-repeat;
    height:212px;
    width: 212px;
    margin:20px;
    cursor: pointer;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: white;
}
</style>

