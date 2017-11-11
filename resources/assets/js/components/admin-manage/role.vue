<template>
    <div>

        <permission
            v-if="show"
            :edit="edit"
            :id="roleId"
            @addRole="addRole"
            @saveSuccess="updateRole"
            @cancel="show=false"
        ></permission>

        <div class="permission-add-btn">
            <button @click="showAdd" type="button">新增</button>
        </div>

        <table class="table-role-list">
            <tr>
                <th class="name">name</th>
                <th class="name">display_name</th>
                <th class="description">description</th>
                <th class="name">created_time</th>
                <th class="operate">operation</th>
            </tr>
            <tr v-for="(role, index) in roles">
                <td class="name">
                    {{role.name}}
                </td>
                <td class="name">
                    {{role.display_name}}
                </td>
                <td class="description">
                    {{role.description}}
                </td>
                <td class="name">
                    {{role.created_at | timeFilter}}
                </td>
                <td class="operate">
                    <button @click="editRole(role.id)" type="button">编辑</button>
                    <button @click="deleteRole(role.id)" type="button">删除</button>
                </td>
            </tr>
        </table>

        <paginator
            :total="total"
            url="rbac"
            @result="setRoles"
        ></paginator>

    </div>
</template>
<style lang="sass">

    @import "../../../sass/function";

    .permission-add-btn {
        width: pxToRem(800);
        margin: 0 auto;
        padding: 10px 0;

        button {
            padding: 0 pxToRem(13);
            height: pxToRem(29);
            background-color: white;
            border: 1px solid #9E9E9E;
            cursor: pointer;
        }
    }

    .table-role-list {
        width: pxToRem(800);
        margin: pxToRem(20) auto;
        text-align: center;
        table-layout: fixed;
        overflow: hidden;

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
                width: 10%;
                padding: pxToRem(7) 0;
                cursor: pointer;
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
            }

            .description {
                width: 10%;
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
            }

            .operate {
                width: 15%;
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

</style>
<script>

    import Permission from './permission.vue'

    export default{
        name: 'Role',
        data(){
            return{
                roles: [],
                edit: false,
                checkIds: [],
                roleId: 0,
                show: false,
                total: 0
            }
        },
        mounted () {
            this.getRoles();
        },
        components: {
            Permission
        },
        methods: {

            getRoles () {
                this.$http.get(this.$adminUrl('rbac')).then((response)=>{
                    this.$set(this, 'roles', response.body.data);
                    this.total = response.body.last_page;
                },(response)=>{

                });
            },

            addRole (payload) {
                this.$http.post(this.$adminUrl('rbac'), payload).then((response)=>{
                    this.show = false;
                    this.roleId=0;
                    this.getRoles();
                },(response)=>{

                });
            },

            editRole(id) {
                this.roleId = id;
                this.edit = true;
                this.show = true;
            },

            deleteRole (id) {
                this.$http.delete(this.$adminUrl('rbac/') + id).then((response)=>{
                    this.getRoles();
                },(response)=>{

                });
            },

            showAdd () {
                this.roleId=0;
                this.edit = false;
                this.show = true;
            },
            updateRole (){
                this.edit=false;
                this.roleId=0;
                this.getRoles();
            },

            setRoles (roles){
                this.$set(this, 'roles', roles.data);
                this.total = roles.last_page;
            }
        },
    }
</script>
