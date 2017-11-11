<template>
    <div>
        <div>
            用户：{{user.name}}
        </div>
        <!--发布者信息-->
        <div>
            <p>姓名：{{ShareUser.name}}</p>
            <p>头像：<img :src="$img(ShareUser.pic)"></p>
            <p>简介：{{ShareUser.introduction}}</p>
            <p>
                性别：
                <span v-if="ShareUser.sex == 0">女</span>
                <span v-else>男</span>
            </p>
        </div>
        <!--分享的详细信息-->
        <div>
            <p><button @click="reportShare(share.id, false)">举报此分享</button></p>
            <p>
                <span v-for="picture in share.pictures">
                    <img :src="$img(picture.path)">
                </span>
            </p>
            <p>摘要：{{share.abstract}}</p>
            <p>内容：{{share.content}}</p>
            <p>发布时间：{{share.created_at}}</p>
            <p>分类：{{share.sc_name}}</p>
            <p>点赞数：{{share.likes}}</p>
            <p>收藏数：{{share.collections}}</p>
        </div>
        <comment-input
            :pic="user.pic"
            :pid="-1"
            :commentId="-1"
            :shareId="share.id"
            :useredId="ShareUser.id"
            @getAllComments="getAllComments"
        ></comment-input>
        <!--评论-->
        <div>
            <div v-for="(comment, index) in comments">
                <div>
                    <p>
                        {{comment.comment.user_name}}：{{comment.comment.content}}
                        <button type="button" @click="showCommentInput(index, comment.comment.id, comment.comment.id, comment.comment.user_id)">回复</button>
                        <button @click="reportShare(comment.comment.id, true)">举报</button>
                    </p>
                    <p v-for="(commentReply, item) in comment.commentReplies.data" style="margin-left: 50px">
                        {{commentReply.user_name}}:
                        <span v-if="comment.comment.id != commentReply.pid">
                            回复 @{{commentReply.users_replied_name}}
                        </span>
                        {{commentReply.content}}
                        <button type="button" @click="showCommentInput(index, commentReply.comment_replies_id, comment.comment.id, commentReply.user_id, commentReply.user_name)">回复</button>
                        <button @click="reportShare(commentReply.comment_replies_id, true)">举报</button>
                    </p>
                </div>
                <div>
                    <comment-input
                            v-if="commentFlag.index == index && commentFlag.flag == true"
                            :pic="commemtReply.pic"
                            :pid="commemtReply.pid"
                            :commentId="commemtReply.commentId"
                            :shareId="commemtReply.shareId"
                            :useredId="commemtReply.useredId"
                            :useredName="commemtReply.useredName"
                            @getCommentReply="getCommentReply(comment)"
                    ></comment-input>
                </div>
            </div>
        </div>
        <report-dialog
            :id="id"
            :flag="flag"
            v-if="show"
            @close="show=false"
        ></report-dialog>
    </div>
</template>
<style>
</style>
<script>
    import CommentReply from './CommentReply.vue'
    import CommentInput from './CommentInput.vue'
    import ReportDialog from '../public/report-dialog.vue';
    export default{
        name: 'ShareDetail',
        data(){
            return {
                user: {
                    'id': 0,
                    'pic': '',
                    'name': ''
                },
                // 分享拥有者的信息
                ShareUser: {
                    'id': 0,
                    'name': '',
                    'pic': '',
                    'introduction': '',
                    'sex': 0
                },
                // 分享的详细信息
                share: {
                    'id': 0,
                    'pictures': [],
                    'abstract': '',
                    'content': '',
                    'created_at': '',
                    'sc_id': 0,
                    'sc_name': '',
                    'likes': 0,
                    'collections': 0
                },
                comments: [],
                commentFlag: {
                    'index': -1,
                    'flag': false,
                },
                commemtReply: {
                    'pic': '',
                    'pid': -1,
                    'commentId': -1,
                    'shareId': -1,
                    'useredId': -1,
                    'useredName': ''
                },
                id: 0,
                flag: false,
                show: false,
            }
        },
        mounted () {
            this.getUserMsg();
            this.getShareDetail();
            this.getAllComments();
        },
        components: {
            CommentReply,
            CommentInput,
            ReportDialog,
        },
        methods: {

            reportShare (id, flag) {
                this.id = id;
                this.flag = flag;
                this.show = true;
            },

            /**
            * 获取用户信息
            */
            getUserMsg () {
                this.$http.get(this.$adminUrl('getUserMsg')).then((response)=>{
                    this.user.id = response.body.user_id;
                    this.commemtReply.pic = this.user.pic = response.body.pic;
                    this.user.name = response.body.name;
                },(response) => {

                });
            },

            /**
            * 获取分享的详细信息
            */
            getShareDetail () {
                this.$http.get(this.$homeUrl('getShareDetail')+'/'+36).then((response) => {

                    this.ShareUser.id = response.body.user_id;
                    this.ShareUser.name = response.body.user_name;
                    this.ShareUser.pic = response.body.pic;
                    this.ShareUser.introduction = response.body.introduction;
                    this.ShareUser.sex = response.body.sex;

                    this.commemtReply.shareId = this.share.id = response.body.share_id;
                    this.share.pictures = response.body.pictures;
                    this.share.abstract = response.body.abstract;
                    this.share.content = response.body.content;
                    this.share.created_at = response.body.created_at;
                    this.share.sc_id = response.body.sc_id;
                    this.share.sc_name = response.body.sc_name;
                    this.share.likes = response.body.likes;
                    this.share.collections = response.body.collections;

                },(response) => {

                })
            },
            /**
            * 获取所有评论
            */
            getAllComments () {
                this.$http.get(this.$homeUrl('getAllComments/36')).then((response) => {
                    this.$set(this, 'comments', response.body.data);
                    this.commentFlag = {
                        'index': -1,
                        'flag': false,
                    };
                }, (response) => {

                });
            },

            showCommentInput(index, pid, commentId, useredId, useredName=''){
                this.commentFlag.index = index;
                this.commentFlag.flag = true;
                this.commemtReply.pid = pid;
                this.commemtReply.commentId = commentId;
                this.commemtReply.useredId = useredId;
                this.commemtReply.useredName = useredName;

            },

            getCommentReply(comment) {
                this.$http.get(this.$homeUrl('getAllCommentReplies')+'/'+this.share.id+'/'+comment.comment.id).then((response) => {
                    comment.commentReplies.data = response.body.data;
                    this.commentFlag = {
                        'index': -1,
                        'flag': false,
                    };
                }, (response) => {

                });
            },
        },
    }
</script>
