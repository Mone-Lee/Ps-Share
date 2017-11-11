/**
*   图片轮播组件
*   描述：这是个图片轮播组件，图片来源可在/js/vuex/index.js中设置。
*
*   arrow {Boolean} : 切换上一张、下一张的箭头按钮
*   pages {Boolean} : 图片分页导航按钮
*   
*/

<template>
	<div class="c-slider">
		<div class="c-slider__body">
			<div 
                v-for="item in imageList"
                class="c-slider__item" 
                :style="item.style">
                <img :src="$img(item.img)">
            </div>
            
		</div>
		<div class="c-slider__arrow" v-show="arrow">
			<span class="c-slider__prev" @click="sliderPrev">prev</span>
			<span class="c-slider__next" @click="sliderNext">next</span>
		</div>
		<ul class="c-slider__pages" v-show="pages">
			<li v-for="i in imageList.length" 
			    :class='{active:slideParams.currentPage == i-1}'
			    @click='turnToPage(i-1)'>
			</li>
		</ul>
		<div class="c-slider__favourite" v-show="favourite">
        	<i class="glyphicon glyphicon-star"></i>
        	<strong v-show="!statusCollection" @click="collect">收藏</strong>
        	<strong v-show="statusCollection" @click="deleteCollect">取消收藏</strong>
        </div>
	</div>
</template>

<style lang="sass">
	
	$component-name:c-slider;

	.#{$component-name}{
		position:relative;
		top:0;
		left:0;
	  	overflow: hidden;
	  
	  &__item{
	    position: absolute;
	    width: 100%;
	    height: 100%;
	    transition: 0.4s ease-in-out transform, opacity;
	    -webkit-transition: 0.4s ease-in-out transform, opacity;
	    -webkit-transition-duration: 0.4s;
	    -webkit-transition-timing-function: ease-in-out;
	    
	    img{
	      width:100%;
		    height:100%;
	    }
	  }
	  
	  &__arrow{
	    span{
	      display:block;
	    	position: absolute;
	      top: 50%;
	    	width: 20px;
	      height: 35px;
	    	z-index: 998;
	    	text-indent:-99999px;
	    }
	  }
	  
	  &__prev{
	    left: 13px;
	    background: url(/images/arrow-prev.png) no-repeat 0 0;
	    
	    &:hover{
	    	background-position: 0 -35px;
	    }
	  }
	  
	  &__next{
		  right: 13px;
	    background: url(/images/arrow-next.png) no-repeat 0 0;
	    &:hover{
	    	background-position: 0 -35px;
	    }
	  }
	  
	  &__pages{
	  	position:absolute;
	  	list-style: none;
	  	left: 50%;
	  	bottom: 10px;
	  	
	  	li{
	    	width: 8px;
	    	height: 8px;
	    	border-radius: 50%;
	    	background: #fff;
	    	margin: 10px 5px;
	    	cursor: pointer;
	    	display: inline-block;
	    	vertical-align: middle;
	    	
	    	&.active{
	    	  width: 14px;
	      	height: 14px;
	      	border: 2px solid #FFFE00;
	      	background: none;
	      	margin-left: 0;
	    	}
	    }
	  }
	  
	  &__favourite {
	  	position: absolute;
	  	right:20px;
	  	bottom:20px;
	  	width:100px;
	  	height:100px;
	  	border: 1px solid #fff;
	  	
	  	i{
	    	display:inline-block;
	    	width:50px;
	    	height:50px;
	    	border:1px dotted #fff;
	    }
	    strong{
	    	color:#fff;
	    }
	  }
	}
</style>

<script>
	import { mapState } from 'vuex';
	import { mapMutations } from 'vuex';
	

	export default{
        name:'slider',
        mounted(){
        	this.start(this); 
        	this.getShareId();
			this.getCollectionId(); 
			this.getstatusCollection();      	
        },
        data(){
	    	return {
	    		timer:'',
	    		shareDetail:'',
				shareId:'',
				collection:[],
				statusCollection:'',
	    	}
	    },
	    props:{
	    	arrow:{
	    		type:Boolean,
	    		default:false,
	    	},
	    	pages:{
	    		type:Boolean,
	    		default:false,
	    	},
	    	favourite:{
	    		type:Boolean,
	    		default:false,
	    	},
	    },
        computed:mapState([
            'imageList',
            'slideParams',
        ]),
        
        methods:{
        	...mapMutations([
		      'prev',
		      'next',
		      'turnTo',
		      'changeTransform',
		    ]),
		    start(obj){
        		clearTimeout(this.timer);
		    	this.timer = setTimeout(obj.sliderNext,2000);
		    },
		    /*上一张*/
		    sliderPrev(){
		    	var me = this;
		    	this.imageList.forEach(
		    		function(page,index){
		    			me.currentCompute(page,false);
		    		}
		    	)
		    	this.prev();
		    	this.start(this);
		    },
		    /*下一张*/
		    sliderNext(){
		    	var me = this;
		    	this.imageList.forEach(
		    		function(page,index){
		    			me.currentCompute(page,true);
		    		}
		    	)
		    	this.next();
		    	this.start(this);
		    },
		    /*跳转页*/
		    turnToPage(num){
		    	var previousP = this.slideParams.currentPage;
		    	
		    	var currentP = num;
		    	var step = currentP - previousP;

		    	var isNext = step > 0 ? true : false;

		    	var me = this;
		    	this.imageList.forEach(
		    		function(page,index){
		    			if(isNext){
		    				page.current = page.current - step * 100;
		    			}else{
		    				page.current = (-num) * 100;
		    			}
		    			me.scrollPage(page);
		    		}
		    	)

		    	this.turnTo(num);

		    	this.start(this);
		    },
		    currentCompute(page,isNext){
		    	if(isNext){
		    		if(this.slideParams.currentPage == this.imageList.length -1){
		    			page.current = 0;
		    		}else{
		    			page.current = page.current - 100;
		    		}
		    	}else{
		    		if(this.slideParams.currentPage == 0){
		    			page.current = page.current - (this.imageList.length -1)*100;
		    		}else{
		    			page.current = page.current + 100;
		    		}
		    	}
		    	this.scrollPage(page);
		    },
		    scrollPage(page){
		    	this.changeTransform(page);
		    }, 
		    getShareId(){
				var href = [];
				href = location.href.split('/');
				var shareId = href[href.length-1];
				this.shareId = parseInt(shareId);
			},
			getCollectionId(){
				this.$http.get(this.$adminUrl('collectionClassification')).then((response)=>{
					this.$set(this,'collection',response.body);
				},(response)=>{
					alert('fail in getting data!');
				})
			},
			getstatusCollection(){
				this.$http.get(this.$homeUrl('getShareDetail/')+ this.shareId ).then((response)=>{
					this.$set(this,'shareDetail',response.body);
					if(this.shareDetail.statusCollection !== null){
						this.statusCollection = true;
					}else{
						this.statusCollection = false;
					}
				},(response)=>{
					alert('fail in getting data!');
				})
			},
			/*收藏*/
			collect(){
				var collectionClassification_id = this.collection[0].collectionClassification.id;
				console.log(this.shareId);
				console.log(collectionClassification_id);
				this.$http.post(this.$adminUrl('collection'),{'share_id':this.shareId,'collection_classification_id':collectionClassification_id}).then((response)=>{
					if(response.body != 'false') {
						this.statusCollection = true;
						return true;
                    }else {
                        console.log('fail in collecting!');
                    }
				},(response)=>{
					console.log(response.body);
				})
			},
			/*取消收藏*/
			deleteCollect(){
				this.$http.delete(this.$adminUrl('collection/') + this.shareId ).then((response) => {
					if(response.body != 'false'){
						this.statusCollection = false;
						return true;
					}else{
						console.log('fail in deleteCollecting!');
					}
				},(response) => {

				})
			},  
        },
    };

</script>