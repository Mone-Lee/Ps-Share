
<template >
	<div class="userPanel">
		<div class="userpanel__left">
			<div class="userpanel__portrait" id="userPortrait" :style="'background-image:url('+$img(userInfo.pic)+')'"></div>
			<p><a :href="getUrl(0)">关注</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a :href="getUrl(1)">收藏</a></p>
		</div>
		<div class="userpanel__right">
				<p class="userpanel__userName">{{userInfo.name}}&nbsp;&nbsp;&nbsp;&nbsp;<span v-text="getSex(userInfo.sex)"></span> </p>
				<p  class="userpanel__userIntro">{{userInfo.introduction}}</p>
			
		</div>
	</div>
</template>

<style>
	.userPanel{
		width: 100%;
		margin-top: 58px;
		margin-bottom: 10px;
		background: #F5F5F5;
		overflow: hidden;
	}
	.userpanel__left,.userpanel__right{
		display:inline-block;
	}
	.userpanel__left{
		text-align: center;
		float: left;
		vertical-align: middle;
	}
	.userpanel__left a{
		font-size: 18px;
	}
	.userpanel__portrait{
		height:180px;
		width:180px; 
		border-radius: 50%;
		margin:10px 20px;
		background: center no-repeat;
		background-size:cover;
	}
	.userpanel__right{
		margin-left: 20px;
	}
	.userpanel__userName{
		font-size: 18px;
		line-height: 180px;
	}
	.userpanel__userIntro{
		margin-top: -80px;
	}
</style>

<script>
    import userFollow from '../share-detail/userFollow';
	

	import { mapState } from 'vuex';
	import { mapMutations } from 'vuex';

	export default{
       name:'userPanel',
       props: {
       		user: {
       			type: Object,
       			default: {}
       		}
       },
		data(){
			return{
				userInfo:{},
				userSex:""

			}
		},

		mounted () {
			this.getUserInfo();
		},

		components: {
			userFollow
		},

		computed:mapState([
			'pictures',
			'list'
			]),

		methods: {

			...mapMutations([

				]),
			showPortait(){
				var portrait = document.getElementById("userPortrait");
				portrait.style.backgroundImage="url("+this.userInfo.pic+")";
				portrait.style.backgroundImage="url(/images/pic1.jpg)";

			},
			getUserInfo(){
        		this.$http.get(this.$adminUrl('getUserMsg')).then((response) => {
        			this.$set(this, 'userInfo', response.body);
        			// this.showPortait();
        		},
        		(response) => {
        			alert('fail in getting userInfo!');

        		});
        	},
        	getSex(x){
                if(x==1)
                    return "♂";
                else
                    return "♀";
            },
        	getUrl(type){
        		if(type===0){
        			return "/admin/p/user-manage#/follow";
        		}else if(type===1){
        			return "/admin/p/user-manage#/collection";

        		}
        	},
        }        
    }
</script>

