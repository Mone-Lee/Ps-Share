<template>
    <div>
        <div>111this is head {{count}} + a : {{a}} + b: {{b}}</div>
        <div v-if="count == 2">show count</div>
    </div>
</template>
<style>

</style>
<script>

    import { mapState } from 'vuex';
    //import tmp from '../vuex/mapState';


    export default{
        name:'MyHead',
        computed:mapState([
            'count',
            'a',
            'b'
        ])
    }
</script>
