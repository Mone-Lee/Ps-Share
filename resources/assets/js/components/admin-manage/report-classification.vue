<template>
    <div>

        <div class="addReportClassification">
            <label for="SCname">举报分类名：</label><input id="SCname" type="text" v-model="ReportClassification.name">
            <button @click="addReportClassification" v-if="!edit" type="button">新增</button>
            <template v-else>
                <button @click="SaveReportClassification" type="button">保存修改</button>
                <button @click="cancelEdit" type="button" class="cancel">取消</button>
            </template>
        </div>

        <table class="classification-list">
            <tr>
                <th class="check"></th>
                <th class="name">name</th>
                <th class="operate">操作</th>
            </tr>
            <template v-for="(ReportClassification, index) in ReportClassifications">
                <tr>
                    <td class="check">
                        <input type="checkbox" :value="ReportClassification.id" v-model="checkIds">
                    </td>
                    <td @click="editName(ReportClassification)" class="name">
                        {{ReportClassification.name}}
                    </td>
                    <td class="operate">
                        <button @click="showConfirm(0, index, ReportClassification.id)" type="button">删除</button>
                    </td>

                </tr>
            </template>
        </table>

        <div class="batch-delete">
            <button @click="showConfirm(1)" type="button">批量删除</button>
        </div>

        <confirm
            :show="show"
            @confirmAction="oneOrBatchDelete"
            @cancelAction="show=false"
        ></confirm>

    </div>
</template>
<style lang="sass">

    @import "../../../sass/function";

    .addReportClassification {
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
        name: 'ReportClassification',
        mounted () {
            this.getReportClassifications();
        },
        data(){
            return{
                TmpReportClassification: {
                    id: 0,
                    name: ''
                },
                ReportClassification: {
                    id: 0,
                    name: ''
                },
                ReportClassifications: [],
                checkIds: [],
                edit: false,
                show: false,
                type: 0,
                deleteTmp: {
                    id: 0,
                    index: 0
                }
            }
        },
        methods: {
            /**
             *  获取所有举报分类
             */
            getReportClassifications () {

                this.$http.get(this.$homeUrl('getAllReports')).then((response) => {

                    this.$set(this, 'ReportClassifications', response.body);

                },
                (response) => {

                    this.$alert('连接错误', 'e');

                });
            },

            /**
             *  新增举报分类
             */
            addReportClassification () {
                this.$http.post(this.$adminUrl('reportclassification'),this.ReportClassification).then((response) => {

                    if(response.body != 'false') {

                        this.ReportClassification.id = response.body;
                        this.ReportClassifications.push(this.ReportClassification);
                        this.ReportClassification = {id: 0, name: ''};
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
                    }else if(response.body.name[0] == 'The name may not be greater than 20 characters.'){
                        this.$alert('长度小于20', 'e');
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
                    this.deleteReportClassification(this.deleteTmp.index, this.deleteTmp.id);
                }else {
                    this.batchDelete();
                }
            },

            /**
             *  删除单个举报分类
             */
            deleteReportClassification (index, id) {

                this.$http.delete(this.$adminUrl('reportclassification/') + id).then((response) => {

                    if(response.body == 'true'){
                        this.ReportClassifications.splice(index,1);
                        this.show = false;
                        this.$alert('删除成功');
                    }else if(response.body == "can't delete!"){
                        this.show = false;
                        this.$alert('删除失败', 'e');
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
                this.$http.delete(this.$adminUrl('reportclassification/batch-delete'),{params:this.checkIds})
                    .then((response) => {


                        this.$set(this, 'ReportClassifications', response.body.reportClassfications);
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
            editName(ReportClassification) {
                this.edit = true;
                this.ReportClassification = ReportClassification;
                this.TmpReportClassification.id = ReportClassification.id;
                this.TmpReportClassification.name = ReportClassification.name;
            },

            /**
             *  保存编辑的分享分类的名称
             */
            SaveReportClassification() {
                this.$http.put(this.$adminUrl('reportclassification/') + this.ReportClassification.id, this.ReportClassification).then((response) => {

                    if(response.body == 'true'){
                        this.edit = false;
                        this.ReportClassification = {id: 0, name: ''};
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
                    }else if(response.body.name[0] == 'The name may not be greater than 20 characters.'){
                        this.$alert('长度小于20', 'e');
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
                this.ReportClassification.id = this.TmpReportClassification.id;
                this.ReportClassification.name = this.TmpReportClassification.name;
                this.TmpReportClassification = {id: 0, name: ''};
                this.ReportClassification = {id: 0, name: ''};
            },

        },
    }
</script>
