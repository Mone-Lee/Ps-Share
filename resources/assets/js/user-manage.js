/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('../sass/user-manage.scss');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Usermanage from './views/user-manage.vue';
import store from './vuex/user-manage';

const share = resolve => {
    require.ensure(['./components/user-manage/share.vue'], ()=>{
        resolve(require('./components/user-manage/share.vue'))
    }, 'share');
};

const collection = resolve => {
    require.ensure(['./components/user-manage/collection.vue'], ()=>{
        resolve(require('./components/user-manage/collection.vue'))
    }, 'collection');
};

const follow = resolve => {
    require.ensure(['./components/user-manage/follow.vue'], ()=>{
        resolve(require('./components/user-manage/follow.vue'))
    }, 'follow');
};

const receive = resolve => {
    require.ensure(['./components/user-manage/receive.vue'], ()=>{
        resolve(require('./components/user-manage/receive.vue'))
    }, 'receive');
};

const history = resolve => {
    require.ensure(['./components/user-manage/history.vue'], ()=>{
        resolve(require('./components/user-manage/history.vue'))
    }, 'history');
};

const userinfo = resolve => {
    require.ensure(['./components/user-manage/userinfo.vue'], ()=>{
        resolve(require('./components/user-manage/userinfo.vue'))
    }, 'userinfo');
};

const routes =[
    {
        name: 'share',
        path: '/share',
        component:share
    },
    {
        name: 'collection',
        path: '/collection',
        component:collection
    },
    {
        name: 'follow',
        path: '/follow',
        component:follow
    },
    {
        name: 'receive',
        path: '/receive',
        component:receive
    },
    {
        name: 'history',
        path: '/history',
        component:history
    },
    {
        name: 'userinfo',
        path: '/userinfo',
        component:userinfo
    }
];

const router = new VueRouter({
    routes
});

const usermanage = new Vue({
    el: '#usermanage',
    components: {
        Usermanage
    },
    router,
    store,
}).$mount('#usermanage');