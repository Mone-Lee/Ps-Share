// Vuex
import Vuex from 'vuex';
import Vue from 'vue';
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        pictures:[null],
        list:[],
        paginatorParams:'',
        navItems:[
            {isImg:true, intro:"头像", src:"/images/add.png"},
            {isText:true, text:"欢迎你"},
            {isLink:true, text:"登陆", url:"#"},
            {isLink:true, text:"个人中心", url:"#"}
        ]
    },
    mutations: {

        /**
         *  图片数组初始化
         * @param state
         */
        initPictures (state) {
            state.pictures = [null];
        },

        /**
         *  设置图片数组
         * @param state
         * @param payload
         */
        setPictures (state, payload) {
            for(let index = 0; index < payload.length; index++){
                state.pictures.push(payload[index]);
            }
        },

        /**
         * 将单个图片push入图片数组
         * @param state
         * @param file
         */
        pushPicture (state, file) {
            state.pictures.push(file);
        },

        /**
         * 替换指定下标的图片文件
         * @param state
         * @param object
         */
        splicePicture (state, object) {
            console.log(object.order);
            console.log(object.file);
            state.pictures.splice(object.order, 1, object.file);
        },

        /**
         * 删除指定下标的图片文件
         * @param state
         * @param index
         */
        deletePicture (state, index) {
            state.pictures.splice(index, 1);
        },

        /**
         * 设置结果数组
         * @param state
         * @param payload
         */
        setList (state, payload) {
            state.list = [];
            for(let item of payload){
                state.list.push(item);
            }
        },

        /**
         * 设置分页器的查询参数
         * @param state
         * @param {object} payload
         */
        setPaginatorParams (state, payload) {
            let params = '';
            Object.keys(payload).forEach(k => params += k + '=' + payload[k] + '&');
            state.paginatorParams = params;
        }

    }
});

export default store;