<template>
    <div>
        <div class="report-type">
            <router-link to="/report/share-report">分享举报</router-link>
            <router-link to="/report/comment-report">评论举报</router-link>
        </div>


        <router-view></router-view>
    </div>
</template>
<style lang="sass">

    @import "../../../sass/function";

    .report-type {
        width: 50rem;
        margin: 1.25rem auto;

        a {
            color: #aaa;
            margin-right: 4px;
        }

        .router-link-active {
            background-color: white;
            border: 1px solid black;
            padding: 5px;
            color: black;
        }
    }

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
        name: 'Report',
        mounted () {
        },
        data(){
            return {

            }
        },
        methods: {

        },
    }
</script>
