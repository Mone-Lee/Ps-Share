<template>
    <div class="commentSubmit">
        <img :src="$img(pic)" class="userPortrait userPortrait-small">
        <textarea v-model="replyMsg" v-focus>
        </textarea>
        <p class="commentSubmit__buttons">
        <button @click="submitComment" type="button" class="commentSubmit__submitbtn">发表评论</button>
        <button @click="closeComment" type="button" class="commentSubmit__submitbtn" v-show="isReply">关闭</button>
        </p>
        </div>
</template>
<style>
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
        vertical-align: top;
    }
    .commentSubmit{
        width: 100%;
        height: 170px;
        position: relative;
        overflow: hidden;
        /*border:1px solid #ccc;*/
        padding-left: 15px;
    }
    .commentSubmit>textarea{
        width: 615px;
        margin-left: 10px;
        height: 100px;
        margin-top:10px;
    }
    .commentSubmit__buttons{
                position: absolute;
        right: 40px;
        bottom:10px;
    }
    .commentSubmit__submitbtn{
        font-size: .8em;
        background: #fff;
        border:1px solid #b6b6b6;
        border-radius: 3px;
        padding:5px 20px; 
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
        margin-left: 30px;

    }
    .commentSubmit__submitbtn:hover{
        background: #b6b6b6;
        color:#fff;
        cursor: pointer;
    }
    .comment__sendbtn:hover{
        background: #b6b6b6;
        color:#fff;
        cursor: pointer;
    }
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
            },
            isReply:{
                type:Boolean,//是否回复
            }
        },
        data(){
            return{
                comment: {
                    'pid': this.pid,
                    'comment_id': this.commentId,
                    'share_id': this.shareId,
                    'usered_id': this.useredId,
                    'content': '',
                },
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
            },
            closeComment(){
                this.$emit('getCommentReply');
                
            }
        },
    }
</script>
