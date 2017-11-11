<template>
    <div>
        <div v-if="show" class="comfirn">
            <div class="message">
                {{message}}
            </div>
            <div>
                <div @click="cancelMethod" class="btn btn-cancel">{{cancel}}</div>
                <div @click="confirmMethod" class="btn btn-confirm">{{confirm}}</div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        name: 'Dialog',
        props: {
            show: {
                type: Boolean,
                default: false
            },
            message: {
                type: String,
                default: '确认删除？'
            },
            confirm: {
                type: String,
                default: '确定'
            },
            cancel: {
                type: String,
                default: '取消'
            },
        },
        data(){
            return{

            }
        },
        methods: {
            /**
             * 触发confirmAction事件
             */
            confirmMethod () {
                this.$emit('confirmAction');
            },

            /**
             * 触发cancelAction事件
             */
            cancelMethod () {
                this.$emit('cancelAction');
            },
        }
    }
</script>
<style lang="sass">


    .comfirn {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        width: 275px;
        height: 153px;
        z-index: 19920220;
        box-shadow: 0px 0px 5px -2px;

        .message {
            padding: 45px 0;
            text-align: center;
            background-color: #ffffff;
        }

        .btn {
            float: left;
            width: 50%;
            text-align: center;
            padding: 10px 0;
        }

        .btn-confirm {
            border-top: 1px solid #d7d7d7;
            background-color: #ffffff;
            cursor: pointer;
        }

        .btn-cancel {
            background-color: #ffffff;
            color: #9E9E9E;
            border-right: 1px solid #d7d7d7;
            border-top: 1px solid #d7d7d7;
            box-sizing: border-box;
            cursor: pointer;
        }

    }
</style>
