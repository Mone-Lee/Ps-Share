<template>
    <div class="panel">
            <ul id="myTab" class="nav nav-tabs">
                <li class="active">
                    <a href="#home" data-toggle="tab">
                        评论过的分享
                    </a>
                </li>
                <li><a href="#ios" data-toggle="tab">点赞过的分享</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="home">
                    <div v-for="comment in comments" class="commentItem">
                        <p>
                            <a :href="$homeUrl('share-detail', 'p')+'/'+comment.share.share_id" target="_blank">
                                in {{comment.share.share_abstract}}
                            </a>
                        
                        <small ><a :href="$homeUrl('share-detail', 'p')+'/'+comment.share.share_id" target="_blank" style="color:#5bc0de">
                            回复@{{comment.share.reply_user_name}}：{{comment.share.created_at}}
                        </a></small>
                        </p>
                        <p>{{comment.share.content}}</p>
                        
                    </div>
                    <paginator
                        :total="total"
                        url="getAllCommentedShare"
                        @result="setAllCommentedShare"
                    ></paginator>
                </div>
                <div class="tab-pane fade" id="ios">
                    <div>
                        <div v-for="like in likes" class="commentItem">
                        {{like.share.user_name}}
                        <img :src="$img(like.share.pic)">
                        <a :href="$homeUrl('share-detail', 'p')+'/'+like.share.share_id" target="_blank">
                        {{like.share.abstract}}</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>
<style>
.commentItem{
    border-bottom: 1px dashed #ccc;
    margin-top: 10px;
}
</style>
<script>
    export default{
        name: 'History',
        data(){
            return{
                comments: [],
                likes: [],
                total: 1,
            }
        },
        mounted () {
            this.getAllCommentedShare();
            this.getAllLikedShare();
        },
        methods: {
            getAllCommentedShare () {
                this.$http.get(this.$adminUrl('getAllCommentedShare')).then((response) => {
                    this.$set(this, 'comments', response.body.data);
                    this.total = response.body.last_page;
                }, (response) => {

                });
            },

            setAllCommentedShare(CommentedShares){
                this.$set(this, 'comments', CommentedShares.data);
                this.total = CommentedShares.last_page;
            },

            getAllLikedShare () {
                this.$http.get(this.$adminUrl('getAllLikedShare')).then((response) => {
                    this.$set(this, 'likes', response.body.data);
                }, (response) => {

                });
            }
        },
    }
</script>
