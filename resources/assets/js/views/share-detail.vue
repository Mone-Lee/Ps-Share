<template>
	<div class="share-detail">
		<div class="header">
			<navbar></navbar>
		</div>
		<div class="wrapper">
			<div class="content">
				<div class="share-content">				
					<div v-for="picture in share.pictures" class="share-picture">
						<img :src="$img(picture.path)">
					</div>
					<div class="share-button">
						
						<div class="select-collect">
							<span class="button-good" href=""
							v-show="!share.statusLike" 
							@click="like">
							点赞
							</span>
							<span class="button-delete-good" href=""
							v-show="share.statusLike" 
							@click="deleteLike">
							取消点赞
							</span>
							<span class="button-collect" href="" 
							v-show="!share.statusCollection" 
							@click="toCollect">
							收藏
							</span>
							<!-- 收藏 弹窗 -->
							<popFrame :isShow="isCollect">
								<div class="content-head">
									<p><span class="collect-title">收藏</span>
									<span @click="closeCreate" class="close-button">x</span></p>
								</div>
								<div class="content-wrap">
										<div class="createClassification" v-show="isCreate">
											<input type="text" name="collectionClassification" id="collectionName" class="new-input" placeholder="请输入收藏夹的名字">
											<div class="new-buttons">
												<button @click="createCollect" class="new-sure">新建并收藏</button>
												<button @click="cancelCreate" class="new-cancel">取消</button>
											</div>
										</div>
										<div class="content-list">
											<p class="user-collection" 
											v-for="collection in userCollection">
											<span @click="collect(collection.collectionClassification.id)">{{collection.collectionClassification.name}}</span>
										</p>
										</div>
									<div class="content-create">
										<p v-show="createButton" @click="createClassification" class="create-button">新建收藏分类</p>
									</div>
								</div>

							</popFrame>
							<!-- 收藏 弹窗 结束-->
							<span class="button-delete-collect" href="" 
							v-show="share.statusCollection" 
							@click="judgeDeleteCollect">
							取消收藏
							</span>
							<popFrame :isShow="isJudge">
			            		<div class="d-titleBar">
			            			<div class="d-title" style="display: block;">删除确认</div>
			            			<a class="d-close" href="javascript:;" style="display: block;" @click="closeJudge">×</a>
			            		</div>
			            		<div class="judge-frame">
				            		<div class="d-content" style="padding: 20px 25px;">你确定要取消收藏该分享吗？</div>
				            		<div class="d-button">
					            		<button @click="deleteCollect(true)" class="sure">确定</button>
					            		<button @click="deleteCollect(false)" class="cancel">取消</button>
				            		</div>
				            	</div>
			            	</popFrame>
							<span @click="reportShare(share.id, false)">举报此分享</span>
						</div>	
</div>
</div>
				
				<div class="comments">
					<comment
						:userPic="user.pic"
						:shareUserId="shareUser.id"
					></comment>
				</div>
			</div>
			<div class="user-information">
				<div class="userPanel">
					<div class="userpanel__left">
						<div class="userpanel__portrait" id="userPortrait" :style="'background-image:url('+$img(shareUser.pic)+')'"></div>
						<p class="userpanel__userName">{{shareUser.name}}</p>
						<userFollow :followUserId="shareUser.id" class="userFollowBtn"></userFollow>
						<p><a href="getUrl(0)">关注{{shareUser.follows}}</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="getUrl(1)">收藏{{shareUser.collections}}</a></p>
						<h3 style="text-align:left">“</h3>
						<p class="userpanel__userIntro">{{shareUser.introduction}}</p>
						<h3 style="text-align:right">”</h3>
					</div>
				</div>


				<div class="share-info">
					<h3 class="shareTitle">{{share.abstract}}</h3> &nbsp;&nbsp;&nbsp;<small style="floar:right">{{share.created_at.split(" ")[0]}}</small>
					<p style="margin: 30px 0px;margin-top: -10px;">{{share.content}}</p>
					<p style="float:right">{{"[ "+share.sc_name+" ]&nbsp;&nbsp;&nbsp;&nbsp;点赞  "+share.likes+"  收藏  "+share.collections}}</p>
				</div>
			</div>
		</div>
		<report-dialog
			:id="id"
			:flag="flag"
			v-if="show"
			@close="show=false"
		></report-dialog>
	</div>
</template>


<script>
	import comment from '../components/share-detail/comment.vue';
	import navbar from '../components/index/navbar.vue';
	import userFollow from '../components/share-detail/userFollow.vue';
	import popFrame from '../components/index/popFrame.vue';
	import ReportDialog from '../components/public/report-dialog.vue';
	

	export default{
		name:'share-detail',

		components:{
			comment,
			navbar,
			userFollow,
			popFrame,
			ReportDialog,
		},

		mounted(){
			this.getShareId();
			this.getUserCollection();
			this.getUserMsg();
            this.getShareDetail();
		},

		data(){
			return {
				shareId: 0,
				userCollection:[],

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
                },

                isCollect:false,
                isCreate:false,
                createButton:true,
                createdClassificationId:-1,
                id: 0,
                flag: false,
                show: false,

                isJudge:false,
			}
		},
		methods:{
			getShareId(){
				let href = [];
				href = location.href.split('/');
				let shareId = href[href.length-1];
				this.shareId = Number(shareId);
			},
			getUserCollection(){
				this.$http.get(this.$adminUrl('collectionClassification')).then((response)=>{
					this.$set(this,'userCollection',response.body);
				},(response)=>{
					alert('fail in getting data!');
				})
			},
			/*点赞*/
			like(){
				this.$http.post(this.$adminUrl('like'),{share_id: this.shareId}).then((response)=>{
					if(response.body != 'false') {
						this.share.statusLike = true;
						this.$alert('收藏成功', 's');
                    }else {
                        console.log('fail in liking!');
                    }
				},(response)=>{
					console.log(response.body);
				})
			},
			/*取消点赞*/
			deleteLike(){
				this.$http.delete(this.$adminUrl('like/') + this.shareId ).then((response) => {
					if(response.body != 'false'){
						this.share.statusLike = false;
						return true;
					}else{
						console.log('fail in deleteLikeing!');
					}
				},(response) => {
						return false;
				})
			},
			toCollect(){
				this.isCollect = true;
				// alert('收藏');
			},
			/*点击‘新建收藏分类’按钮*/
			createClassification(){
				this.createButton = false;
				this.isCreate = true;
			},
			/*点击‘取消’按钮*/
			cancelCreate(){
				document.getElementById('collectionName').value='';
				this.isCreate = false;
				this.createButton = true;
			},
			/*点击‘x’按钮*/
			closeCreate(){
				this.isCollect = false;
			},
			/*收藏*/
			collect(collection_id){
				this.$http.post(this.$adminUrl('collection'),{'share_id':this.shareId,'collection_classification_id':collection_id}).then((response)=>{
					if(response.body) {
						this.isCollect = false;
						this.share.statusCollection = true;
						this.$alert('收藏成功', 's');
                    }else {
                        console.log('fail in collecting!');
                    }
				},(response)=>{
					console.log(response.body);
				})
			},
			/*新建收藏分类*/
			createCollectionClassification(){
				var collectionName = document.getElementById('collectionName').value;
				this.$http.post(this.$adminUrl('collectionClassification'),{'name':collectionName}).then((response)=>{
					if(!isNaN(response.body)) {
						console.log('新建成功! 啦啦啦啦~~撒花~~');
						this.createdClassificationId = response.body;
                    }else {
                        console.log('fail in creating collection!');
                    }
				})
			},
			/*新建收藏分类并收藏*/
			createCollect(){
				this.createCollectionClassification();
				this.collect(this.createdClassificationId);
				this.cancelCreate();
			},
			/*取消收藏*/
			deleteCollect(isDelete){
				if(isDelete){
					this.$http.delete(this.$adminUrl('collection/') + this.shareId ).then((response) => {
						if(response.body){
							this.share.statusCollection = false;
							this.$alert('取消收藏成功', 's');
						}else{
							console.log('fail in deleteCollecting!');
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

                },(response) => {

                })
            },

            /**
            * 举报分享
            */
            reportShare (id, flag) {
                this.id = id;
                this.flag = flag;
                this.show = true;
            },

		},

	};

</script>


<style>
	.share-detail{
	}
	.header{
		height: 50px;
		width:100%;
		background: #f5f5f5;
		position: fixed;
        top:0px;
        z-index:999;
	}
	.wrapper{
		padding-top: 70px;
		width: 1080px;
		margin:0 auto;
		/*overflow:hidden; zoom:1;*/
	}
	.content{
		width:722px;
		float: left;
	}
	.share-content{
		margin-top: 20px;
		margin-bottom: 25px;
		margin-left: 5px;
		padding:10px 20px 20px;
		width:680px;
		min-height: 300px;
		border:1px solid #b8b8b8;
		-webkit-box-shadow:0 0 10px #767676;  
  		-moz-box-shadow:0 0 10px #767676;  
  		box-shadow:0 0 10px #767676;
  		border-radius:5px;
	}
	
	.share-picture{
		width:570px;
		margin:8px auto 2px;
	}
	.share-picture img{
		width: inherit;
	}
	.share-button{
		margin-top:20px;
		padding:15px 0 10px;
		text-align: right;
	}
	.share-button>span,.select-collect>span{
        font-size: .8em;
        background: #fff;
        border:2px solid #b6b6b6;
        border-radius: 3px;
        padding:5px 20px; 
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
        margin-left: 10px;
    }
    .share-button>span:hover,.select-collect>span:hover{
        background: #b6b6b6;
        color:#fff;
        cursor: pointer;
    }
	.user-information{
		width: 230px;
		display: inline-block;
	    margin-left: 50px;
	    margin-top: 20px;

		/*-webkit-box-shadow:0 0 10px #767676;  
  		-moz-box-shadow:0 0 10px #767676;  
  		box-shadow:0 0 10px #767676;*/
  		/*margin-bottom:-3000px; padding-bottom:3000px; */
  		/*background:#f0f3f9;*/
	}
	.userPanel{
		width: 100%;
		background: #F5F5F5;
	}
	.userpanel__left{
		text-align: center;
		overflow: hidden;
		padding-bottom: 15px;

	}
	.userpanel__left>h3{
		display: inline-block;
		font-family: "宋体";
		width: 100px;
		color:#888;
	}
	.userpanel__left a{
		display: inline-block;
		font-size: 18px;
		margin: 10px 0px;
	}
	.userpanel__portrait{
		height:180px;
		width:180px; 
		border-radius: 50%;
		margin:10px 20px;
		background:center no-repeat;
		background-size:cover;
	}
	.userpanel__userName{
		font-size: 18px;
	}
	.share-info{
		padding:20px 15px;
		background: #f5f5f5;
		margin-top: 30px;
		overflow: hidden;
	}
	.share-info small{
		float: right;
		margin-top: -15px;
	}
	.shareTitle{
		font-size: 1.3em;
		font-weight: normal !important;
		margin: 10px 0px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	.c-pop__content{
		text-align: left;
		color: #6d757a;
	    position:absolute;
		top: -130px;
    	left: 300px;
	    width: 280px;
	    background-color: #fff;
	    border-radius: 10px;
	    z-index: 10100;
	    font-size: 12px;
	    border: 1px solid #e5e9ef;
	    box-shadow: rgba(0,0,0,0.16) 0 2px 4px;
	}
	.content-head{
		border-bottom: 1px solid #e5e9ef;
	    position: relative;
	    margin: 0 20px;
	    height: 50px;
	}
	.collect-title,.follow-title{
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