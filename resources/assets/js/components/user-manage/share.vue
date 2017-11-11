<template>
    <div>
        <div class="layout__main__content">
            <div class="layout__main__content_share">
                <Picturepanel></Picturepanel>
            </div>
        </div>
    </div>
</template>
<style>
    .layout__main__content{
        margin-top: 100px;
    }
    .layout__main__content_share{
        padding-left: 20px;
    }
</style>
<script>

    import Picturepanel from '../public/Picturepanel';
    import {mapState} from 'vuex';
    import {mapMutations} from 'vuex';

    export default{
        name: 'Share',
        data(){
            return{
                ShareClassification: {
                    id: 0,
                    name: ''
                },
                ShareClassifications: [],
                modalflag:false,
                checkIds: [],
                token: '',
                abstract:'',
                content:'',
                share: {
                    'share_classification_id':0,
                    'abstract':'',
                    'content':'',
                    'pics':[],
                    'status':1
                },
                shares:[],
                shareIds: [],
                shareSearch: {
                    'abstract':'',
                    'status':-1
                },
                total:0,
                hello:'',
            }
        },
        computed:mapState([
            'pictures',
        ]),
        mounted () {

        },
        components: {
            Picturepanel
        },
        methods: {
            getShareClassifications () {

                this.$http.get(this.$adminUrl('getAllShareClassifications')).then((response) => {

                    this.$set(this, 'ShareClassifications', response.body);

                },
                (response) => {

                    alert('fail in getting data!');

                });
            },
            validateBeforeSubmit() {
                let form = new FormData();
                form.append('share_classification_id', this.share.share_classification_id);
                form.append('abstract', this.share.abstract);
                form.append('content', this.share.content);
                form.append('status',this.share.status);
                for(let picture of this.pictures){
                    form.append('pictures[]', picture);
                }

                this.$http.post(this.$adminUrl('share'), form, {headers:{'Content-Type':'multipart/form-data'}}).then((response) => {

                }, (response) => {

                });
            },
            searchShare () {
                this.$http.get(this.$adminUrl('share/query'), {params:this.shareSearch}).then((response) => {

                    // 搜索中一定要用这个全局方法设置分页器的参数
                    this.setPaginatorParams(this.shareSearch)
                    // 设置分页的总页数
                    this.total = response.body.last_page;
                    // 更新全局list
                    this.setList(response.body.data);

                },(response) => {

                });
            },
        },
    }
</script>
