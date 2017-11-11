<template>
	<div class="c-pop" v-show="isShow">
		<div class="c-pop__overlay"></div>
		<div class="c-pop__content" >
			<slot></slot>
		</div>	
	</div>

</template>
	
<style>
	.c-pop{
		width:100%;
		height:100%;
		position: relative;
	}
	.c-pop__overlay{
	    background-color:#808080;
		width:100%;
		height:100%;
		opacity:0.7;
		z-index:9999;
		position: fixed;
		top:0;
		left: 0;
	}
	.c-pop__content{
	}

	.fade-enter-active,.fade-leave{
		transition:opacity .5s;
	}
	.fade-enter,.fade-leave-active{
		opacity:0;
	}
	
</style>

<script>
	
	export default{
		name:'PopFrame',
		mounted(){
			// var overlay = document.getElementById('overlay')
			// document.addEventListener('click',(e) => {
			// 	console.log(overlay);
			// 	console.log(e.target);
			// 	if(e.target == overlay) this.show = false;
			// })
		},
		data(){
			return {
				show:true,
			}
		},
		props:{
			isShow:{
				type:Boolean,
	    		default:false,
			},
		},
		computed:{
			// show(){
			// 	return this.isCollect;
			// }
		},
		methods:{
		},
	}

</script>