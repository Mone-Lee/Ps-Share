<template>
    <div>

    </div>
</template>
<style>
</style>
<script>
    import CommentInput from './CommentInput.vue'
    export default{
        name: 'CommentReply',
        props: {
            comments: {
                type: Array,
                default () {
                    return []
                }
            },
            showCommentInput: {
                type: Boolean,
                default: false
            }
        },
        data(){
            return{

            }
        },
        components: {
            CommentInput
        },
    }
</script>
