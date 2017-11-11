/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('../sass/admin-manage.scss');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import AdminManage from './views/admin-manage.vue'
import store from './vuex/admin-manage';

const shareClassification = resolve => {
    require.ensure(['./components/admin-manage/share-classification.vue'], () => {
        resolve(require('./components/admin-manage/share-classification.vue'));
    }, 'shareClassification');
};

const keyword = resolve => {
    require.ensure(['./components/admin-manage/keyword.vue'], () => {
        resolve(require('./components/admin-manage/keyword.vue'));
    }, 'keyword');
};


const report = resolve => {
    require.ensure(['./components/admin-manage/report.vue'], () => {
        resolve(require('./components/admin-manage/report.vue'));
    }, 'report');
};

const reportShare = resolve => {
    require.ensure(['./components/admin-manage/report-share.vue'], () => {
        resolve(require('./components/admin-manage/report-share.vue'));
    }, 'reportShare');
};

const reportComment = resolve => {
    require.ensure(['./components/admin-manage/report-comment.vue'], () => {
        resolve(require('./components/admin-manage/report-comment.vue'));
    }, 'reportComment');
};

const reportClassification = resolve => {
    require.ensure(['./components/admin-manage/report-classification.vue'], () => {
        resolve(require('./components/admin-manage/report-classification.vue'));
    }, 'reportClassification');
};

const user = resolve => {
    require.ensure(['./components/admin-manage/user.vue'], () => {
        resolve(require('./components/admin-manage/user.vue'));
    }, 'user');
};

const role = resolve => {
    require.ensure(['./components/admin-manage/role.vue'], () => {
        resolve(require('./components/admin-manage/role.vue'));
    }, 'role');
};

const routes = [
    {
        path: '/shareClassification',
        name: 'shareClassification',
        component: shareClassification
    },
    {
        path: '/keyword',
        name: 'keyword',
        component: keyword
    },
    {
        path: '/report',
        name: 'report',
        component: report,
        children: [
            {
                path: '',
                component: reportShare
            },
            {
                path: 'share-report',
                component: reportShare
            },
            {
                path: 'comment-report',
                component: reportComment
            }
        ]
    },
    {
        path: '/reportClassification',
        name: 'reportClassification',
        component: reportClassification
    },
    {
        path: '/user',
        name: 'user',
        component: user
    },
    {
        path: '/role',
        name: 'role',
        component: role
    }
];

const router = new VueRouter({
   routes 
});

const app = new Vue({
    el: '#app',
    components: {
        AdminManage
    },
    store,
    router,
}).$mount('#app');
