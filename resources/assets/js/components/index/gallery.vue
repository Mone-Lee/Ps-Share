<template>
	<div class="c-gallery">
		<div
			v-for="(item,index) in imageList" 
			class="c-gallery__item"
			:class="{selected: slideParams.currentPage == index}"
		>
			<img :src="item.img">
		</div>
	</div>
</template>

<style lang="sass">

	$component-name:c-gallery;

	@mixin prefix($property,$value:1){
	  -webkit-#{$property}:$value;
	  -moz-#{$property}:$value;
	  #{$property}:$value;
	}

	.#{$component-name}{
			display:box;
			display:-webkit-box;
			display:-moz-box;
			
			&__item{
			  @include prefix(box-flex,1);
			  padding:10px;
	    	border:1px solid #ccc;
	    	margin-left:5px;
	    	margin-right:5px;
	    	height:100%;
	    	
	    	img{
		    	  width:100%;
			      height:100%;
		    	}
			}
			
	}
	.selected{
		border:2px solid blue;
	}


</style>

<script>
	import {mapState} from 'vuex';

	export default{
		name:'gallery',

		computed:mapState([
            'imageList',
            'slideParams',
        ]),

	};
</script>