<template>
<div>
            <p style="text-align:right">
            <button class="btn btn-success  btn-public" data-toggle="modal" data-target="#myModal"
                data-backdrop="static" >发布分享
            </button>
            <button @click="batchDeleteShare" class="btn btn-danger">批量删除</button>
            </p>
        	<div v-for="(datas, index) in list" id="box">
        		<div class="item1">
                    <a v-on:mouseout="Mouseout" v-on:mouseover="Mouseover(index)" class="item1-a">
                            <input v-model="shareIds" :value="datas.share.id" type="checkbox">
                            <a :href="$homeUrl('share-detail', 'p')+'/'+datas.share.id" target="_blank">
                            <img :src="$img(datas.pictures[0].path)">
                            </a>
                            <div class="item1_a"><h4>{{datas.share.abstract}}</h4></div>
                            <div class="item1_b" v-show="flag && index == item" ><p style="text-align:right;margin-right:10px" v-on:click="deleteShare(datas.share)" type="text">删除</p><button v-on:click="chgShare(datas.share.id,index)">{{what(datas.share.status)}}</button></div>
        	        </a>    
        		</div>
        	</div>
    <!-- 模态框（Modal） -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" v-show="modalflag">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        新建分享
                    </h4>
                </div>
                <form @submit.prevent="validateBeforeSubmit" enctype="multipart/form-data" id="submitForm">
                    <div class="modal-body">
                        <div class="panelright_itembox">
                            <div class="newshare_picture">
                                <PictureUpload :picNumber="6" picSrc="/images/add.png"></PictureUpload>
                            </div>

                            <div class="newshare_info">
                                <div>
                                    <label for="abstract">摘要</label>
                                    <input v-model="share.abstract" type="text" name="abstract" id="abstract" class="form-control">
                                </div>
                                <div>
                                    <label for="content">描述</label>
                                            <textarea v-model="share.content" type="text" name="content"
                                                      id="content" class="form-control"></textarea>
                                </div>
                                <div>
                                    <label for="classification">分类</label>
                                    <select v-model="share.share_classification_id" class="form-control" id="classification">
                                        <option :value="ShareClassification.id"
                                                v-for="(ShareClassification, index) in ShareClassifications">
                                            {{ShareClassification.name}}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label>是否发布</label>
                                    <input type="checkbox" v-model="share.status" />
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                        </button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="validateBeforeSubmit" >提交更改</button>
                    </div>

                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

</div>
	
</template>

<script>
    import {mapState} from 'vuex';
    import {mapMutations} from 'vuex';
    import PictureUpload from '../public/picture-upload.vue';
	export default{
        name:'Picturepanel',
        data(){
        	return{
                total:1,
                share: {
                    'id':0,
                    'abstract':'',
                    'content':'',
                    'sc_id':'',
                    'sc_name':'',
                    'status':0,
                    'created_at':'',
                },
                shares:[],
                picture:[],
                shareIds: [],
                ShareClassification: {
                    id: 0,
                    name: ''
                },
                ShareClassifications: [],
                flag:false,
                item: -1,
                word:'',
        	}
        },

        mounted () {
            this.getShares();
            this.getShareClassifications();
        },

         components: {   
            PictureUpload,
        },

        computed:mapState([
            'pictures',
            'list'
        ]),

        methods: {
        	...mapMutations([
        		'setList',
        	]),

            getShares() {
                this.$http.get(this.$adminUrl('share/indexAdmin')).then((response) => {

                    // 设置分页的总页数
                    this.total = response.body.last_page;
                    // 更新全局list
                    this.setList(response.body.data);

                }, (response) => {

                });
            },
            deleteShare(share,index) {
                this.$http.delete(this.$adminUrl('share') + '/' + share.id).then((response) => {
                                    this.$alert("删除成功","e");
                                    this.list.splice(index,1);
                }, (response) => {

                });
            },
            batchDeleteShare() {

                this.$http.delete(this.$adminUrl('share/batch-delete'),{params:this.shareIds}).then((response) => {

                }, (response) => {

                });
                this.$alert("删除成功","e");
                window.location.reload();
            },
            validateBeforeSubmit() {
                let form = new FormData();
                form.append('share_classification_id', this.share.share_classification_id);
                form.append('abstract', this.share.abstract);
                form.append('content', this.share.content);
                if(this.share.status==true) this.share.status=1;
                    else this.share.status=0;
                form.append('status',this.share.status);
                for(let picture of this.pictures){
                    form.append('pictures[]', picture);
                }
                this.$http.post(this.$adminUrl('share'), form, {headers:{'Content-Type':'multipart/form-data'}}).then((response) => {
                    
                    this.$set(this, 'word', response.body);
                    if(this.word<500){
                    this.getShares();

                    this.$alert("新建成功","s");
                    }
                    else
                        this.$alert("含有敏感字","e");
                }, (response) => {

                });
            },
            getShareClassifications () {

                this.$http.get(this.$adminUrl('getAllShareClassifications')).then((response) => {

                    this.$set(this, 'ShareClassifications', response.body);

                },
                (response) => {

                });
            },
            chgShare(id){
                this.$http.get(this.$adminUrl('triggleShare')+'/'+id).then((response) => {
                    this.getShares();
                },
                (response) => {


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
            what(id){
                if(id==1)
                    return "屏蔽";
                else
                    return "发布";
            }
   }        
}
</script>

<style lang="sass">
.item1{
    margin-top: 30px;
	text-align:center;
	height:320px;
	width:250px;
	display:block;
	float:left;
	overflow: hidden; 
    position: relative;
    border-width: 1px;
    border-color: black;
    border-radius: 8px;
}

.item1-a{
    display:block;
	height:320px;
	width:250px;
    border-radius: 8px;
}

.item1 :hover{
    background-color:#f5f5f5;
    border-radius: 8px;
}

.item1 img{
    background: no-repeat;
    height: 210px;
    width: 210px;
    margin: 20px;
    border-radius: 8px;
}

.item1_a{
    height:30px;
    margin:0 10px 5px 10px;
    width: 230px;
    cursor:pointer;
}

.item1_a h4{
    font: 18px;
    color: black;
    font-weight: bold;
}

.item1_b{
    height: 18px;
    width: 230px;
    display: inline-block;
}

.item1_b p{
    cursor:pointer;
    text-align: left;
    margin-left: 20px;
}

.item1 button{
    height:25px;
    position: relative;
    left: 50px;
    top: -33px;
    border: 0;
    background: rgba(0,0,0,0);
}

.item1 input{
    display: block;
    position: absolute;
    right:  10px;
    width: 20px;
}
    .newshare_picture>div{
    width: 100%;
    display: flex;
    justify-content: space-around;
}

.newshare_info{
    width: 100%;
    margin-top: 20px;
    
    div {
        margin: 11px 0;
    }

    label {
        width: 14%;
    }

    input, select, textarea {
        width: 80%;
        display: initial;
    }

    input[type=checkbox] {
        width: 10px;
    }
}
.panelright_itembox{
    height: 324px;
    width: 517px;
    margin: 5px;
}
</style>