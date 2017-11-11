<template>
    <div class="paginator">
        <div v-if="leftBtn" @click="lastPage(index-1)" class="left">&lt;</div>
        <div v-else disabled class="left">&lt;</div>
        <div class="middle" v-if="showInput" @click="showInputIndex">第{{index}}页/共{{total}}页</div>
        <div class="middle-input" v-else><input v-model="inputIndex" @keyup.enter="changeIndex" v-focus type="text" class="input-index" placeholder="页数"></div>
        <div v-if="rightBtn" @click="nextPage(index+1)" class="right">&gt;</div>
        <div v-else disabled class="right">&gt;</div>
    </div>
</template>
<style lang="sass" scoped>

    @import "../../../sass/function";

    .paginator {

        width: 100%;
        text-align: center;

        .left, .right {
            display: inline-block;
            width: pxToRem(39);
            height: pxToRem(39);
            line-height: pxToRem(39);
            background-color: white;
            color: #222;
            border-radius: pxToRem(2);
            cursor: pointer;
            border: 1px solid #dddddd;
    }

        .middle {
            display: inline-block;
            height: pxToRem(39);
            line-height: pxToRem(39);
            padding: 0 pxToRem(12);
            margin: 0 pxToRem(2);
            background-color: white;
            color: #222;
            border-radius: pxToRem(2);
            border: 1px solid #dddddd;
    }

        .middle-input {
            @extend .middle;
            padding: 0;
            width: 102.41px;
            .input-index {
                width: 80px;
                height: 35px;
                padding-left: 15px;
                border: 0;
            }
        }

        .right {

    }
    }
</style>
<script>

    import {mapState} from 'vuex';
    import {mapMutations} from 'vuex';

    export default{
        name: 'Paginator',
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
                type: Object,
                default () {
                    return {}
                }
            },
            isAdmin: {
                type: Boolean,
                default: true
            }
        },
        data(){
            return{
                index: 1,
                showInput: true,
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
        },
        methods: {

            lastPage (lastIndex) {
                let url = '';
                if(this.isAdmin){
                    url = this.$adminUrl(this.url);
                }else {
                    url = this.$homeUrl(this.url);
                }
                this.$http.get(url + '?page=' + lastIndex + '&' + this.$objectToParam(this.paginatorParams)).then((response) => {
                    this.index = response.body.current_page;
                    this.$emit('result', response.body);
                },(response) => {

                });
            },

            nextPage (nestIndex) {
                let url = '';
                if(this.isAdmin){
                    url = this.$adminUrl(this.url);
                }else {
                    url = this.$homeUrl(this.url);
                }
                this.$http.get(url + '?page=' + nestIndex + '&' + this.$objectToParam(this.paginatorParams)).then((response) => {
                    this.index = response.body.current_page;
                    this.$emit('result', response.body);
                },(response) => {

                });
            },

            showInputIndex () {
                this.showInput = false;
            },

            changeIndex () {
                let url = '';
                if(this.isAdmin){
                    url = this.$adminUrl(this.url);
                }else {
                    url = this.$homeUrl(this.url);
                }
                this.$http.get(url + '?page=' + this.inputIndex + '&' + this.$objectToParam(this.paginatorParams)).then((response) => {
                    this.showInput = true;
                    this.index = response.body.current_page;
                    this.$emit('result', response.body);
                },(response) => {

                });
            }
        }
    }
</script>
