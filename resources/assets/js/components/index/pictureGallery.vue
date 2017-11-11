<template>
	<div>
		<div v-for="(allLikesItem,index) in allLikesBoard" 
			 class="r-picGallery" 
			 @mouseover="showOther(index)" 
			 @mouseleave="hideOther(index)"
			 v-show="classification == 0" >
			<a :href="'/home/p/share-detail/'+allLikesItem.share_id" target="_bank"><div class="r-picGallery__platform"  :style="'background-image:url('+$img(allLikesItem.share_first_picture)+')'">
			</div></a>
			<div class="r-picGallery__intro">
				<p class="r-picGallery__introTitle">{{allLikesItem.share_abstract}}<small>By:{{"  "+allLikesItem.user_name+"    "+allLikesItem.share_created_at.split(" ")[0]}}</small></p>
				<p class="r-picGallery__introText">简介:{{allLikesItem.share_content}}</p>
				<p class="r-picGallery__introLike"><i class="fa fa-heart" aria-hidden="true"></i>赞:{{allLikesItem.total_likes}}</p>
			</div>
		</div>
		<div v-for="(weekLikesItem,index) in weekLikesBoard" 
			 class="r-picGallery" 
			 @mouseover="showOther(index)" 
			 @mouseleave="hideOther(index)"
			 v-show="classification == 1" >

			
			<a :href="'/home/p/share-detail/'+weekLikesItem.share_id" target="_bank"><div class="r-picGallery__platform"  :style="'background-image:url('+$img(weekLikesItem.share_first_picture)+')'">
			</div></a>
			<div class="r-picGallery__intro">
				<p class="r-picGallery__introTitle">{{weekLikesItem.share_abstract}}<small>By:{{"  "+weekLikesItem.user_name+"    "+weekLikesItem.share_created_at.split(" ")[0]}}</small></p>
				<p class="r-picGallery__introText">简介:{{weekLikesItem.share_content}}</p>
				<p class="r-picGallery__introLike"><i class="fa fa-heart" aria-hidden="true"></i>赞:{{weekLikesItem.total_likes}}</p>
			</div>			
		</div>
		<div v-for="(dayLikesItem,index) in dayLikesBoard" 
			 class="r-picGallery" 
			 @mouseover="showOther(index)" 
			 @mouseleave="hideOther(index)"

			 v-show="classification == 2" >

			
			<a :href="'/home/p/share-detail/'+dayLikesItem.share_id" target="_bank"><div class="r-picGallery__platform"  :style="'background-image:url('+$img(dayLikesItem.share_first_picture)+')'">
			</div></a>
			<div class="r-picGallery__intro">
				<p class="r-picGallery__introTitle">{{dayLikesItem.share_abstract}}<small>By:{{"  "+dayLikesItem.user_name+"    "+dayLikesItem.share_created_at.split(" ")[0]}}</small></p>
				<p class="r-picGallery__introText">简介:{{dayLikesItem.share_content}}</p>
				<p class="r-picGallery__introLike"><i class="fa fa-heart" aria-hidden="true"></i>赞:{{dayLikesItem.total_likes}}</p>
			</div>
		</div>
		<paginator
            :total="total"
            url="queryShare"
            :paginatorParams="{}"
            :isAdmin="isAdmin"
            @result="setAllShares"
    	></paginator>
	</div>
</template>

<style>

	.r-picGallery{
		width: 300px;
		border:1px solid #eee;
		margin-left: 15px;
		margin-top:15px;
		display: inline-block;
		position:relative;
	}
	.r-picGallery:hover{
		box-shadow: 2px 2px 2px #ccc;
	}
	.r-picGallery__platform{
		width:100%;
		height:200px;
		background-position:center;
		background-repeat: no-repeat;
		margin-bottom: 1%;
	}
	/*.r-picGallery__platform img{
		width:100%;
		height:100%;
	}*/
	.r-picGallery__summary{
		white-space: nowrap;
		width:94%;
		margin:5px auto;
		overflow:hidden;
		text-overflow: ellipsis;
		font-size:16px;
		height:60px;
		position:absolute;
		bottom:6px;
	}
	.r-picGallery__otherContainer{
		width:100%;
		position:absolute;
		bottom:6px;
	}
	.r-picGallery__other{
		width:16%;
		height:65px;
		display: inline-block;
		margin:5px 2px;
		border:1px solid #ccc;
		position: relative;
	}
	.r-picGallery__other img{
		width:100%;
		height:100%;
		position: absolute;
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
	export default{
		name:'pictureGallery',
		data(){
			return {
				over:false,
				allLikesBoard:[],
				weekLikesBoard:[],
				dayLikesBoard:[],
				allSharesLength:0,
				sharesStatus:[],
				total: 1,
				isAdmin: false,
			}
		},
		props:{
			classification:{
				type:Number,
				dafault:0,
			}
		},
		mounted(){
			this.getAllLikesBoard();
			this.getWeekLikesBoard();
			this.getDayLikesBoard();
		},
		computed(){
		},
		methods:{	
			getAllLikesBoard(){
				this.$http.get(this.$homeUrl('getLikesBoard')).then((response)=>{
					this.$set(this,'allLikesBoard',response.body.data);
				},(response)=>{
					alert('fail in getting likesBoard!');
				})
			},
			getWeekLikesBoard(){
				this.$http.get(this.$homeUrl('getLikesBoard'),{params:{type:2}}).then((response)=>{
					this.$set(this,'weekLikesBoard',response.body.data);
				},(response)=>{
					alert('fail in getting likesBoard!');
				})
			},
			getDayLikesBoard(){
				this.$http.get(this.$homeUrl('getLikesBoard'),{params:{type:3}}).then((response)=>{
					this.$set(this,'todayLikesBoard',response.body.data);
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

		    }

		},

	};

</script>