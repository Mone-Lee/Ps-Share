<template>
    <div>
        <div>
            <div class="search-module">
                <select v-model="search.active">
                    <option value="">全部</option>
                    <option value="0">unlock</option>
                    <option value="1">lock</option>
                </select>
                <input v-model="search.param" type="text" name="param" placeholder="搜索用户名">
                <button @click="searchUser" type="button">搜素</button>
            </div>
        </div>

        <table class="user-list">
            <tr>
                <th></th>
                <th class="name">用户名</th>
                <th class="name">邮箱</th>
                <th class="name">状态</th>
                <th class="name">注册时间</th>
                <th class="operate">操作</th>
            </tr>
            <tr v-for="(user, index) in users">
                <td>
                    <input v-model="checkIds" :value="user.id" type="checkbox">
                </td>
                <td class="name" :title="user.name">
                    {{user.name}}
                </td>
                <td class="name" :title="user.email">
                    {{user.email}}
                </td>
                <td class="name">
                    <span v-if="user.active == 0">unlock</span>
                    <span v-else>lock</span>
                </td>
                <td class="name">
                    {{user.created_at | timeFilter}}
                </td>
                <td class="operate">
                    <button v-if="user.active == 0" @click="triggleUser(user)" type="button">冻结</button>
                    <button v-else @click="triggleUser(user)" type="button">解冻</button>
                    <button v-if="this.isAdmin" @click="showRole(user.id)" type="button" class="role-btn">角色管理</button>
                </td>
            </tr>
        </table>

        <div class="batch">
            <button @click="batchLock" type="button">批量冻结</button>
            <button @click="batchUnlock" type="button">批量解冻</button>
        </div>

        <paginator
                :total="total"
                url="getAllUser"
                :paginatorParams="search"
                @result="setAllUser"
        ></paginator>

        <role-dialog v-if="showRoleDialog"
            :userId="userId"
             @cancel="showRoleDialog=false"
        ></role-dialog>

    </div>
</template>
<style lang="sass">

    @import "../../../sass/function";


    .search-module {
        width: pxToRem(800);
        margin: 0 auto;
        padding: 10px 0;

        select {
            height: pxToRem(29px);
        }

        input {
            width: pxToRem(194);
            height: pxToRem(25);
            padding-left: pxToRem(6);
        }

        button {
            padding: 0 pxToRem(13);
            height: pxToRem(29);
            background-color: white;
            border: 1px solid #9E9E9E;
            cursor: pointer;
        }

    }

    .user-list {
        width: pxToRem(800);
        margin: pxToRem(20) auto;
        text-align: center;
        table-layout: fixed;

        tr {

            &:nth-child(odd){
                background-color: #fbfbfb;
        }

            &:nth-child(1) {
                background-color: #f1f1f1;
        }

            .check {

            }

            .name {
                padding: pxToRem(7) 0;
                cursor: pointer;
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
            }

            .operate {
                width: 25%;
            }

            button {
                width: pxToRem(58);
                height: pxToRem(26);
                background-color: white;
                border: 1px solid #f1f1f1;
                cursor: pointer;
            }

            button.role-btn {
                width: pxToRem(75);
            }
        }
    }

    .batch {
        width: pxToRem(500);
        margin-left: pxToRem(40);

        button {
            height: pxToRem(29);
            padding: 0 pxToRem(17);
            background-color: white;
            border: 1px solid #9E9E9E;
            cursor: pointer;
        }
    }

</style>
<script>

    import RoleDialog from './role-dialog.vue'

    export default{
        name: 'User',
        data(){
            return{
                users:[],
                user:{

                },
                search: {
                    'active': 0,
                    'param': ''
                },
                checkIds: [],
                showRoleDialog: false,
                userId: 0,
                total: 0,
            }
        },
        mounted () {
            this.getAllUser();
        },
        components: {
            RoleDialog,
        },
        methods: {

            /**
            * 获取所有用户
            */
            getAllUser () {
                this.$http.get(this.$adminUrl('getAllUser')).then((response) => {
                    this.$set(this, 'users', response.body.data);
                    this.total = response.body.last_page;
                },(response) => {

                });
            },

            /**
            * 搜索
            */
            searchUser () {
                this.$http.get(this.$adminUrl('getAllUser'), {params:this.search}).then((response) => {
                    this.$set(this, 'users', response.body.data);
                },(response) => {

                });
            },

            /**
            * 冻结或解冻
            */
            triggleUser (user) {
                this.$http.get(this.$adminUrl('triggleUser')+'/'+user.id).then((response) => {
                    if(response.body == 'true'){
                        if(user.active == 0){
                            user.active = 1;
                        }else {
                            user.active = 0;
                        }
                    }
                },(response) => {

                });
            },

            /**
            * 批量冻结
            */
            batchLock () {
                this.$http.get(this.$adminUrl('batchLock'), {params:this.checkIds}).then((response) => {
                    if(response.body != 0){
                        for(let user of this.users){
                            if(this.checkIds.indexOf(user.id) != -1){
                                user.active = 1;
                            }
                        }
                    }
                    this.checkIds = [];
                },(response) => {

                });
            },

            /**
            * 批量解冻
            */
            batchUnlock () {
                this.$http.get(this.$adminUrl('batchUnlock'), {params:this.checkIds}).then((response) => {
                    if(response.body != 0){
                        for(let user of this.users){
                            if(this.checkIds.indexOf(user.id) != -1){
                                user.active = 0;
                            }
                        }
                    }
                    this.checkIds = [];
                },(response) => {

                });
            },

            showRole (id) {
                this.showRoleDialog = true;
                this.userId = id;
            },

            setAllUser(users) {
                this.$set(this, 'users', users.data);
                this.total = users.last_page;
            },

        },
    }
</script>
