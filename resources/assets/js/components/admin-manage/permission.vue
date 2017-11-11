<template>
    <div class="permission-dialog">
        <div class="permission-add">
            <label for="role_name">角色名</label>
            <input v-model="role.name" type="text" id="role_name">
            <label for="role_display_name">展示名字</label>
            <input v-model="role.display_name" type="text" id="role_display_name">
            <label for="role_description">描述</label>
            <input v-model="role.description" type="text" id="role_description">
            <button v-if="!edit" @click="addRole">新增角色</button>
            <button v-else @click="updateRole">保存修改</button>
            <button @click="cancel" type="button">取消</button>
        </div>
        <div class="permission">
            <div class="permission-content">
                <div v-for="permissionItem in permissionList" class="permission-item">
                    <h4>{{permissionItem.permissionClassification}}</h4>
                    <p v-for="permission in permissionItem.permissions">
                        <input v-model="role.permissionIds" :value="permission.id" type="checkbox" :id="permission.id+'-'+permission.name">
                        <label :for="permission.id+'-'+permission.name">{{permission.display_name}}</label>
                    </p>
                </div>
            </div>

        </div>
        <input type="hidden" :value="roleId">
    </div>

</template>
<style lang="sass">

    @import "../../../sass/function";

    .permission-dialog {

        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        width: 900px;
        height: 500px;
        overflow-x: hidden;
        overflow-y: auto;
        z-index: 100;
        background-color: white;
        box-shadow: 0 0 3px 0px #bdbdbd;

        .permission-add {
            position: absolute;
            top: 0;
            left: 0;
            height: 50px;
            width: 100%;
            line-height: 50px;
            background-color: white;
            text-align: center;
            box-shadow: 0 0 8px 0px #b5b5b5;

            input {
                width: pxToRem(150);
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

        .permission {
            width: 100%;
            height: 440px;
            margin: 0 auto;
            margin-top: 50px;
            overflow-y: auto;

            .permission-content {

                display: flex;
                flex-wrap: wrap;
                width: 90%;
                margin: 0 auto;

                .permission-item {
                    float: left;
                    width: 25%;
                    margin: 0;
                    padding: 7px 0;

                    h4, p {
                        padding: 4px 0;
                    }
                }
            }


        }
    }

</style>
<script>
    export default{
        name: 'Permission',
        props: {
            edit:{
                type: Boolean,
                default: false
            },
            id: {
                type: Number,
                default: 0
            }
        },
        data(){
            return{
                role: {
                    id: 0,
                    name: '',
                    display_name: '',
                    description: '',
                    permissionIds: []
                },
                permissionList: [],
            }
        },
        computed: {
            roleId () {
                this.editRole(this.id);
                return this.id;
            }
        },
        mounted () {
            console.log(this.role);
            this.getPermissionByClassification();
        },
        methods: {
            getPermissionByClassification () {
                this.$http.get(this.$adminUrl('rbac/getPermissionByClassification')).then((response)=>{
                    this.$set(this, 'permissionList', response.body);
                },(response)=> {

                });
            },
            addRole () {
                this.$emit('addRole', this.role);
            },
            updateRole () {
                this.$http.put(this.$adminUrl('rbac/')+this.roleId, this.role).then((response)=>{
                    this.$emit('saveSuccess');
                    this.$emit('cancel');
                },(response)=> {

                });
            },
            editRole(id) {
                if(id == 0){
                    return ;
                }
                this.$http.get(this.$adminUrl('rbac/') + id + '/edit').then((response)=>{
                    this.$set(this, 'role', response.body);
                },(response)=>{

                });
            },

            cancel () {
                this.$emit('cancel');
            },
        },
    }
</script>
