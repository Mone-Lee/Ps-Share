import Vue from 'vue';

/**
 * 全局注册通用方法
 */
export default {
    install() {

        /**
         * 弱提醒
         * @param msg
         */
        let timer = null;
        Vue.prototype.$alert = (msg, type='msg') => {
            $('#alertWeek').remove();
            let color = '';
            switch(type) {
                case 'm':
                case 'msg':
                    color = 'rgba(0,0,0,0.5)';
                    break;
                case 's':
                case 'success':
                    color = 'rgba(76,175,80,0.6)';
                    break;
                case 'e':
                case 'error':
                    color = 'rgba(244,67,54,0.6)';
                    break;
            }
            let $alert = $('<div class="week-alert" id="alertWeek"></div>');
            $alert.css({
                'position': 'fixed',
                'left': '0',
                'right': '0',
                'bottom': '0',
                'top': '0',
                'margin': 'auto',
                'width': '160px',
                'height': '59px',
                'lineHeight': '59px',
                'backgroundColor': color,
                'color': 'white',
                'textAlign': 'center',
                'boxSizing': 'border-box',
                'opacity': '0',
                'zIndex': '19920219',
            });
            $('body').append($alert);
            $alert.html(msg);
            $alert.animate({
                opacity: '1'
            }, 300);
            clearTimeout(timer);
            timer = setTimeout(() => {
                $alert.animate({
                    opacity: '0'
                }, 300, () => {
                    $alert.remove();
                });
            }, 1500);
        };

        /**
         * 自动生成完整的前台url
         *
         * @param url {string}
         * @param type {string} url的类型，c为接口类型，p为视图类型
         * @returns {string}
         */
        Vue.prototype.$homeUrl = (url, type = 'c') => {

            if(url == undefined || typeof url != 'string'){
                return ;
            }

            let regx = /^\/{1,}/g;
            url = url.replace(regx, '');

            if (type == 'c' || type == 'C') {
                return window.homeCUrl + '/' + url;
            }

            if (type == 'p' || type == 'P') {
                return window.homePUrl + '/' + url;
            }
        };

        /**
         * 自动生成完整的后台url
         *
         * @param url {string}
         * @param type {string} url的类型，c为接口类型，p为视图类型
         * @returns {string}
         */
        Vue.prototype.$adminUrl = (url, type = 'c') => {

            if(url == undefined || typeof url != 'string'){
                return ;
            }

            let regx = /^\/{1,}/g;
            url = url.replace(regx, '');

            if (type == 'c' || type == 'C') {
                return window.adminCUrl + '/' + url;
            }

            if (type == 'p' || type == 'P') {
                return window.adminPUrl + '/' + url;
            }
        };

        /**
         * 判断是否重名
         * @param vm
         * @param url
         * @param params
         * @param field
         * @param callback
         */
        Vue.prototype.$unique = (vm, url, params, field, callback) => {

            vm.$check(vm, url, params, (response) => {

                if (response.body == 'false') {

                    let errorBag = vm.$validator.getErrors();
                    errorBag.add(field, `名称重复`);

                } else {

                    callback();

                }
            }, (response)=> {

            });

        };

        /**
         * 比较器
         * @param proto
         * @returns {function()}
         */
        function compare(proto) {
            return (ob1, ob2) => {
                return ob1[proto] - ob2[proto];
            }
        }

        /**
         * 根据传过来的属性参数对对象数组继续逆序排序
         * @param arrObj 对象数组
         * @param proto 对象的属性
         * @returns {Array.<T>}
         */
        Vue.prototype.$reverseObj = (arrObj, proto) => {
            return arrObj.sort(compare(proto)).reverse();
        };

        /**
         *
         * 组合图片路径
         *
         * @param url
         * @returns {*}
         */
        Vue.prototype.$img = (url) => {
            if(url == undefined || typeof url != 'string'){
                return ;
            }
            if(url.indexOf('base64') > 0){
                return url;
            }
            let regx = /^\/{1,}/g;
            url = url.replace(regx, '');
            return 'http://' + window.location.host + '/' + url;
        };

        /**
         * 把对象变成url参数
         * @param object
         * @returns {string}
         */
        Vue.prototype.$objectToParam = (object) => {
            let params = '';
            Object.keys(object).forEach(k => params += k + '=' + object[k] + '&');
            return params;
        };

    }
};