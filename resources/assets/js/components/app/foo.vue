<template>
    <div>
        <div id="foo">this is foo</div>
        <div>{{count}}</div>
        <button @click="addCount">addCount</button>
    </div>
</template>
<style lang="sass">
    $bg: red;
    #foo {
        color: $bg;
    }
</style>
<script>

    export default{
        name:'Foo',
        computed:{
            count () {
                return this.$store.state.count;
            }
        },
        methods:{
            addCount () {
                this.$store.commit('increment');
            }
        }
    }
</script>
