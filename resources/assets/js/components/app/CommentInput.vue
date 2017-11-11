<template>
    <div>
        <img :src="$img(pic)" style="width:50px;border-radius:60px;border: 1px solid black;">
        <textarea v-model="replyMsg" v-focus>
        </textarea>
        <button @click="submitComment" type="button">发表评论</button>
    </div>
</template>
<style>
</style>
<script>
    export default{
        name: 'CommentInput',
        props: {
            pic: {
                type:String,
                default: ''
            },
            // 被回复评论id
            pid: {
                type:Number,
                default: 0
            },
            // 父评论id
            commentId: {
                type:Number,
                default: 0
            },
            // 分享id
            shareId: {
                type:Number,
                default: 0
            },
            // 被评论者id
            useredId: {
                type:Number,
                default: 0
            },
            useredName: {
                type: String,
                default: ''
            }
        },
        data(){
            return{
                comment: {
                    'pid': this.pid,
                    'comment_id': this.commentId,
                    'share_id': this.shareId,
                    'usered_id': this.useredId,
                    'content': ''
                }
            }
        },
        computed: {
            replyMsg: {
                get () {
                    if(this.pid != this.commentId){
                        return '回复 @' + this.useredName + ':' + this.comment.content;
                    }else {
                        return this.comment.content;
                    }
                },
                set (newValue) {
                    if(this.pid != this.commentId){
                        let tmp = newValue.split(':');
                        tmp[0] = '';
                        newValue = tmp.join(':').substring(1);
                    }
                    this.comment.content = newValue;
                }
            },
        },
        methods: {
            submitComment () {
                this.comment.pid = this.pid;
                this.comment.comment_id = this.commentId;
                this.comment.share_id = this.shareId;
                this.comment.usered_id = this.useredId;
                this.$http.post(this.$adminUrl('comment'), this.comment).then((response) => {
                    if(response.body == "true"){
                        if(this.pid == -1 && this.commentId == -1){
                            this.$emit('getAllComments');
                        }else {
                            this.$emit('getCommentReply');
                        }
                        this.comment.content = "";
                    }
                }, (response) => {

                });
            }
        },
    }
</script>
