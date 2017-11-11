/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('../sass/app.scss');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from './views/app.vue';
import store from './vuex/user';

const Foo = resolve => {
    require.ensure(['./components/app/Foo.vue'], () => {
        resolve(require('./components/app/Foo.vue'));
    }, 'foo');
};

const Bar = resolve => {
    require.ensure(['./components/app/Bar.vue'], () => {
        resolve(require('./components/app/Bar.vue'), 'js/bar');
    }, 'bar');
};

const User = resolve => {
    require.ensure(['./components/app/User.vue'], () => {
        resolve(require('./components/app/User.vue'));
    }, 'user');
};

const DefaultChild = resolve => {
    require.ensure(['./components/app/DefaultChild.vue'], () => {
        resolve(require('./components/app/DefaultChild.vue'));
    }, 'defaultChild');
};

const Child = resolve => {
    require.ensure(['./components/app/Child.vue'], () => {
        resolve(require('./components/app/Child.vue'));
    }, 'child');
};

const routes = [
    {
        path: '/foo',
        name:'foo',
        component: Foo
    },
    {
        path: '/bar',
        component: Bar
    },
    {
        path: '/user/:id',
        component: User,
        children: [
            {path: '', component: DefaultChild},
            {path: 'child', component: Child}
        ]
    },
];

const router = new VueRouter({
    routes
});


const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router: router,
    store,
}).$mount('#app');
