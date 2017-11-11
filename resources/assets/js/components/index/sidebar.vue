/**
*   sidebar
*   描述：用户页面侧边栏
*/
<template>
	<div>
        <div class="userPortrait">aaaaaaaaaaaaaaaaaaaaa
            <img :src="user.portrait" class="userPortrait-large" alt="">
        </div>
    	<ul class="userOption">
    		<li class="userOption__item" ><a href="">
    		<span class="userOption__item-toRight">></span>
    			关注管理
    		<span class="userOption__item-toLeft"><</span>
    		</a></li>
    		<li class="userOption__item"><a href="">
    		<span class="userOption__item-toRight">></span>
    			分享管理
    		<span class="userOption__item-toLeft"><</span>
    		</a></li>
    		<li class="userOption__item"><a href="">
    		<span class="userOption__item-toRight">></span>
    			收藏管理
    		<span class="userOption__item-toLeft"><</span>
    		</a></li>
    		<li class="userOption__item"><a href="">
    		<span class="userOption__item-toRight">></span>
    			消息管理
    		<span class="userOption__item-toLeft"><</span>
    		</a></li>
    		<li class="userOption__item"><a href="">
    		<span class="userOption__item-toRight">></span>
    			我的足迹
    		<span class="userOption__item-toLeft"><</span>
    		</a></li>
            <li class="userOption__item"><a href="">
            <span class="userOption__item-toRight">></span>
                用户信息
            <span class="userOption__item-toLeft"><</span>
            </a></li>
    	</ul>
    </div>
</template>


<style>
    .userOption{
    	list-style: none;
    	margin: 0px;
    	padding: 0px;
    }
    .userOption__item{
		-webkit-transition: all 0.2s;
		-o-transition: all 0.2s;
		transition: all 0.2s;
		padding: 10px 0px;
    }
    .userOption__item:hover{
		background: #fff;

    }
    .userPortrait{
        margin-bottom: 10px;
        background: #f5f5f5;
        box-shadow: 5px 5px 5px #aaa;
    }
    .userPortrait-large{
    	border-radius: 50%;
    	width: 112px;
    	border: 2px dashed #aaa;
    	margin:20px 0px;
    }
</style>

<script>
	import { mapState } from 'vuex';
	import { mapMutations } from 'vuex';

	export default{
        name:'sidebar',
        components:{
        },
        mounted(){	
        },
        data(){
	    	return {
	    		user:{
	    			portrait:"/images/slide2.jpg"
	    		}
	    	}
	    },
	    props:{
	    	
	    	
	    },
        computed:mapState([
        ]),
        
        methods:{
        	...mapMutations([
		    ]),
        	
        }

    };
</script>