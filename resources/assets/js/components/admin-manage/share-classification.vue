<template>
    <div>

        <div class="addShareClassification">
            <label for="SCname">分享分类名：</label><input id="SCname" type="text" v-model="ShareClassification.name">
            <button @click="addShareClassification" v-if="!edit" type="button">新增</button>
            <template v-else>
                <button @click="SaveShareClassification" type="button">保存修改</button>
                <button @click="cancelEdit" type="button" class="cancel">取消</button>
            </template>
        </div>

        <table class="classification-list">
            <tr class="thead">
                <th class="check"></th>
                <th class="name">name</th>
                <th class="operate">操作</th>
            </tr>
            <template v-for="(ShareClassification, index) in ShareClassifications">
                <tr>
                    <td class="check">
                        <input type="checkbox" :value="ShareClassification.id" v-model="checkIds">
                    </td>
                    <td @click="editName(ShareClassification)" class="name">
                        {{ShareClassification.name}}
                    </td>
                    <td class="operate">
                        <button @click="showConfirm(0, index, ShareClassification.id)" type="button">删除</button>
                    </td>

                </tr>
            </template>
        </table>

        <div class="batch-delete">
            <button @click="showConfirm(1)" type="button">批量删除</button>
        </div>

        <paginator
                :total="total"
                url="shareclassification"
                @result="setShareClassification"
        ></paginator>

        <confirm
            :show="show"
            @confirmAction="oneOrBatchDelete"
            @cancelAction="show=false"
        ></confirm>

    </div>
</template>
<style lang="sass">

    @import "../../../sass/function";

    .addShareClassification {
        width: pxToRem(500);
        margin: 0 auto;
        padding: 10px 0;
        text-align: center;

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

        .cancel {
            background-color: #9E9E9E;
            color: white;
        }

    }


    .classification-list {
        width: pxToRem(500);
        margin: pxToRem(20) auto;
        text-align: center;


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
            }

            .operate {

            }

            button {
                width: pxToRem(58);
                height: pxToRem(26);
                background-color: white;
                border: 1px solid #f1f1f1;
                cursor: pointer;
            }
        }
    }

    .batch-delete {
        width: pxToRem(500);
        margin: 0 auto;

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
    export default{
        name: 'ShareClassification',
        mounted () {
            this.getShareClassifications();
        },
        data(){
            return{
                TmpShareClassification: {
                    id: 0,
                    name: ''
                },
                ShareClassification: {
                    id: 0,
                    name: ''
                },
                ShareClassifications: [],
                checkIds: [],
                edit: false,
                show: false,
                type: 0,
                deleteTmp: {
                    id: 0,
                    index: 0
                },
                total: 0,
            }
        },
        methods: {
            /**
             *  获取所有分享分类
             */
            getShareClassifications () {

                this.$http.get(this.$adminUrl('shareclassification')).then((response) => {

                    this.$set(this, 'ShareClassifications', response.body.data);
                    this.total = response.body.last_page;

                },
                (response) => {

                    this.$alert('连接错误', 'e');

                });
            },

            /**
             *  新增分享分类
             */
            addShareClassification () {
                this.$http.post(this.$adminUrl('shareclassification'),this.ShareClassification).then((response) => {

                    if(response.body != 'false') {

                        this.ShareClassification.id = response.body;
                        this.ShareClassifications.push(this.ShareClassification);
                        this.ShareClassification = {id: 0, name: ''};
                        this.$alert('新增成功', 's');

                    }else {

                        this.$alert('新增失败', 'e');

                    }
                },
                (response) => {

                    if(response.body.name[0] == 'The name field is required.'){
                        this.$alert('分类名必填', 'e');
                    }else if(response.body.name[0] == 'The name has already been taken.'){
                        this.$alert('分类名重复', 'e');
                    }else if(response.body.name[0] == 'The name may not be greater than 10 characters.'){
                        this.$alert('长度小于10', 'e');
                    }else {
                        this.$alert('连接错误', 'e');
                    }

                });
            },

            /**
             *  显示删除提示框
             */
            showConfirm (type, index=0, id=0) {
                this.type = type;
                if(type == 0){
                    this.show = true;
                    this.deleteTmp.index = index;
                    this.deleteTmp.id = id;
                }else {
                    if(this.checkIds.length == 0){
                        this.$alert('请选择');
                    }else {
                        this.show = true;
                    }
                }
            },

            /**
             *  根据type判断是单个删除还是批量删除
             */
            oneOrBatchDelete () {
                if(this.type == 0){
                    this.deleteShareClassification(this.deleteTmp.index, this.deleteTmp.id);
                }else {
                    this.batchDelete();
                }
            },

            /**
             *  删除单个分享分类
             */
            deleteShareClassification (index, id) {

                this.$http.delete(this.$adminUrl('shareclassification/') + id).then((response) => {

                    if(response.body == 'true'){
                        this.ShareClassifications.splice(index,1);
                        this.show = false;
                        this.$alert('删除成功');
                    }else if(response.body == 'has shares'){
                        this.show = false;
                        this.$alert('分类下有内容', 'e');
                    }else {
                        this.show = false;
                        this.$alert('删除失败', 'e');
                    }

                },
                (response) => {
                    this.$alert('连接错误', 'e');
                });
            },

            /**
             *  批量删除分享分类
             */
            batchDelete () {
                this.$http.delete(this.$adminUrl('shareclassification/batch-delete'),{params:this.checkIds})
                    .then((response) => {


                        this.$set(this, 'ShareClassifications', response.body.shareClassifications);
                        this.checkIds = [];

                        this.show = false;
                        this.$alert('成功删除'+response.body.result+'条');

                    },
                    (response) => {
                        this.$alert('连接错误', 'e');
                    });
            },

             /**
             *  填充编辑分享分类的id和名称
             */
            editName(ShareClassification) {
                this.edit = true;
                this.ShareClassification = ShareClassification;
                this.TmpShareClassification.id = ShareClassification.id;
                this.TmpShareClassification.name = ShareClassification.name;
            },

            /**
             *  保存编辑的分享分类的名称
             */
            SaveShareClassification() {
                this.$http.put(this.$adminUrl('shareclassification/') + this.ShareClassification.id, this.ShareClassification).then((response) => {

                    if(response.body == 'true'){
                        this.edit = false;
                        this.ShareClassification = {id: 0, name: ''};
                        this.$alert('修改成功', 's');
                    }else if(response.body == "the name already exist") {
                        this.$alert('名字重复', 'e');
                    }else if(response.body ==  'nothing change') {

                    }else {
                        this.$alert('修改失败', 'e');
                    }


                },
                (response) => {
                    if(response.body.name[0] == 'The name field is required.'){
                        this.$alert('分类名必填', 'e');
                    }else if(response.body.name[0] == 'The name may not be greater than 10 characters.'){
                        this.$alert('长度小于10', 'e');
                    }else {
                        this.$alert('连接错误', 'e');
                    }
                });
            },

            /**
             *  取消分享分类的编辑
             */
            cancelEdit(){
                this.edit = false;
                this.ShareClassification.id = this.TmpShareClassification.id;
                this.ShareClassification.name = this.TmpShareClassification.name;
                this.TmpShareClassification = {id: 0, name: ''};
                this.ShareClassification = {id: 0, name: ''};
            },

            setShareClassification (shareClassification) {
                this.$set(this, 'ShareClassifications', shareClassification.data);
                this.total = shareClassification.last_page;
            }
        },
    }
</script>
