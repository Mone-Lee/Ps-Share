import Vue from 'vue';

/**
 * 全局注册通用方法
 */
export default {
    install() {

        /**
         * 获取分页后的列表项
         * @param vm
         * @param url
         * @param success
         * @param error
         */
        Vue.prototype.$index = (vm, url, success, error) => {
            vm.$http.get(vm.$adminUrl(url + '/query')).then((response) => {
                success(response);
            }, (response) => {
                error(response);
            });
        };

        /**
         * 新增一条记录，附带验证检测判断
         * @param vm
         * @param url
         * @param messages
         * @param success
         * @param error
         * @returns {boolean}
         */
        Vue.prototype.$storeL = (vm, url, messages, success, error) => {
            // 验证表单
            vm.$validator.validateAll();
            // 如果表单报错则不提交
            if(vm.errors.any()) {
                return false;
            }else {
                vm.$http.post(vm.$adminUrl(url), messages).then((response) => {
                    success(response);
                }, (response) => {
                    error(response);
                });
            }
            
        };

        /**
         * 单个删除
         * @param vm
         * @param url
         * @param id
         * @param success
         * @param error
         */
        Vue.prototype.$destroyL = (vm, url, id, success, error) => {
            vm.$http.delete(vm.$adminUrl(url + '/' + id)).then((response) => {
                success(response);
            }, (response) => {
                error(response);
            });
        };

        /**
         * 批量删除
         * @param vm
         * @param url
         * @param ids
         * @param success
         * @param error
         */
        Vue.prototype.$batchDestroy = (vm, url, ids, success, error) => {
            vm.$http.delete(vm.$adminUrl(url + '/deletes'), {body:{'ids':ids}}).then((response) => {
                success(response);
            }, (response) => {
                error(response);
            });
        };

        /**
         * 检查重名
         * @param vm
         * @param url
         * @param params
         * @param success
         * @param error
         */
        Vue.prototype.$check = (vm, url, params, success, error) => {
            vm.$http.get(vm.$adminUrl(url + '/check'), {params:params}).then((response) => {
                success(response);
            }, (response) => {
                error(response);
            });
        };

        /**
         * 更新编辑
         * @param vm
         * @param url
         * @param messages
         * @param success
         * @param error
         * @returns {boolean}
         */
        Vue.prototype.$update = (vm, url, messages, success, error) => {
            // 验证表单
            vm.$validator.validateAll();
            // 如果表单报错则不提交
            if(vm.errors.any()) {
                return false;
            }else {
                vm.$http.put(vm.$adminUrl(url) + '/' + messages.id, messages).then((response) => {
                    success(response);
                }, (response) => {
                    error(response);
                });
            }

        };

        /**
         * 查询
         * @param vm
         * @param url
         * @param params
         * @param success
         * @param error
         */
        Vue.prototype.$queryWithParams = (vm, url, params, success, error) => {
            vm.$http.get(vm.$adminUrl(url + '/query'), {params:params}).then((response) => {
                success(response);
            }, (response) => {
                error(response);
            });
        };

    }
};