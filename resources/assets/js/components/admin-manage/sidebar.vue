/**
*   sidebar
*   描述：用户页面侧边栏
*/
<template>
	<aside class="sidebar">
    	
    	<ul class="userOption">
	    	<li v-for="navbar in navbars" class="userOption__item" >
	    		<router-link :to="navbar.path" v-if="navbar.show" exact>{{navbar.name}}</router-link>
	    	</li>
    	</ul>
    </aside>

</template>


<style>
	.sidebar{
		text-align: center;
		padding-top: 52px;
	}
    .userOption{
    	list-style: none;
    	margin: 0px;
    	padding: 0px;
    }
    .userOption__item{
		-webkit-transition: all 0.2s;
		-o-transition: all 0.2s;
		transition: all 0.2s;
    	border-bottom: 1px solid #E8E8E8;
    }
    .userOption__item:hover{
		background: #e7e7e7;

    }
    .userPortrait-large{
    	border-radius: 50%;
    	width: 112px;
    	border: 2px dashed #aaa;
    	margin:20px 0px;
    	background: #fff;
    }
    .active{
		background: #e7e7e7;
    	
    }
    .userOption__item a {
        display: inline-block;
        width: 100%;
        height: 100%;
        padding: 10px 0;
        color: black;
    }
    .router-link-active {
        background-color: #e7e7e7;
    }

</style>

<script>
	import { mapState } from 'vuex';
	import { mapMutations } from 'vuex';

	export default{
        name:'sidebar',
        props: {
        	navbars: {
        		type:Array,
        		default () {
        			return [
						{
							name: '',
							path: '/',
                            show:false
						}
        			]
        		}
        	}
        },
        components:{
        },
        mounted(){	
			
        },
        data(){
	    	return {
	    		
	    	}
	    },
        computed:mapState([
        ]),
        
        methods:{
        	
        }

    };
</script>