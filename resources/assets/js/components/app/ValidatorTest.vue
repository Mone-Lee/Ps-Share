<template>
    <div>
        <form @submit="validateForm">
            <slot></slot>
            <div>
                <label for="content">content</label>
                <input name="content" id="content" v-model="content" v-validate.initial="content" data-rules="required|mix:1|max:10">
                <span v-if="errors.has('content')">{{ errors.first('content') }}</span>
            </div>
            <div>
                <label for="abstract">abstract</label>
                <input name="abstract" id="abstract" v-model="abstract" v-validate.initial="abstract" data-rules="required|mix:1|max:5">
                <span v-if="errors.has('abstract')">{{ errors.first('abstract') }}</span>
            </div>
            <div>
                <input type="submit" value="提交">
            </div>
        </form>
        <button @click="back" type="button">回复</button>
    </div>
</template>

<script>
    export default{
        name: 'ValidatorTest',
        props: {
            msg: ''
        },
        data () {
            return {
                content: '',
                abstract: ''
            }
        },
        methods: {
            validateForm (e) {
                this.$validator.validateAll();

                if(this.errors.any()) {
                    e.preventDefault();
                }
            },
            back () {
                this.$emit('back', 'hello');
            }
        }
    }
</script>
