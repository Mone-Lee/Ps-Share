/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('../sass/user-index.scss');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Userindex from './views/user-index.vue';
import store from './vuex/user-index';

const userContent = resolve => {
	require.ensure(['./components/user-index/userContent.vue'], () => {
		resolve(require('./components/user-index/userContent.vue'));
	}, 'userContent');
};

const collection = resolve => {
	require.ensure(['./components/user-index/collection.vue'], () => {
		resolve(require('./components/user-index/collection.vue'));
	}, 'collection');
};

const follow = resolve => {
	require.ensure(['./components/user-index/follow.vue'], () => {
		resolve(require('./components/user-index/follow.vue'));
	}, 'follow');
};

const routes = [
	{
		name: 'userContent',
		path: '',
		component: userContent
	},
	{
		name: 'userContent',
		path: '/userContent',
		component: userContent
	},
	{
		name: 'collection',
		path: '/collection',
		component: collection
	},
	{
		name: 'follow',
		path: '/follow',
		component: follow
	},	
];

const router = new VueRouter({
	routes
});

const userindex = new Vue({
    el: '#userindex',
    components: {
        Userindex
    },
    router,
    store,
}).$mount('#userindex');