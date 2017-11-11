window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
// require('bootstrap-sass');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
window.VueResource = require('vue-resource');
window.VueRouter = require('vue-router');
window.Vuex = require('vuex');

Vue.use(VueResource);
Vue.use(VueRouter);
Vue.use(Vuex);

import VeeValidate from 'vee-validate';
import messagesAr from '../../lang/zh-CN/vee-validate.js';
Vue.use(VeeValidate, {
    locale: 'ar',
    dictionary: {
        ar: {   // locale key
            messages: messagesAr,   // Arabic messages
        }
    }
});


/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */


Vue.http.interceptors.push((request, next) => {
    // request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
    request.credentials = true;

    next();
});

Vue.http.options.xhr = { withCredentials: true };
Vue.http.options.emulateJSON = true;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

/**
 * some global init
 */

// 注册全局组件
Vue.component('confirm', require('./components/public/confirm.vue'));
Vue.component('paginator', require('./components/public/paginator.vue'));


// 实例化Vue的filter
import filters from './filters/filters.js';
Object.keys(filters).forEach(k => Vue.filter(k, filters[k]));

// 注册自定义指令
import directive from './directive/directive.js';
Object.keys(directive).forEach(k => Vue.directive(k, directive[k]()));

// 配置webpack动态加载模块的路径
// __webpack_public_path__ = '/build/';
__webpack_public_path__ = 'http://127.0.0.1:8080/public/build/';

// 注册自定义验证规则
import {Validator} from 'vee-validate';
import validates from './utils/validate.js';
Object.keys(validates).forEach(k => Validator.extend(k, validates[k]()));

// 注册全局方法
import utils from './utils/utils';
import easyAjax from './utils/easyAjax';
Vue.use(utils);
Vue.use(easyAjax);