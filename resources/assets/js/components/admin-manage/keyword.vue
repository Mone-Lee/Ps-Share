<template>
    <div>

        <div class="addKeyword">
            <label for="KWname">关键字：</label><input id="KWname" type="text" v-model="Keyword.name">
            <button @click="addKeyword" v-if="!edit" type="button">新增</button>
            <template v-else>
                <button @click="SaveKeyword" type="button">保存修改</button>
                <button @click="cancelEdit" type="button" class="cancel">取消</button>
            </template>
        </div>

        <table class="keyword-list">
            <tr>
                <th class="check"></th>
                <th class="name">关键字</th>
                <th class="count">命中次数</th>
                <th class="operate">操作</th>
            </tr>
            <template v-for="(Keyword, index) in Keywords">
                <tr>
                    <td class="check">
                        <input type="checkbox" :value="Keyword.id" v-model="checkIds">
                    </td>
                    <td @click="editName(Keyword)" class="name">
                        {{Keyword.name}}
                    </td>
                    <td class="count">
                        {{Keyword.count}}
                    </td>
                    <td class="operate">
                        <button @click="showConfirm(0, index, Keyword.id)" type="button">删除</button>
                    </td>
                </tr>
            </template>
        </table>

        <div class="batch-delete">
            <button @click="showConfirm(1)" type="button">批量删除</button>
        </div>

        <paginator
                :total="total"
                url="keyword"
                @result="setKeyword"
        ></paginator>

        <confirm
                :show="show"
                @confirmAction="oneOrBatchDelete"
                @cancelAction="show=false"
        ></confirm>

    </div>
</template>
<style lang="sass">

    @import "../../../sass/function";

    .addKeyword {
        width: pxToRem(500);
        margin: 0 auto;
        padding: 10px 0;
        text-align: center;

        input {
            width: pxToRem(194);
            height: pxToRem(25);
            padding-left: pxToRem(6);
    }

        button {
            padding: 0 pxToRem(13);
            height: pxToRem(29);
            background-color: white;
            border: 1px solid #9E9E9E;
            cursor: pointer;
    }

        .cancel {
            background-color: #9E9E9E;
            color: white;
    }

    }


    .keyword-list {
        width: pxToRem(500);
        margin: pxToRem(20) auto;
        text-align: center;

        tr {

            &:nth-child(odd){
                background-color: #fbfbfb;
        }

            &:nth-child(1) {
                background-color: #f1f1f1;
        }

            .check {

        }

            .name {
                padding: pxToRem(7) 0;
                cursor: pointer;
        }

            .operate {

        }

            button {
                width: pxToRem(58);
                height: pxToRem(26);
                background-color: white;
                border: 1px solid #f1f1f1;
                cursor: pointer;
        }
    }
    }

    .batch-delete {
        width: pxToRem(500);
        margin: 0 auto;

        button {
            height: pxToRem(29);
            padding: 0 pxToRem(17);
            background-color: white;
            border: 1px solid #9E9E9E;
            cursor: pointer;
    }
    }

</style>
<script>
    export default{
        name: 'Keyword',
        mounted () {
            this.getKeywords();
        },
        data(){
            return{
                TmpKeyword: {
                    id: 0,
                    name: ''
                },
                Keyword: {
                    id: 0,
                    name: ''
                },
                Keywords: [],
                checkIds: [],
                edit: false,
                show: false,
                type: 0,
                deleteTmp: {
                    id: 0,
                    index: 0
                },
                total: 0,
            }
        },
        methods: {
            /**
             *  获取所有关键字
             */
            getKeywords () {

                this.$http.get(this.$adminUrl('keyword')).then((response) => {

                    this.$set(this, 'Keywords', response.body.data);
                    this.total = response.body.last_page;

                },
                (response) => {

                    this.$alert('连接错误', 'e');

                });
            },

            /**
             *  新增关键字
             */
            addKeyword () {
                this.$http.post(this.$adminUrl('keyword'),this.Keyword).then((response) => {

                    if(response.body != 'false') {

                        this.Keyword.id = response.body;
                        this.Keywords.push(this.Keyword);
                        this.Keyword = {id: 0, name: ''};
                        this.$alert('新增成功', 's');

                    }else {

                        this.$alert('新增失败', 'e');

                    }
                },
                (response) => {

                    if(response.body.name[0] == 'The name field is required.'){
                        this.$alert('关键字必填', 'e');
                    }else if(response.body.name[0] == 'The name has already been taken.'){
                        this.$alert('关键字重复', 'e');
                    }else if(response.body.name[0] == 'The name may not be greater than 10 characters.'){
                        this.$alert('长度小于10', 'e');
                    }else {
                        this.$alert('连接错误', 'e');
                    }

                });
            },

            /**
             *  显示删除提示框
             */
            showConfirm (type, index=0, id=0) {
                this.type = type;
                if(type == 0){
                    this.show = true;
                    this.deleteTmp.index = index;
                    this.deleteTmp.id = id;
                }else {
                    if(this.checkIds.length == 0){
                        this.$alert('请选择');
                    }else {
                        this.show = true;
                    }
                }
            },

            /**
             *  根据type判断是单个删除还是批量删除
             */
            oneOrBatchDelete () {
                if(this.type == 0){
                    this.deleteKeyword(this.deleteTmp.index, this.deleteTmp.id);
                }else {
                    this.batchDelete();
                }
            },

            /**
             *  删除单个关键字
             */
            deleteKeyword (index, id) {

                this.$http.delete(this.$adminUrl('keyword/') + id).then((response) => {

                    if(response.body == 'true'){
                        this.Keywords.splice(index,1);
                        this.show = false;
                        this.$alert('删除成功');
                    }else {
                        this.$alert('删除失败', 'e');
                    }

                },
                (response) => {
                    this.$alert('连接错误', 'e');
                });
            },

            /**
             *  批量删除分关键字
             */
            batchDelete () {
                this.$http.delete(this.$adminUrl('keyword/batch-delete'),{params:this.checkIds})
                    .then((response) => {


                        this.$set(this, 'Keywords', response.body.keywords);
                        this.checkIds = [];

                        this.show = false;
                        this.$alert('成功删除'+response.body.result+'条');

                    },
                    (response) => {
                        this.$alert('连接错误', 'e');
                    });
            },

             /**
             *  填充编辑分享分类的id和名称
             */
            editName(Keyword) {
                this.edit = true;
                this.Keyword = Keyword;
                this.TmpKeyword.id = Keyword.id;
                this.TmpKeyword.name = Keyword.name;
            },

            /**
             *  保存编辑的关键字的名称
             */
            SaveKeyword() {
                this.$http.put(this.$adminUrl('keyword/') + this.Keyword.id, this.Keyword).then((response) => {

                    if(response.body == 'true'){
                        this.edit = false;
                        this.Keyword = {id: 0, name: ''};
                        this.$alert('修改成功', 's');
                    }else if(response.body == "the name already exist") {
                        this.$alert('名字重复', 'e');
                    }else if(response.body ==  'nothing change') {

                    }else {
                        this.$alert('修改失败', 'e');
                    }


                },
                (response) => {
                    if(response.body.name[0] == 'The name field is required.'){
                        this.$alert('关键字必填', 'e');
                    }else if(response.body.name[0] == 'The name may not be greater than 10 characters.'){
                        this.$alert('长度小于10', 'e');
                    }else {
                        this.$alert('连接错误', 'e');
                    }
                });
            },

            /**
             *  取消关键字的编辑
             */
            cancelEdit(){
                this.edit = false;
                this.Keyword.id = this.TmpKeyword.id;
                this.Keyword.name = this.TmpKeyword.name;
                this.TmpKeyword = {id: 0, name: ''};
                this.Keyword = {id: 0, name: ''};
            },

            setKeyword (keyword) {
                this.$set(this, 'Keywords', keyword.data);
                this.total = keyword.last_page;
            },

        },
    }
</script>
