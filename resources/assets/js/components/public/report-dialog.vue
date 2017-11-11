<template>
    <div class="reportClassification-dialog">
        <ul>
            <li v-for="ReportClassification in ReportClassifications">
                <input v-model="reportClassificationId" :value="ReportClassification.id" type="radio" :id="ReportClassification.id+'-'+ReportClassification.name">
                <label :for="ReportClassification.id+'-'+ReportClassification.name">{{ReportClassification.name}}</label>
            </li>
        </ul>
        <textarea v-model="content"></textarea>
        <div class="btns">
            <button @click="report">提交</button>
            <button @click="cancel" class="cancel">取消</button>
        </div>
    </div>
</template>
<style lang="sass">

    @import "../../../sass/function";

    .reportClassification-dialog {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        width: 200px;
        height: 250px;
        overflow-x: hidden;
        overflow-y: auto;
        z-index: 100;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 3px 1px #ddd;
        text-align: center;

        textarea {
            position: absolute;
            width: 155px;
            bottom: 57px;
            left: 0;
            right: 0;
            margin: auto;
            border-radius: 5px;
            height: 53px;
        }

        .btns {

            position: absolute;
            bottom: 11px;
            left: 0;
            right: 0;
            width: 212px;
            margin: auto;

            button {
                width: 75px;
                height: 32px;
                background: #00a1d6;
                border: 1px solid #00a1d6;
                color: white;
                cursor: pointer;
                border-radius: 5px;

                &.cancel {
                    background: white;
                    border: 1px solid #ddd;
                    color: #222;
                }
            }
        }



        ul {

            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;

            li {
                width: 50%;
                padding: 4px 0;
            }
        }
    }


</style>
<script>
    export default{

        name: 'ReportDialog',
        props: {
            // true表示举报评论，false表示举报分享
            flag: {
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
                ReportClassifications: [],
                content: '',
                reportClassificationId: 0,
            }
        },
        mounted (){
            this.getReportClassifications();
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
            report () {

                if(this.flag) {
                    let param = {
                        comment_id: this.id,
                        report_classification_id: this.reportClassificationId,
                        content: this.content
                    };

                    this.$http.get(this.$homeUrl('reportComment'), {params:param}).then((response) => {
                        if(response.body == 'true'){
                            this.$alert('举报成功', 's');
                        }else if(response.body == 'already report!'){
                            this.$alert('已举报过', 's');
                        }else {
                            this.$alert('举报失败', 'e');
                        }
                        this.$emit('close');
                    },
                    (response) => {

                        this.$alert('连接错误', 'e');

                    });
                }else {
                    let param = {
                        share_id: this.id,
                        report_classification_id: this.reportClassificationId,
                        content: this.content
                    };

                    this.$http.get(this.$homeUrl('reportShare'), {params:param}).then((response) => {
                        if(response.body == 'true'){
                            this.$alert('举报成功', 's');
                        }else if(response.body == 'already report!'){
                            this.$alert('已举报过', 's');
                        }else {
                            this.$alert('举报失败', 'e');
                        }
                        this.$emit('close');
                    },
                    (response) => {

                        this.$alert('连接错误', 'e');

                    });
                }

            },
            cancel () {
                this.$emit('close');
            }
        },
    }
</script>
