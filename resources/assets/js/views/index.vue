<template>
	<div>
		<div class="header">
			<navbar ></navbar>
		</div>
		<!-- <slide :arrow="false" :pages="true" :favourite="false"></slide> -->
		<div class="pictureGallery">
			<p class="Brand">PS-Share</p>
			<input tabindex="2" type="text" name="search" class="pictureGallery__searchBox" @click="clearText" @blur="initText" v-model="searchText">
			<button tabindex="3" class="pictureGallery__searchButton" @click="getSearchResult">GO</button>
		</div>
		<div class="content">
			<categoriesList :searchString="searchString"></categoriesList>
			<contentTab></contentTab>
		</div>
	</div>
</template>

<style>
	.header{
		height: 52px;
		width:100%;
		background: #f5f5f5;
		position: fixed;
		top:0px;
		z-index:999;
	}
	/*.c-slider{
		height:500px;
	}*/

	.top {
	    width: 100%;
	    height: 500px;
	    background-color: #009688;
	    color: white;
	    text-align: center;
	}
	.title {
	    margin: 0;
	    padding-top: 200px;
	    font-weight: normal;
	    font-size: 55px;
	}
	#search {
		margin-top: 90px;
	    width: 600px;
	    height: 34px;
	    padding:0 3px;
	    border: 1px solid white;
	    border-radius: 2px;
	}
	#search-button{
		height: 36px;
	    width: 120px;
	    background-color: #204c48;
	    color: #fff;
	    font-size: 18px;
	    border: 0;
	    border:none;
	    border-radius: 2px;
	    margin-top: 2px;
	}
	#search-button:hover{
		background-color:#1fc1b2;
	}
	.content{
		width:1080px;
		margin: 0px auto;
	}

	.more{
		color:#888888;
		float: right;
	}
	.list-box{
		background: #f5f5f5;
	}
	.list-box .box-content{
		width:100%;
		/*height:300px;*/
		background: #fff;
		margin:10px 0;
	}
	.list-box ul li{
		display: inline-block;
		width:60px;
		height:30px;
		margin:10px 4px;
		border:1px dotted #ccc;
	}
	.paginator{
		margin-top: 20px; 
	}
	.pictureGallery{
		overflow: hidden;
		width: 100%;
		height: 560px;
		margin-top: 52px;

		background:#fff url('/images/pic3.jpg') no-repeat center ;
		background-size:cover;
		text-align: center;
		color:#fff;

	}
	.Brand{
		font-size: 2.4rem;
		margin-top: 220px;
		margin-bottom: 20px;
		text-shadow:5px 5px 5px rgba(0,0,0,0.5);
	}
	.pictureGallery__searchBox{
		display: inline-block;
		width: 240px;
		height: 32px;
		line-height: 32px;
		margin: 20px 0px;
		text-align: left;
		background:rgba(255,255,255,0.5);
		padding:0 10px;
		color:#FFF;
		border:1px solid #fff;
		border-radius: 5px;

		-webkit-transition: padding 0.3s,background 0.3s,border 0.3s;
		-o-transition: padding 0.3s,background 0.3s,border 0.3s;
		transition: padding 0.3s,background 0.3s,border 0.3s;
	}
	.pictureGallery__searchBox:focus{
		padding:0 20px;
		box-shadow: 0px 0px 5px rgba(0, 188, 212, 0.67);
		border-color:#0af;
		background:rgba(0,0,0,0.2);
	}
	.pictureGallery__searchButton{
		border: 1px solid #fff;
		border-radius: 5px;
		height: 32px;
		line-height: 32px;
		padding:0px 10px;
		background:transparent;
		color:#fff;
		cursor: pointer;
		-webkit-transition: background 0.3s;
		-o-transition: background 0.3s;
		transition: background 0.3s;
	}
	.pictureGallery__searchButton:hover,.pictureGallery__searchButton:focus{
		background: rgba(255,255,255,0.3);
	}
</style>

<script>
    import {mapState} from 'vuex';
    import {mapMutations} from 'vuex';
	// import slide from '../components/index/slide.vue';
	import navbar from '../components/index/navbar.vue';
	import categoriesList from '../components/index/categoriesList.vue';
	import contentTab from '../components/index/contentTab.vue';


	export default{
		name:'SlideContainer',
		data(){
			return {
				defaultPic:"/images/pic3.jpg",
				searchText:"搜索分享",
				total: 1,
				share: {
                    'share_classification_id':0,
                    'abstract':'',
                    'content':'',
                    'pics':[]
                },
                user:{
                	user_id:-9,
					name:"",
					sex:0,
					introduction:"",
					pic:"/images/pic3.jpg"
                },
                hasLogin:false,

                searchString:'',
			}
		},
		mounted(){
        	//this.getUserInfo();
			
        },
		components:{
			// slide,
			navbar,
			categoriesList,
			contentTab,
		},
		computed:{
			...mapState([
        	]),
        	
        },
		methods:{
			 ...mapMutations([
            ]),
			
			getAllCategory(){
				this.$http.get(this.$homeUrl('getAllClassification')).then((response) => {
                    this.$set(this, 'categories', response.body);

                },
                (response) => {


                });
			},
			initText(){
				if(this.searchText===""){
					this.searchText="搜索分享";
				}
			},
			clearText(){
				this.searchText="";
			},
			getSearchResult(){
				this.searchText = this.searchText.trim();
				if(this.searchText==="" || this.searchText=="搜索分享"){
					alert("搜索空字段");
					return;
				}
				
				// alert("搜索  "+this.searchText);
				this.searchString = this.searchText;
			//传this.searchText,获取分享

			},
			// getUserInfo(){
			// 	this.$http.get(this.$adminUrl('getUserMsg')).then((response) => {

   //                  this.$set(this, 'user', response.body);
   //                  this.checkLogin();
   //              },
   //              (response) => {

   //                  alert('fail in getting data!');

   //              });
			// },
			// checkLogin(){
			// 	if(this.user.user_id>=0){
			// 		this.hasLogin=true;//user_id不存在或者小于0表示未登录
			// 	}else this.hasLogin=false;
			// },
			//logout(){
				//this.$http.post('/logout').then((response)=>{
				//	console.log('logout成功');
				//	return true;
				//},(response)=>{
				//	console.log('logout失败');
				//	return false;
				//})
			// }
		},
	};

</script>