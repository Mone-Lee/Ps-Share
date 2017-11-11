/**
*   userContentTab
*   描述：用户显示tab组件
*
*   tabIndex {Array} : 热门，点赞数，最新 
*   pageIndex {Boolean} : 分页条
*   
*/
<template>
	<section class="contentTab">
		<p class="contentTab__title">FAVORITE</p>
		<ul class="contentTab__index">
			<li v-for="(item, index) in tabIndex" class="contentTab__index-item fadeLink"><a @click.prevent="showContent(index)" :class="index == classification ? 'selected' : ''">{{ item }}</a></li>
		</ul>
		<div class="contentTab__contain">
			<picture-gallery :classification="classification"></picture-gallery>
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
        name:'userContentTab',
        components:{
        	pictureGallery,
        },
        mounted(){	
        	this.getUserCategories();
        	this.showContent(0);

        },
        data(){
	    	return {
	    		tabIndex:[],
	    		tabContent:"",
	    		classification:0,
	    		collectionClassifications:[]
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
        	},
        	getUserCategories(){
        		 this.$http.get(this.$adminUrl('collectionClassification')).then((response) => {
                    this.$set(this, 'collectionClassifications', response.body);
                    var _self = this;
                    this.collectionClassifications.forEach(function  (elem,index) {
                    	_self.tabIndex.push(elem.collectionClassification.name);
                    })
                    
                },
                (response) => {

                    alert('fail in getting data!');

                });
        	}
        }

    };
</script>