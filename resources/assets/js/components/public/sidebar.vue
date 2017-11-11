/**
*   sidebar
*   描述：用户页面侧边栏
*/
<template>
	<aside class="sidebar">
        <div class="userPortrait-sidebar">
            <div class="userPortrait-large" id="userPortrait" :style="'background-image:url('+$img(user.portrait)+')'"></div>
        </div>
    	<ul class="userOption">
	    	<li v-for="navbar in navbars" class="userOption__item" >
	    		<router-link :to="navbar.path" v-if="navbar.show">{{navbar.name}}</router-link>
	    	</li>
    	</ul>
    </aside>

</template>


<style>
	.sidebar{
		text-align: center;
        margin-top: 20px;
        margin-right: 10px;
	}
    .userOption{
    	list-style: none;
    	margin: 0px;
        padding:0px;
    	padding-top: 10px;
        background:#f5f5f5;
        box-shadow: 0px 0px 5px #aaa;
        min-height: 500px;
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
     .userPortrait-sidebar{
        margin-bottom: 10px;
        background: #f5f5f5;
        box-shadow: 0px 0px 5px #aaa;
        text-align: center;
        padding: 10px 0px;
    }
    .userPortrait-large{
    	height:120px;
        width:120px; 
        display: inline-block;
        border-radius: 50%;
        background: center no-repeat;
        background-size:cover;
    	margin:20px 0px;

    }
    .active{
		background: #fff;
    	
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
							path: '/'
						}
        			]
        		}
        	}
        },
        components:{
        },
        mounted(){	
			// console.log(this.navbars);
            this.getUserInfo();
        },
        data(){
	    	return {
	    		user:{
	    			portrait:"/images/add.png"
	    		}
	    	}
	    },
        computed:mapState([
        ]),
        
        methods:{
        	getUserInfo(){
                this.$http.get(this.$adminUrl('getUserMsg')).then((response) => {
                     this.user.portrait=response.body.pic;
                },
                (response) => {

                    alert('fail in getting userInfo!');

                });
            },
        }

    };
</script>