import {mapState} from 'vuex';

export default {
    computed: mapState({
        count: 'count',
        a: 'a',
        b: 'b'
    })
}