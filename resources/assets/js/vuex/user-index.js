// Vuex
import Vuex from 'vuex';
import Vue from 'vue';
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        shares: [],
        shareClassifications:[],
        userMsg:{}
    },
    mutations: {

        setShares (state, list) {
            state.shares = list;
        },

        setShareClassifications (state, list) {
            state.shareClassifications = list;
        },

        setUserMsg (state, list) {
            state.userMsg = list;
        },

    }
});

export default store;