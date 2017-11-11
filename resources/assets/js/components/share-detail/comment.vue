<template>
    <section class="commentArea">
        <div class="comment__title">留言</div>
        <comment-input
                :pic="userPic"
                :pid="-1"
                :commentId="-1"
                :shareId="shareId"
                :useredId="shareUserId"
                :isReply="false"
                @getAllComments="getAllComments"
        ></comment-input>
        <section class="comments"  v-for="(comment, index) in comments">
            <section>
                <section class="comment comment-origin">
                    <div class="comment__left">
                        <img :src="$img(userPic)" alt="" class="userPortrait userPortrait-small">
                        <a :href="$adminUrl('user-index', 'p')+'/'+comment.comment.user_id" class="comment__userName" target="_blank">{{comment.comment.user_name}}</a>
                    </div>
                    <div class="comment__right">
                        <p>
                            <small class="comment__date">{{comment.comment.created_at}}</small>
                            <a href="javascript:;" class="comment__replyLink" type="button" @click="showCommentInput(index, comment.comment.id, comment.comment.id, comment.comment.user_id)">回复</a>
                            <a href="javascript:;" class="comment__replyLink" type="button" @click="reportComment(comment.comment.id, true)">举报</a>
                        </p>
                        <p class="comment__content">{{comment.comment.content}}</p>
                    </div>
                </section>
                <section class="comment comment-reply" v-for="(commentReply, item) in comment.commentReplies.data">
                    <div class="comment__left">
                        <img :src="$img(commentReply.pic)" alt="" class="userPortrait userPortrait-small">
                        <a :href="$adminUrl('user-index', 'p')+'/'+commentReply.user_id" class="comment__userName" target="_blank">{{commentReply.user_name}}</a>
                    </div>
                    <div class="comment__right">
                        <p>
                            <small class="comment__date">{{commentReply.created_at}}</small>
                            <a href="javascript:;"  class="comment__replyLink" @click="showCommentInput(index, commentReply.comment_replies_id, commentReply.pic,comment.comment.id, commentReply.user_id, commentReply.user_name)">回复  </a>
                            <a href="javascript:;"  class="comment__replyLink" @click="reportComment(commentReply.comment_replies_id, true)">举报</a>
                        </p>
                        <p class="comment__content"><span v-if="comment.comment.id != commentReply.pid">回复<a :href="$adminUrl('user-index', 'p')+'/'+commentReply.comment_replied_user_id" target="_blank" class="comment__replyLink">@{{commentReply.users_replied_name}}</a>：</span>
                         {{commentReply.content}}
                         </p>
                    </div>
                    
                </section>
                <paginator-list
                            :total="comment.commentReplies.last_page"
                            url="getAllCommentReplies"
                            urlType="home"
                            :paginatorParams="$objectToParam({'shareId':shareId, 'commentId':comment.comment.id })"
                            @flashPage="flashPage"
                ></paginator-list>
            </section>
            <comment-input
                v-if="commentFlag.index == index && commentFlag.flag == true"
                :pic="commemtReply.pic"
                :pid="commemtReply.pid"
                :commentId="commemtReply.commentId"
                :shareId="commemtReply.shareId"
                :useredId="commemtReply.useredId"
                :useredName="commemtReply.useredName"
                :isReply="true"
                @getCommentReply="getCommentReply(comment)"
            ></comment-input>
        </section>

        <report-dialog
                :id="id"
                :flag="flag"
                v-if="show"
                @close="show=false"
        ></report-dialog>

        <paginator
            :total="total"
            url="getAllComments"
            :paginatorParams="{shareId: this.shareId}"
            :isAdmin="isAdmin"
            @result="setAllComments"
        ></paginator>

    </section>

</template>
<style>
    .commentArea{
        background:#f5f5f5;
        border:1px solid #eee;
    }
    .comments{
        background: #fff;
        overflow: hidden;
        width: 722px;
        /*padding-left: 20px;*/
        /*padding:0 40px;*/
    }
    .comment{
        overflow: hidden;
        padding: 20px 20px;
    }
    .comment p{
        font-size: 0.8em;
    }
    .comment__left{
        float: left;
        text-align: center;
        margin-right: 20px;
    }
    .comment__right{
        vertical-align: middle;
        line-height: 25px;
        margin-top: 5px;
    }
    .comment__date{
        font-size: 0.8em;
    }
    .comment__replyLink{
        font-size: 0.6em;
        color:#4caf50;
        margin-left: 10px;
    }
    .comment__userName{
        display: block;
        font-size: 12px;
        margin-top: -10px;
    }
    .comment__title{
        padding: 20px;
        font-size: 24px;
    }
    .comment-origin{
        border-top:1px solid #ccc; 
    }
    .comment-reply{
        margin-left: 60px;
        border-top: 1px dashed #ccc;
    }
    .userPortrait{
        border: 1px dashed #aaa;
        background: #fff;
        margin: 10px 0px; 
        border-radius: 5px;
    }
    .userPortrait-mid{
        width: 72px;
    }
    .userPortrait-small{
        width: 56px;
        height: 56px;
    }
</style>
<script>
    import CommentInput from './comment-input.vue';
    import PaginatorList from '../public/paginator-list.vue';
    import ReportDialog from '../public/report-dialog.vue';

    export default{
        name: 'Comment',
        props:{
            userPic:{
                type: String,
                default: ''
            },
            shareUserId: {
                type: Number,
                default: -1
            }
        },
        data(){
            return {
                shareId: 0,
                comments: [],
                commentFlag: {
                    'index': -1,
                    'flag': false,
                },
                commemtReply: {
                    'pic': this.userPic,
                    'pid': -1,
                    'commentId': -1,
                    'shareId': -1,
                    'useredId': -1,
                    'useredName': ''
                },
                commemtReplyUrl: 'getAllCommentReplies',
                id: 0,
                flag: false,
                show: false,
                total: 1,
                isAdmin: false,
            }
        },
        mounted () {
            let href = [];
            href = location.href.split('/');
            let shareId = href[href.length-1];
            this.commemtReply.shareId = this.shareId = Number(shareId);
            this.getAllComments();
        },
        components: {
            CommentInput,
            PaginatorList,
            ReportDialog,
        },
        methods: {

            /**
            * 获取所有评论
            */
            getAllComments () {
                this.$http.get(this.$homeUrl('getAllComments'),{params:{shareId: this.shareId}}).then((response) => {
                    this.$set(this, 'comments', response.body.data);
                    this.total = response.body.last_page;
                    this.commentFlag = {
                        'index': -1,
                        'flag': false,
                    };
                }, (response) => {

                });
            },

            setAllComments(comments){
                this.$set(this, 'comments', comments.data);
                this.total = comments.last_page;
                this.commentFlag = {
                    'index': -1,
                    'flag': false,
                };
            },

            showCommentInput(index, pid, pic,commentId, useredId, useredName=''){
                this.commentFlag.index = index;
                this.commentFlag.flag = true;
                this.commemtReply.pid = pid;
                this.commemtReply.pic = pic;
                this.commemtReply.commentId = commentId;
                this.commemtReply.useredId = useredId;
                this.commemtReply.useredName = useredName;

            },
            getCommentReply(comment) {
                this.$http.get(this.$homeUrl('getAllCommentReplies'), {params:{'shareId':this.shareId, 'commentId':comment.comment.id}}).then((response) => {
                    comment.commentReplies = response.body;
                    this.commentFlag = {
                        'index': -1,
                        'flag': false,
                    };
                }, (response) => {

                });
            },

            flashPage (commentReply) {
                for(let comment of this.comments){
                    if(commentReply[0].comment_id == comment.comment.id){
                        comment.commentReplies.data = commentReply;
                    }
                }
            },

            reportComment(id ,flag){
                this.id = id;
                this.flag = flag;
                this.show = true;
            },

        },
    }
</script>
