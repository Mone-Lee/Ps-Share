/**
*   contentTab
*   描述：首页显示tab组件
*
*   tabIndex {Array} : 热门，点赞数，最新 
*   pageIndex {Boolean} : 分页条
*   
*/
<template>
	<section class="contentTab">
		<p class="contentTab__title">RANKING</p>
		<ul class="contentTab__index">
			<li v-for="(item, index) in tabIndex" class="contentTab__index-item fadeLink"><a @click.prevent="showContent(index)" :class="index == classification ? 'selected' : ''">{{ item }}</a></li>
		</ul>
		<div class="contentTab__contain">
			<div v-for="(allLikesItem,index) in allLikesBoard" 
				 class="r-picGallery" 
				 @mouseover="showOther(index)" 
				 @mouseleave="hideOther(index)" >
				<a :href="'/home/p/share-detail/'+allLikesItem.share_id"><div class="r-picGallery__platform" >
					<img :src="$img(allLikesItem.share_first_picture)" style="width:100%;height:100%">
				</div></a>
				<div class="r-picGallery__intro">
					<p class="r-picGallery__introTitle">{{allLikesItem.share_abstract}}<small>By:{{"  "+allLikesItem.user_name+"    "+allLikesItem.share_created_at.split(" ")[0]}}</small></p>
					<p class="r-picGallery__introText">简介:{{allLikesItem.share_content}}</p>
					<p class="r-picGallery__introLike"><i class="fa fa-heart" aria-hidden="true"></i>like:{{allLikesItem.total_likes}}</p>
				</div>
			</div>
			<paginator
	            :total="total"
	            url="getLikesBoard"
	            :paginatorParams="{type:type}"
	            :isAdmin="isAdmin"
	            @result="setAllShares"
	    	></paginator>
		</div>
	</section>
</template>


<style>
	.contentTab{
		width: 100%;
		min-height:400px; 
		background: #fff;
		margin-top: 10px;
	}
	.contentTab__index,.contentTab__title{
		height: 48px;
		line-height: 48px;
		margin-left: 20px;
		font-size: 16px;
		margin-bottom: 10px;
		display: inline-block;
		color:#aaa;
	}
	.contentTab__title{
		font-size: 24px;
		margin-left: 0px;
	}
	.contentTab__index-item {
		display: inline-block;
		padding: 3px 10px;
	}
	.contentTab__index-item>a {
		-webkit-transition: padding 0.2s,background 0.2s,color 0.2s;
		-o-transition: padding 0.2s,background 0.2s,color 0.2s;
		transition: padding 0.2s,background 0.2s,color 0.2s;
		border-radius: 8px;
		padding:0px;
		cursor: pointer;
	}
	.contentTab__index-item>a:hover {
		background:#eee;
		padding:10px 20px;
		color: #2a2a2a;
	}
	.contentTab__contain{
		margin-left: 20px;
	}
	.contentTab__index-item>a.selected{
		background:#eee;
		padding:10px 20px;
		color: #2a2a2a;
	}
	.c-picGallery{
		width:300px;
		height:auto;
	}
</style>

<script>
	import { mapState } from 'vuex';
	import { mapMutations } from 'vuex';
	import pictureGallery from './pictureGallery.vue';

	export default{
        name:'contentTab',
        components:{
        	pictureGallery,
        },
        mounted(){	
        	this.tabContent="获取tab显示数据...";
        	this.showContent(0);
        	this.getLikesBoard();
        },
        data(){
	    	return {
	    		tabIndex:["全部","最近一周","今天"],
	    		tabContent:"",
	    		classification:0,
	    		over:false,
				allLikesBoard:[],
				allSharesLength:0,
				sharesStatus:[],
				total: 1,
				isAdmin: false,
				type: 0,
	    	}
	    },
	    props:{
	    	
	    	
	    },
        computed:mapState([
        	'tabContents',
        ]),
        
        methods:{
        	...mapMutations([
		      'loadContent'
		    ]),
        	showContent(index){
        		this.loadContent();
        		this.tabContent=this.tabContents[index];
        		this.classification = index;
        		this.type = index;
        		this.getLikesBoard(index);
        	},
        	getLikesBoard(type=0){
				this.$http.get(this.$homeUrl('getLikesBoard'),{params:{type:type}}).then((response)=>{
					this.$set(this,'allLikesBoard',response.body.data);
					this.total = response.body.last_page;
				},(response)=>{
					alert('fail in getting likesBoard!');
				})
			},
			showOther(index){
				this.sharesStatus.splice(index,1,true);
			},
			hideOther(index){
				this.sharesStatus.splice(index,1,false);
			},
			beforeEnter: function (e) {
				e.style.opacity = 0
				e.style.bottom = -60
		    },
		    afterEnter: function (e) {
		    	if (window.jQuery) { var Velocity = $.Velocity; }
				var delay = (e.dataset.index-1) * 200
				setTimeout(function () {
					Velocity(
					  e,
					  { opacity: 1, bottom: -13 },
					  
					)
				}, delay)
		    },
		    leave: function (e,done) {
		    	if (window.jQuery) { var Velocity = $.Velocity; }
				var delay = (e.dataset.index-1)* 200
				setTimeout(function () {
					Velocity(
					  e,
					  { opacity: 0, bottom: -60 },
					  { complete: done },
					)
				}, delay)
		    },
		    setAllShares(shares){
				this.$set(this,'allLikesBoard',shares.data);
				this.total = shares.last_page;
		    }
        }

    };
</script>