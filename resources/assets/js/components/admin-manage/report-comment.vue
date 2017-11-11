<template>
    <div>

        <table class="report-list">
            <tr>
                <th class="name">评论内容</th>
                <th class="name">举报者</th>
                <th class="name">被举报者</th>
                <th class="name">举报分类</th>
                <th class="name">举报内容</th>
                <th class="name">举报状态</th>
                <th class="name">举报人数</th>
                <th class="operate">操作</th>
            </tr>
            <template v-for="(Report, index) in Reports">
                <tr>
                    <td class="name" :title="Report.comment_content">
                        {{Report.comment_content}}
                    </td>
                    <td class="name" :title="Report.user_name">
                        {{Report.user_name}}
                    </td>
                    <td class="name" :title="Report.usered_name">
                        {{Report.usered_name}}
                    </td>
                    <td class="name" :title="Report.report_classification_name">
                        {{Report.report_classification_name}}
                    </td>
                    <td class="name" :title="Report.report_content">
                        {{Report.report_content}}
                    </td>
                    <td class="name">
                        <span v-if="Report.report_status == 0">未处理</span>
                        <span v-else>忽略</span>
                    </td>
                    <td class="name">
                        {{Report.total}}
                    </td>
                    <td class="operate">
                        <button @click="more(Report.comment_id)" type="button">查看</button>
                        <div v-if="Report.report_status == 0">
                            <button @click="triggle(Report)" type="button">忽略</button>
                            <button @click="showConfirm(0, index, Report.comment_report_id, Report.comment_id)" type="button">删除</button>
                        </div>
                        <button v-else @click="triggle(Report)" type="button">解除</button>

                    </td>

                </tr>
            </template>
        </table>

        <div v-if="showMore" class="report-dialog">
            <table class="report-list-dialog">
                <tr>
                    <th class="name">评论内容</th>
                    <th class="name">举报者</th>
                    <th class="name">被举报者</th>
                    <th class="name">举报分类</th>
                    <th class="name">举报内容</th>
                </tr>
                <template v-for="(Report, index) in MoreReports">
                    <tr>
                        <td class="name" :title="Report.comment_content">
                            {{Report.comment_content}}
                        </td>
                        <td class="name" :title="Report.user_name">
                            {{Report.user_name}}
                        </td>
                        <td class="name" :title="Report.usered_name">
                            {{Report.usered_name}}
                        </td>
                        <td class="name" :title="Report.report_classification_name">
                            {{Report.report_classification_name}}
                        </td>
                        <td class="name" :title="Report.report_content">
                            {{Report.report_content}}
                        </td>
                    </tr>
                </template>
            </table>

            <div class="div-btn">
                <button @click="back" type="button">返回</button>
            </div>
        </div>

        <paginator
                :total="total"
                url="commentreport"
                @result="setCommentReport"
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

    .report-list, .report-list-dialog {
        width: pxToRem(800);
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
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
            }

            .operate {
                width: 25%;
                div {
                    display: inline-block;
                }

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

    .report-dialog {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        width: 820px;
        height: 400px;
        overflow-x: hidden;
        overflow-y: auto;
        z-index: 100;
        background-color: white;
        box-shadow: 0 0 3px 0px #bdbdbd;

        .div-btn {
            position: absolute;
            width: 100%;
            height: 50px;
            line-height: 50px;
            bottom: 0;
            text-align: center;

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
        name: 'ReportComment',
        mounted () {
            this.getReports();
        },
        data(){
            return{
                Report: {
                    id: 0,
                    name: ''
                },
                Reports: [],
                checkIds: [],
                show: false,
                type: 0,
                deleteTmp: {
                    id: 0,
                    reportId: 0,
                    commentId: 0
                },
                showMore: false,
                MoreReports: [],
                total: 0,
            }
        },
        methods: {
            /**
             *  获取所有分享分类
             */
            getReports () {

                this.$http.get(this.$adminUrl('commentreport')).then((response) => {

                    this.$set(this, 'Reports', response.body.data);
                    this.total = response.body.last_page;

                },
                (response) => {

                    this.$alert('连接错误', 'e');

                });
            },


            /**
             *  显示删除提示框
             */
            showConfirm (type, index=0, reportId=0, commentId=0) {
                this.type = type;
                if(type == 0){
                    this.show = true;
                    this.deleteTmp.index = index;
                    this.deleteTmp.reportId = reportId;
                    this.deleteTmp.commentId = commentId;
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
                    this.deleteReport(this.deleteTmp.index, this.deleteTmp.reportId, this.deleteTmp.commentId);
                }else {
                    this.batchDelete();
                }
            },

            /**
             *  删除单个分享分类
             */
            deleteReport (index, reportId, commentId) {

                this.$http.delete(this.$adminUrl('commentreport/') + reportId, {params:{commentId: commentId}}).then((response) => {

                    if(response.body == 'true'){
                        this.Reports.splice(index,1);
                        this.show = false;
                        this.$alert('删除成功');
                    }else {
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
                this.$http.delete(this.$adminUrl('commentreport/batch-delete'),{params:this.checkIds})
                    .then((response) => {


                        this.$set(this, 'Reports', response.body.reportClassfications);
                        this.checkIds = [];

                        this.show = false;
                        this.$alert('成功删除'+response.body.result+'条');

                    },
                    (response) => {
                        this.$alert('连接错误', 'e');
                    });
            },

            triggle (report) {
                this.$http.post(this.$adminUrl('commentreport/triggle'), {reportId: report.comment_report_id}).then((response) => {
                    if(response.body <= 1){
                        report.report_status = response.body;
                    }
                }, (response) => {

                });
            },

            more (id) {
                this.$http.get(this.$adminUrl('commentreport/')+id).then((response) => {
                    this.$set(this, 'MoreReports', response.body.data);
                    this.showMore = true;
                }, (response) => {

                });
            },

            back () {
                this.showMore = false;
                this.MoreReports = [];
            },

            setCommentReport (commentReport) {
                this.$set(this, 'Reports', commentReport.data);
                this.total = commentReport.last_page;
            }

        },
    }
</script>
