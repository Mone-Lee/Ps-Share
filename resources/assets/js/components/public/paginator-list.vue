<template>
    <div class="paginator" v-if="total > 1">
        <div class="pagelistbox">
            <a v-if="leftBtn" @click="lastPage(index-1)" class="p prevPage" href="javascript:;">上一页</a>
            <div v-if="total <= 6" id="pagelist">
                <a v-for="(item, index) in total" @click="getPage(index+1,$event)" class="p">
                    {{index+1}}
                </a>
            </div>
            <div v-else id="pagelist">
                <a v-if="index - 2 > 1" @click="getPage(1,$event)" class="p active">1</a>
                <a v-if="index - 2 > 2" >...</a>
                <a v-for="(item, pos) in 5" @click="getPage(startIndex + pos,$event)" class="p">
                        {{startIndex + pos}}
                </a>
                <a v-if="index + 2 < total - 1" class="p">...</a>
                <a v-if="index + 2 < total" @click="getPage(total,$event)" class="p">{{total}}</a>
            </div>
            <a v-if="rightBtn" @click="nextPage(index+1)" class="p nextPage" href="javascript:;">下一页</a>
            <div class="total"><span class="total-inner">共 {{total}} 页</span></div>
        </div>
    </div>
</template>
<style>
    .pagelistbox{
        overflow: hidden;
        line-height: 40px;
        text-align: center;
        font-family: Arial;
        margin: 10px 0 5px 0;
        display: block;
        width: 100%;
    }
    .pagelistbox a{
        min-width: 15px;
        margin: 0 2px 0 2px;
        padding: 0 10px;
        float: left;
        font-size: 13px;
        display: block;
        height: 38px;
        line-height: 38px;
    }
    .pagelistbox .p {
        color: #222;
        cursor: pointer;
        text-align: center;
        border-radius: 4px;
        background-color: #fff;
        border: solid 1px #ddd;
        background-image: none;
        transition: .2s all;
        font-size: 14px;
        cursor: pointer;
    }
    .pagelistbox .p.active ,.pagelistbox .p:hover{
        background: #00a1d6;
        color: #fff;
        border: 1px solid #00a1d6;
    }
    .pagelistbox .p.nextPage, .pagelistbox .p.prevPage {
        padding: 0 15px;
    }
    .pagelistbox .total {
        float: right;
        margin-right: 10px;
    }
    .pagelistbox .total .total-inner{
        padding: 0 2px;
        font-size: 12px;
        color: #99a2aa;
        display: inline-block;
    }

</style>
<script>

    export default{
        name: 'PaginatorList',
        props: {
            total: {
                type:Number,
                default: 1
            },
            url:{
                type:String,
                default: '/'
            },
            paginatorParams: {
                type:String,
                default: ''
            },
            urlType:{
                type:String,
                default: 'admin'
            }
        },
        data(){
            return{
                index:1,
            }
        },
        computed: {

            leftBtn () {
                if(this.index == 1){
                    return false;
                }else {
                    return true;
                }
            },
            rightBtn () {
                if(this.index == this.total){
                    return false;
                }else {
                    return true;
                }
            },
            startIndex () {
                if(this.index - 2 < 0){
                    return 1;
                }


                // 前后都满足
                if(this.index - 2 >= 1 && this.index + 2 <= this.total){
                    return this.index - 2;
                }

                // 前面的不满足
                if(this.index - 2 <= 0 && this.index + 2 <= this.total){
                    return 1;
                }

                // 后面的不满足
                if(this.index - 2 >= 1 && this.index + 2 > this.total){
                    return this.total - 4;
                }
            }
        },
        methods: {

            isAdmin (url) {
                if(this.urlType == 'admin'){
                    return this.$adminUrl(url);
                }else {
                    return this.$homeUrl(url)
                }
            },

            lastPage (lastIndex) {
                var list = document.getElementById('pagelist').getElementsByTagName('a');
                this.$http.get(this.isAdmin(this.url)+ '?page=' + lastIndex + '&' + this.paginatorParams).then((response) => {
                    this.index = response.body.current_page;
                    list[this.index-1].className = "p active";
                    this.$emit('flashPage', response.body.data);
                },(response) => {

                });
            },

            nextPage (nestIndex) {
                var list = document.getElementById('pagelist').getElementsByTagName('a');
                this.$http.get(this.isAdmin(this.url)+ '?page=' + nestIndex + '&' + this.paginatorParams).then((response) => {
                    this.index = response.body.current_page;
                    list[this.index-1].className = "p active";
                    this.$emit('flashPage', response.body.data);
                },(response) => {

                });
            },

            getPage (index,event) {
                var list = document.getElementById('pagelist').getElementsByTagName('a');
                list[this.index-1].className = "p";
                event.target.className = "p active";
                this.$http.get(this.isAdmin(this.url)+ '?page=' + index + '&' + this.paginatorParams).then((response) => {
                    this.index = response.body.current_page;
                    
                    this.$emit('flashPage', response.body.data);
                },(response) => {

                });
            },
        }
    }

</script>
