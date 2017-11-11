/**
*   导航条
*   描述：导航条组件
*
*   arrow {Boolean} : 切换上一张、下一张的箭头按钮
*   pageModel
*		    {
*		    showLen:可显示长度,
*			i_ppage:每个分页item数(item per page)
*			i_total:item总数,
*			p_total:总页数 Math.ceil( i_total/i_ppage )
*			} 
*   
*/
<template>
	<section>
		<a href="/goBack" class="PageIndex__Nav PageIndex__Back" id="goBack" ><<</a>
		<ul class="PageIndex" id="PageIndex">
			<li class="pageIndex__nav" v-for="index in showLen">index</li>
		</ul>
		<a href="/goNext" class="PageIndex__Nav PageIndex__Next" id="goNext" >>></a>
	</section>
	
</body>
</html>
</template>


<style>
	.pageIndex{
		display: inline-block;
		width:300px;
		height: 50px;
		line-height: 50px;
		overflow: hidden;
		text-align: center;
		vertical-align: middle;
	}
	.pageIndex>li{
		display: inline-block;
	}
	.pageIndex__nav{
		width: 36px;
		height:36px;
		line-height: 36px;
		text-align: center;
		border: 1px solid #aaa;
		border-radius: 50%;
		font-size: 12px;
		display: inline-block;
	}
	.pageIndex__nav-active{
		width: 48px;
		height:48px;
		line-height: 48px;
		border: 1px solid #aaa;
		border-radius: 50%;
		font-size: 16px;
		color:#fff;
		background: #aaa;

	}
</style>

<script>
	import { mapState } from 'vuex';
	import { mapMutations } from 'vuex';

	export default{
        name:'pageIndex',
        mounted(){
        	this.showLen=5;//显示分页下标个数
			this.i_ppage = 10;//每个分页显示的item输
			this.i_total=41;//item总数
			this.p_total=Math.ceil(i_total/i_ppage);//分页总数	
        },
        data(){
	    	return {
	    		showLen:1,
	    		i_ppage:1,
	    		i_total:1,
	    		p_total:1
	    	}
	    },
	    props:{
	    	
	    	
	    },
        computed:mapState([
        ]),
        
        methods:{
        	setActive () {
        		//激活当前下标
				var eve =  window.event;
				var target = eve.target || eve.srcElement;
				if(_curIndex>=0 && _curIndex < nodeList.length){
					var node = nodeList[_curIndex].firstChild;
					node.setAttribute('class',"PageIndex__Nav");

					
					var backTest=new RegExp('goBack');
					var nextTest=new RegExp(/goNext/);
					if(backTest.test(target.href)){
						_curIndex--;
					}else if(nextTest.test(target.href)){
						_curIndex++;
					}
					if(_curIndex>=0 && _curIndex<nodeList.length){
						node = nodeList[_curIndex].firstChild;
						node.setAttribute('class',"PageIndex__Nav PageIndex__Nav-active");	
					}
				}else{
					target.setDisabled=
				}

				eve.preventDefault(); 
				return false;
			}	
        }

    };

    
</script>