/**
*   导航条
*   描述：导航条组件
*
*   brand {name: Logo名, url: 首页地址} : 网站导航标题
*   navItems : 网站导航列表，可在/js/vuex/index.js中设置。
*
*/
<template>
	<nav class="navbar">
		<a :href="brand.url" :title="brand.name" class="navbar__brand">
			{{ brand.name }}
		</a>

		<ul class="navbar__links">
			<li v-for="item in navItems">
				<a v-if="item.isImg" :href="item.url"><img  class="navbar__portrait" :src="item.src" :title="item.intro" :alt="item.intro"></a>
				<p v-if="item.isText">{{ item.text }}</p>
				<a v-if="item.isLink" class="navbar__link fadeLink"  v-on:click="updateLogState">{{ item.text }}</a>
			</li>
		</ul>
	</nav>
</template>


<style>
	.navbar{
		width: 100%;
		height: 52px;
		line-height: 52px;
		overflow: hidden;
		display:block;
		margin:0 auto;
		z-index:999;
		border-bottom: 1px solid #eee !important;
		background: #fff;
		box-shadow: 0 0 9px 0px #ddd;
	}
	.navbar__brand{
		font-size: 24px;
		padding: 0px 20px;
		margin: 0px 5px;
		color:#aaa;		
	}
	.navbar__links{
		float: right;
		margin: 0px 10px;
	}
	.navbar__links>li{
		display: inline-block;
		padding: 0px 5px;
		margin: 0px 5px;
	}
	.navbar__portrait{
		width: 32px;
		height: 32px;
		display: inline-block;
		border-radius: 50%;
		border:2px dashed #aaa;
		vertical-align:middle;
		background:#fff;
	}
	.navbar__link{
		cursor: pointer;
	}
	
</style>

<script>
	import { mapState } from 'vuex';
	import { mapMutations } from 'vuex';

	export default{
        name:'navbar',
        mounted(){	
        	this.getUserInfo();
        },
        data(){
	    	return {
	    		brand:{
	    			name:"Ps-Share",
	    			url:"/home/p/index"
	    		},
	    		user:{
	    			type:Object
	    		},
	    		hasLogin:{
	    			type: Boolean,
	    			default: false
	    		}
	    	}
	    },
	    props:{
	    },
        computed:{
        	...mapState([
        	]),

        	navItems () {
        		if(this.hasLogin){
					return [
						{isImg:true, intro:"头像", src:'/'+this.user.pic,url:"/admin/p/user-index/"+this.user.user_id,intro:this.user.introduction,url:"/admin/p/user-index/"+this.user.user_id},
						{isText:true, text:this.user.name},
						{isLink:true, text:"个人管理", url:"/admin/p/user-manage"},
						{isLink:true, text:"退出登陆", url:"/logout"}
					]
				}else{
					return [
						{isImg:true, intro:"头像", src:"/images/pic3.jpg"},
						{isText:true, text:"欢迎你，游客"},
						{isLink:true, text:"登陆", url:"/login"}
					]
				}
        	}
        },

        methods:{
        	updateLogState(e){
        		var target = e.target;
        		if(target.innerHTML==="个人管理"){
        			window.location.href="/admin/p/user-manage";
        		}
        		else{
        			if(this.hasLogin){
        				this.$http.post('/logout').then((response) => {
        					this.hasLogin=false;
        					window.location.reload();
        				},
        				(response) => {
        					alert('fail in logout!');

        				});
        			}else{
        				this.$http.get('/login').then((response) => {
        					window.location.href="/login";
        				},
        				(response) => {
        					alert('fail in login!');

        				});
        			}
        		}
        		
        		
        	},
        	getUserInfo(){
        		this.$http.get(this.$adminUrl('getUserMsg')).then((response) => {
        			console.log(this.$adminUrl('getUserMsg'))
        			this.$set(this, 'user', response.body);
        			this.checkLogin();
        			this.$emit('getUserMsg', this.user);
        		},
        		(response) => {

        			alert('fail in getting userInfo!');

        		});
        	},
        	checkLogin(){
        		if(this.user.user_id>=0){
					this.hasLogin=true;//user_id不存在或者小于0表示未登录
				}else this.hasLogin=false;
			},
		}
	};
</script>