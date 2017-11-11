<template >
	<section class="contentTab">
		<p class="contentTab__title">FAVORITE</p>
		<ul class="contentTab__index">
			<li v-for="(item, index) in shareClassifications" class="contentTab__index-item fadeLink"><a @click.prevent="showContent(index)" :class="index == classification ? 'selected' : ''">{{ item.name }}</a></li>
		</ul>
		<div class="r-picGallery__intro">
			<div v-for="(datas, index) in shares" 
				 class="r-picGallery" >
				<a :href="'/home/p/share-detail/'+datas.share.id"><div class="r-picGallery__platform"  :style="'background-image:url('+$img(datas.pictures[0].path)+')'">
				</div></a>
				<div class="r-picGallery__intro">
					<p class="r-picGallery__introTitle">{{datas.share.abstract}}<small>{{datas.share.created_at.split(" ")[0]}}</small></p>
					<p class="r-picGallery__introText">简介:{{datas.share.content}}</p>
				</div>
			</div>
		</div>
		<!-- <div class="contentTab__contain">
			<picture-gallery :classification="classification"></picture-gallery>
		</div> -->
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
	import {mapState} from 'vuex';
	import pictureGallery from '../index/pictureGallery.vue';
	export default{
       name:'userContent',
		data(){
			return{}
		},
		computed:mapState([
            'shares',
            'shareClassifications'
        ]),
		mounted () {
			
		},
        components:{
        	pictureGallery,
        },
		methods: {
			
        }        
    }
</script>

