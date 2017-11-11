<template>
    <div class="role-dialog">
        <div class="role-list">
            <ul>
                <li v-for="(role, index) in roles">
                    <input v-model="checkIds" :value="role.id" type="checkbox" :id="role.id+'-'+role.name">
                    <label :for="role.id+'-'+role.name" :title="role.description">{{role.display_name}}</label>
                </li>
            </ul>
        </div>

        <div class="div-btn">
            <button @click="save" type="button">保存</button>
            <button @click="cancel" type="button">取消</button>
        </div>

    </div>
</template>
<style lang="sass">

    @import "../../../sass/function";

    .role-dialog {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        width: 400px;
        height: 400px;
        overflow-x: hidden;
        overflow-y: auto;
        z-index: 100;
        background-color: white;
        box-shadow: 0 0 3px 0px #bdbdbd;

        .role-list {
            width: 400px;
            overflow-y: auto;

            ul {
                width: 200px;
                height: 320px;
                margin: 0 auto;
                padding-top: 18px;

                li {
                    padding: 4px 0;
                }
            }
        }



        .div-btn {
            position: absolute;
            width: 100%;
            height: 50px;
            line-height: 50px;
            bottom: 0;
            text-align: center;
            background-color: white;

            button {
                width: 100px;
                height: 32px;
                background: white;
                border: 1px solid #9a9a9a;
                color: #9a9a9a;
                cursor: pointer;
        }
    }
    }

</style>
<script>

    export default{
        name: 'RoleDialog',
        props: {
            userId: {
                type: Number,
                default: 0
            }
        },
        data(){
            return{
                roles: [],
                checkIds: [],
            }
        },
        mounted () {
            this.getRoles();
            this.getRoleIds();
        },
        methods: {

            getRoles () {
                this.$http.get(this.$adminUrl('rbac/getAllRoles')).then((response)=>{
                    this.$set(this, 'roles', response.body);
                },(response)=>{

                });
            },

            getRoleIds () {
                this.$http.get(this.$adminUrl('rbac/getUserRole/')+this.userId).then((response)=>{
                    this.$set(this, 'checkIds', response.body);
                },(response)=>{

                });
            },

            save () {
                this.$http.post(this.$adminUrl('rbac/userBindRole'),{userId: this.userId, roleIds: this.checkIds}).then((response)=>{
                    if(response.body == 'true'){
                        this.cancel();
                    }
                },(response)=>{

                });
            },

            cancel () {
                this.$emit('cancel');
            }

        },
    }
</script>
