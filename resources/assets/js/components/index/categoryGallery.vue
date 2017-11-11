<template>
	<div>
		
		<div v-for="(classContent,index) in classContentList" 
			 class="c-picGallery" 
			 @mouseover="showOther(index)" 
			 @mouseleave="hideOther(index)"
			  >
			<div class="c-picGallery__platform">
				<img :src="$img(classContent.pictures[0].path)">
			</div>
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
	</div>
	<!-- <div>
		<div class="classContent">
			{{ classId }}
			<div v-for="(classContent,index) in classContentList" 
				 class="c-picGallery" 
				 @mouseover="showOther(index)" 
				 @mouseleave="hideOther(index)">
				<div class="c-picGallery__platform">
					<img :src="$img(classContent.pictures[0].path)">
				</div>
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
		</div>
	</div> -->
</template>

<style>

	.c-picGallery{
		border:1px solid #eee;
		margin-left: 15px;
		margin-top:15px;
		display: inline-block;
		padding-bottom: 70px;
		position:relative;
	}
	.c-picGallery:hover{
		box-shadow: 2px 2px 2px #ccc;
	}
	.c-picGallery__platform{
		width: 100%;
    	height: 200PX;
		margin-bottom: 1%;
		background-position:center;
		background-repeat: no-repeat;
	}
	
	.c-picGallery__summary{
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
	.c-picGallery__otherContainer{
		width:100%;
		position:relative;
		bottom:6px;

	}
	.c-picGallery__other{
		position:absolute;
		
		width:16%;
		height:65px;
		display: inline-block;
		margin:5px 2px;
		border:1px solid #ccc;
	}
	.c-picGallery__other img{
		width:100%;
		height:100%;
	}
	.c-picGallery__intro{
		width:94%;
		margin:5px auto;
		font-size:14px;
		bottom:6px;
	}
	.c-picGallery__intro p{
		display: inline-block;
		padding-left: 3px;
		color:#484848;
	}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
<script>
	export default{
		name:'categoryGallery',
		data(){
			return {
				over:false,
				allShares:[],
				allSharesLength:0,
				sharesStatus:[],


				classSharesLength:0,
				classShares:[],
				classContentList:[],

			}
		},
		props:{
			classId:{
				type:Number,
			},
			categories:{
	    		type:Array,
	    	},
		},
		mounted(){
			// this.getAllShares();
			// this.queryShare();
			this.getQueryShare();
		},
		methods:{	
			getAllShares(){
				this.$http.get(this.$homeUrl('getAllShares')).then((response) =>{

					this.$set(this,'allShares',response.body.data);	
					
					this.allSharesLength = this.allShares.length;
					for(var i=0;i<this.allSharesLength;i++){
						this.sharesStatus[i] = false;
					}
					this.classContentList = this.allShares;

				},(response)=>{
					alert('fail in getting allShares!');
				})
			},
			/*按分类获取所有分享*/
			queryShare(){
				this.$http.get(this.$homeUrl('queryShare'),{params:{classificationId:this.classId}}).then((response) =>{

					this.$set(this,'classShares',response.body.data);	
					
					this.classSharesLength = this.classShares.length;
					console.log(this.classSharesLength);
					for(var i=0;i<this.classSharesLength;i++){
						this.sharesStatus[i] = false;
					}
					this.classContentList[i] = this.classShares[i];
				},(response)=>{
					alert('fail in getting allShares!');
				})
			},

			/*根据传过来的分类id，按分类获取所有分享*/
			getQueryShare(){
				if(this.classId === -1){
					console.log(this.classId === -1)
					this.getAllShares();
					console.log(this.allShares.length);
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
		    }

		},

	};

</script>