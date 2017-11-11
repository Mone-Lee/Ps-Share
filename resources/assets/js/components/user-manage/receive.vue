<template>
    <div class="panel">
            <ul id="myTab" class="nav nav-tabs">
                <li class="active">
                    <a href="#home" data-toggle="tab">
                        收到的回复
                    </a>
                </li>
                <li>
                    <a href="#ios" data-toggle="tab">收到的赞</a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active contentPanel" id="home">
                    <div v-for="comment in comments" class="recieveItem">
                        <div class="replyItem">
                             <a :href="$homeUrl('share-detail', 'p')+'/'+comment.share_id" target="_blank">
                                <p>
                                    <img class="commentPortrait" :src="$img(comment.pic)">{{comment.name+" "+comment.created_at}}
                                </p>
                            </a>
                            <p>{{comment.content}} </p>

                        </div>
                       
                        <a :href="$homeUrl('share-detail', 'p')+'/'+comment.share_id" target="_blank">
                        <p class="originItem" v-if="comment.comment_replied_id == null">
                            reply in&nbsp;&nbsp;&nbsp;{{comment.share_abstract}}
                        </p>
                        <p class="originItem"  v-else>
                        reply to&nbsp;&nbsp;&nbsp;
                           <img class="commentReplyPortrait" :src="$img(comment.reply_user_pic)">{{comment.reply_user_name}}:{{comment.comment_replied_content}} {{comment.comment_replied_created_at}}
                        </p>
                        </a>
                    </div>
                    <paginator
                        :total="total"
                        url="getUserAllComments"
                        @result="setUserAllComments"
                    ></paginator>
                </div>
            <div class="tab-pane fade" id="ios">
                    <div v-for="like in likes">
                        {{like.user_name}}点赞了你的分享
                        <p>
                            <a :href="$homeUrl('share-detail', 'p')+'/'+like.share_id" target="_blank">
                                {{like.share_abstract}}
                            </a>
                        </p>
                        {{like.like_created_at}}
                    </div>
                </div>
            </div>
    </div>
</template>
<style>
.panel{
    margin: 100px auto;
}
.recieveLikePanel{
}
.commentPortrait{
    width:36px;
    height: 36px;
    border-radius: 50%;
    border:1px solid #ccc;
    margin-right: 10px;
}
.commentReplyPortrait{
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border:1px solid #ccc;
}
.recieveItem{
    padding-top: 20px;

    border-bottom: 1px dashed #ccc;
}
.replyItem{
}
.originItem{
    padding:10px 0px;
    padding-left: 20px;
    background:#f5f5f5;

}

</style>
<script>
    export default{
        name: 'Receive',
        data(){
            return{
                comments: [],
                likes: [],
                total: 1,
            }
        },
        mounted () {
            this.getUserAllComments();
            this.getAllLikes();
        },
        methods: {
            getUserAllComments () {
                this.$http.get(this.$adminUrl('getUserAllComments')).then((response) => {
                    this.$set(this, 'comments', response.body.data);
                    this.total = response.body.last_page;
                }, (response) => {

                });
            },
            setUserAllComments(comments){
                this.$set(this, 'comments', comments.data);
                this.total = comments.last_page;
            },

            getAllLikes () {
                this.$http.get(this.$adminUrl('getAllLikes')).then((response) => {
                    this.$set(this, 'likes', response.body.data);
                    this.total = response.body.last_page;
                }, (response) => {

                });
            },
            setAllLikes(likes){
                this.$set(this, 'likes', likes.data);
                this.total = likes.last_page;
            }
        },
    }
</script>
