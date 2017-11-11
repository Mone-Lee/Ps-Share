/**
*   分类列表
*   描述：首页 分类列表组件
*
*   categories {url:连接,text:分类名} 
*   
*/
<template>
	<section class="categories">
		<article>CATEGORY</article>
		<ul class="categories__list">
			<li>
				<a class="categories__Breadcrum fadeLink selected" 
				@click="setClass(-1)" 
				@click.prevent="showCategory(-1)" 
				:class="showAll? 'selected' : ''">全部</a>
			</li>
			<li v-for="(item, index) in categories">
				<a class="categories__Breadcrum fadeLink" 
				@click="setClass(item.id)"
				@click.prevent="showCategory(index)" 
				:class="index == category ? 'selected' : ''">{{ item.name }}</a>
			</li>
		</ul>
		<div v-for="(classContent,index) in classContentList" 
			 class="c-picGallery" 
			 @mouseover="showOther(index)" 
			 @mouseleave="hideOther(index)"
			  >
			<a :href="'/home/p/share-detail/'+classContent.share.id" target="_blank">
				<!-- <div class="c-picGallery__platform" :style="'background-image:url('+$img(classContent.pictures[0].path)+')'">
				</div> -->
				<div class="c-picGallery__platform" 
					 v-for="(picture,i) in classContent.pictures" 
					 v-if="i == 0">
					<img :src="$img(picture.path)" style="width:100%;height:100%">
				</div>
				<!-- {{classContent.pictures[0]}} -->
			</a>
			<p class="c-picGallery__summary" v-show="!sharesStatus[index]">
				{{classContent.share.content}}
			</p>
			<div class="c-picGallery__otherContainer" >
				<transition-group
				    name="staggered-fade"
				    tag="div"
				    v-bind:css="false"
				    v-on:before-enter="beforeEnter($event)"
				    v-on:after-enter="afterEnter($event)"
				    v-on:leave="leave($event)"
				  >
				    <div class="c-picGallery__other other-Picture" 
						 v-for="(picture,i) in classContent.pictures" 
						 v-if="i > 0"
						 v-show="sharesStatus[index]"
						 v-bind:key="i"
						 v-bind:data-index="i"
						 >
						<img :src="$img(picture.path)">

					</div>
				</transition-group>
			</div>
		</div>
		<paginator
            :total="total"
            url="queryShare"
            :paginatorParams="{param:this.searchString,classificationId:this.classId}"
            :isAdmin="isAdmin"
            @result="setAllShares"
    	></paginator>
	</section>
</template>


<style>
	.categories{
		font-family: "Microsoft YaHei";
		color:#aaa;
		width: 100%;
		background: #fff;
		margin: 0 auto;
		overflow: hidden;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
		padding: 20px 0px;
		border-bottom: 1px solid #ccc;
	}
	.categories article{
		font-size:24px;
		line-height: 24px;
		display: inline;
		margin-right: 10px;
		vertical-align: middle;
	}
	.categories__list{
		margin: 20px;
	}	
	.categories__list>li{
		display: inline-block;
		margin-left:10px;
	}
	.categories__Breadcrum{
		height: 32px;
		line-height: 32px;
		background: #eee;
		border:1px solid #EEE;
		padding: 5px 10px;
		margin: 0px 5px; 
		font-size: 14px; 
		cursor: pointer;
		
	}
	.categories__Breadcrum:before{
		content: "•";
		margin-right: 5px;
	}
	.selected{
		text-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
		color: rgba(0, 0, 0, 0.6);
	}
	.r-picGallery__intro{
		width:94%;
		font-size:14px;
		position: relative;
		margin:10px 0px 20px 0px; 
		padding-left:10px; 
	}
	.r-picGallery__intro p{
		color:#2a2a2a;
	}
	.r-picGallery__introTitle{
		color:#555;
		font-size: 1.2em;
		padding-bottom: 20px;
		border-bottom: 1px dashed #ccc;
		margin-bottom: 10px;
		position: relative;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		width: 270px;
	}
	.r-picGallery__introTitle>small{
		font-size: 0.6em;
		position: absolute;
		bottom: 2px;
		right: 0px;
	}
	.r-picGallery__introLike{
		position: absolute;
		right:10px;
		bottom: -20px;
	}

</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
<script>
	import { mapState } from 'vuex';
	import { mapMutations } from 'vuex';
	import categoryGallery from './categoryGallery.vue';

	export default{
        name:'categoriesList',
        components:{
        	categoryGallery,
        },
        mounted(){	
        	this.showCategory(-1);
        	this.getAllCategory();
        	this.setClass(-1);
        	this.$watch('searchString',function(){
		    	this.searchShare();
		    });
        },
        data(){
	    	return {
	    		showAll:true,
	    		categories:[],
	    		classId:-1,
	    		

	    		allShares:[],
				allSharesLength:0,
				sharesStatus:[],


				classSharesLength:0,
				classShares:[],
				classContentList:[],

				searchShares:[],
				searchSharesLength:0,

				total: 0,
				isAdmin: false,


	    	}
	    },
	    props:{
	    	searchString:{
	    		type:String,
	    		default:'',
	    	}
	    	
	    },
        computed:mapState([
        ]),
        
        methods:{
        	showCategory(index){
        		this.category = index;
        		if(index===-1){
        			this.showAll=true;
        		}else{
        			this.showAll=false;

        		}
			},
			getAllCategory(){
				this.$http.get(this.$homeUrl('getAllClassification')).then((response) => {
                    this.$set(this, 'categories', response.body);
                },
                (response) => {
                });
			},
			getAllShares(){
				this.$http.get(this.$homeUrl('getAllShares')).then((response) =>{

					this.$set(this,'allShares',response.body.data);
					this.total = response.body.last_page;
					
					this.allSharesLength = this.allShares.length;
					for(var i=0;i<this.allSharesLength;i++){
						this.sharesStatus[i] = false;
					}
					this.classContentList = this.allShares;

				},(response)=>{
					alert('fail in getting allShares!');
				})
			},
			queryShare(){
				this.$http.get(this.$homeUrl('queryShare'),{params:{classificationId:this.classId}}).then((response) =>{

					this.$set(this,'classShares',response.body.data);	
					this.classSharesLength = this.classShares.length;
					for(var i=0;i<this.classSharesLength;i++){
						this.sharesStatus[i] = false;
					}
					this.classContentList = this.classShares;
				},(response)=>{
					alert('fail in getting queryShare!');
				})
			},
			setClass(classId){
				this.classId = classId;
				
				if(this.classId === -1){
					this.getAllShares();
				}else{
					this.queryShare();
				}
			},
			showOther(index){
				this.sharesStatus.splice(index,1,true);
			},
			hideOther(index){
				this.sharesStatus.splice(index,1,false);
			},
			beforeEnter: function (e) {
				e.style.opacity = 0
				e.style.bottom = -120
		    },
		    afterEnter: function (e) {
		    	if (window.jQuery) { var Velocity = $.Velocity; }
				var delay = (e.dataset.index-1) * 200
				setTimeout(function () {
					Velocity(
					  e,
					  { opacity: 1, bottom: -80 },
					  
					)
				}, delay)
		    },
		    leave: function (e,done) {
		    	if (window.jQuery) { var Velocity = $.Velocity; }
				var delay = (e.dataset.index-1)* 200
				setTimeout(function () {
					Velocity(
					  e,
					  { opacity: 0, bottom: -120 },
					  { complete: done },
					)
				}, delay)
		    },
		    skipTo:function(href){
		    	window.open("http://127.0.0.1:8080/home/p/share-detail/"+href);
		    },

		    /*搜索分享*/
		    searchShare(){
		    	if(this.classId === -1){
		    		this.$http.get(this.$homeUrl('queryShare'),{params:{param:this.searchString}}).then((response) =>{

						this.$set(this,'searchShares',response.body.data);	
						this.searchSharesLength = this.searchShares.length;
						for(var i=0;i<this.searchSharesLength;i++){
							this.sharesStatus[i] = false;
						}
						this.classContentList = this.searchShares;
					},(response)=>{
						alert('fail in getting queryShare!');
					})
		    	}else{
		    		this.$http.get(this.$homeUrl('queryShare'),{params:{param:this.searchString,classificationId:this.classId}}).then((response) =>{

						this.$set(this,'searchShares',response.body.data);	
						this.searchSharesLength = this.searchShares.length;
						for(var i=0;i<this.searchSharesLength;i++){
							this.sharesStatus[i] = false;
						}
						this.classContentList = this.searchShares;
					},(response)=>{
						alert('fail in getting queryShare!');
					})
		    	}
		    },

		    setAllShares (shares){
		    	this.$set(this, 'allShares', shares.data);
		    	this.total = shares.last_page;
				
				this.allSharesLength = this.allShares.length;
				for(var i=0;i<this.allSharesLength;i++){
					this.sharesStatus[i] = false;
				}
				this.classContentList = this.allShares;
		    }

		    
        }

    };
</script>