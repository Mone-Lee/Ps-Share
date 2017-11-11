<template xmlns:v-validate="http://www.w3.org/1999/xhtml">

    <div>

        <file-upload></file-upload>
        
        <p>==============================分享详情==================================</p>

            <share-detail></share-detail>

        <p>================================================================</p>
        <h1>Hello vue</h1>
        <my-head></my-head>
        
        <div @click="logout">logout</div>

        <p>
            <router-link to="/foo">Foo</router-link>
            <router-link to="/bar">Bar</router-link>
            <router-link to="/user/1">User1</router-link>
            <router-link to="/user/2">User2</router-link>
            <router-link to="/user/3/child">User3</router-link>
        </p>

        <router-view></router-view>

        <p>================================================================</p>

        <div>{{ checkIds }}</div>
        <div>
            <button @click="batchDelete">批量删除</button>
        </div>

        <table>
            <tr>
                <th></th>
                <th>name</th>
                <th>操作</th>
            </tr>
            <template v-for="(ShareClassification, index) in ShareClassifications">
                <tr>
                    <td>
                        <input type="checkbox" :value="ShareClassification.id" v-model="checkIds">
                    </td>
                    <td @click="editName(ShareClassification)">
                        {{ShareClassification.name}}
                    </td>
                    <td>
                        <button @click="deleteShareClassification(index, ShareClassification.id)">删除</button>
                    </td>

                </tr>
            </template>
        </table>

        <p>================================================================</p>

        <label for="SCname">name</label><input id="SCname" type="text" v-model="ShareClassification.name">

        <button @click="addShareClassification" v-if="!edit">addShareClassification</button>
        <template v-else>
            <button @click="SaveShareClassification">SaveShareClassification</button>
            <button @click="cancelEdit">cancelEdit</button>
        </template>

        <p>================================================================</p>

        <form @submit.prevent="validateBeforeSubmit" enctype="multipart/form-data">
            <!--<input type="hidden" name="_token" :value="token">-->
            <picture-upload :picNumber="6" picSrc="/images/add.png"></picture-upload>
            <div>
                <label for="abstract">摘要</label>
                <input v-model="share.abstract" type="text" name="abstract" id="abstract">
            </div>
            <div>
                <label for="content">描述</label>
                <input v-model="share.content" type="text" name="content" id="content">
            </div>
            <select v-model="share.share_classification_id">
                <option :value="ShareClassification.id" v-for="(ShareClassification, index) in ShareClassifications">
                    {{ShareClassification.name}}
                </option>
            </select>
            <input type="submit" value="提交">
        </form>

        <p>================================================================</p>


        <template v-for="(share, index) in list">
            <input v-model="shareIds" :value="share.share.id" type="checkbox">
            <div v-for="picture in share.pictures">
                <img :src="$img(picture.path)">
            </div>
            <div>
                <label for="abstract">摘要</label>
                <input v-model="share.share.abstract" type="text" name="abstract">
            </div>
            <div>
                <label for="content">描述</label>
                <input v-model="share.share.content" type="text" name="content">
            </div>
            <select v-model="share.share_classification_id">
                <option :value="ShareClassification.id" v-for="(ShareClassification, index) in ShareClassifications">
                    {{ShareClassification.name}}
                </option>
            </select>
            <button @click="deleteShare(share.share)" type="button">删除</button>
        </template>
        <button @click="batchDeleteShare" type="button">批量删除</button>

        <p>================================================================</p>

        <label>摘要</label>
        <input v-model="shareSearch.abstract" type="text" placeholder="摘要">
        <label>状态</label>
        <select v-model="shareSearch.status">
            <option value="-1">全部</option>
            <option value="1">正常</option>
            <option value="2">屏蔽</option>
            <option value="0">未发布</option>
        </select>

        <button @click="searchShare">搜索</button>

        {{shareSearch}}

        <p>================================================================</p>

        <paginator
            :total="total"
             url="share"
        ></paginator>

        <p>================================================================</p>

        <form @submit.prevent="changeUserMsg" enctype="multipart/form-data">
            <img :src="$img(user.pic)">
            <input @change="getPicture" type="file" name="picture">
            <div>
                <label>性别</label>
                <input v-model="user.sex" type="radio" value="1" name="sex" id="male">
                <label for="male">男</label>
                <input v-model="user.sex" type="radio" value="0" name="sex" id="female">
                <label for="female">女</label>
            </div>
            <div>
                <label for="introduction">简介</label>
                <input v-model="user.introduction" type="text" name="introduction" id="introduction">
            </div>
            <input type="submit" value="提交">
        </form>

        {{picture}}

        <p>================================================================</p>

        <form @submit.prevent="changePassword" enctype="multipart/form-data">
            <div>
                <label for="password">新密码</label>
                <input
                        v-model="password.password"
                        data-as="新密码"
                        type="password" name="password" id="password">
            </div>
            <div>
                <label for="password_confirmation">确认密码</label>
                <input
                        v-model="password.password_confirmation"
                        v-validate.initial="password.password_confirmation"
                        data-rules="confirmed:password"
                        data-as="确认密码"
                        type="password" name="password_confirmation" id="password_confirmation">
                <span v-show="errors.has('password.password_confirmation')">{{ errors.first('password.password_confirmation') }}</span>
            </div>
            <input type="submit" value="提交">
        </form>

        <p>================================================================</p>

        <input v-model="newClassification.name" type="text" name="classificationName">
        <button @click="addClassificationName" type="button">新增</button>

        <input v-model="classification.name" type="text" name="classificationName">
        <button @click="saveClassificationName" type="button">保存</button>
        <button @click="deleteClassificationName" type="button">删除</button>

        <p>================================================================</p>

        <validator-test
            msg="hell"
            @back="showBackMsg"
        ></validator-test>


        <p>================================================================</p>

        <button @click="move" type="button">move</button>
        <button @click="copy" type="button">copy</button>

        <p>================================================================</p>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

    </div>


</template>
<style>

</style>
<script>
    import MyHead from '../components/app/Head.vue';
    import ValidatorTest from '../components/app/ValidatorTest.vue';
    import ShareDetail from '../components/app/ShareDetail.vue';
    import PictureUpload from '../components/public/picture-upload.vue';
    import Paginator from '../components/public/paginator.vue';
    import ReportDialog from '../components/public/report-dialog.vue';
    import FileUpload from '../components/app/file-upload.vue';
    import {mapState} from 'vuex';
    import {mapMutations} from 'vuex';

    export default{
        name:'App',
        mounted () {

            this.getShareClassifications();
            this.getShares();
            this.getUserMsg();
            this.getClassificationName();
        },
        data () {
            return {
                TmpShareClassification: {
                    id: 0,
                    name: ''
                },
                ShareClassification: {
                    id: 0,
                    name: '',
                    _method: ''
                },
                ShareClassifications: [],
                checkIds: [],
                edit:false,
                token: '',
                abstract:'',
                content:'',
                share: {
                    'share_classification_id':0,
                    'abstract':'',
                    'content':'',
                    'pics':[],
                    'status':1
                },
                shares:[],
                shareIds: [],
                total: 1,
                shareSearch: {
                    'abstract':'',
                    'status':-1
                },
                user: {
                    'pic':'',
                    'sex': 0,
                    'introduction': ''
                },
                picture: null,
                password: {
                    'password': '',
                    'password_confirmation': ''
                },
                newClassification: {
                    'id': 0,
                    'name': ''
                },
                classification: {
                    'id': 0,
                    'name': ''
                },

            }
        },
        computed:mapState([
            'pictures',
            'list'
        ]),
        components: {
            MyHead,
            PictureUpload,
            ValidatorTest,
            Paginator,
            ShareDetail,
            ReportDialog,
            FileUpload,
        },
        methods: {

            ...mapMutations([
                'setList',
                'setPaginatorParams'
            ]),

            /**
             *  退出登录
             */
            logout () {
                this.$http.post('/logout');
            },

            /**
             *  获取所有分享分类
             */
            getShareClassifications () {

                this.$http.get(this.$homeUrl('getAllClassification')).then((response) => {

                    this.$set(this, 'ShareClassifications', response.body);

                },
                (response) => {

                    //alert('fail in getting data!');

                });
            },

            /**
             *  新增分享分类
             */
            addShareClassification () {
                this.$http.post(this.$adminUrl('shareclassification'),this.ShareClassification).then((response) => {

                    if(response.body != 'false') {

                        this.ShareClassification.id = response.body;
                        this.ShareClassifications.push(this.ShareClassification);
                        this.ShareClassification = {id: 0, name: ''};

                    }else {

                        console.log('fail in adding');

                    }
                },
                (response) => {

                    console.log(response.body.name[0]);

                });
            },

            /**
             *  删除单个分享分类
             */
            deleteShareClassification (index, id) {

                this.$http.post(this.$adminUrl('shareclassification/') + id, {_method: "DELETE"}).then((response) => {

                    if(response.body == 'true'){
                        this.ShareClassifications.splice(index,1);
                    }else {
                        console.log(response.body);
                    }

                },
                (response) => {

                });
            },

            /**
             *  批量删除分享分类
             */
            batchDelete () {
                if(this.checkIds.length == 0){
                    alert('请选择');
                    return false;
                }
                this.$http.delete(this.$adminUrl('shareclassification/batch-delete'),{params:this.checkIds})
                    .then((response) => {

                        alert('成功删除'+response.body.result+'条');
                        this.$set(this, 'ShareClassifications', response.body.shareClassifications);
                        this.checkIds = [];

                    },
                    (response) => {

                    });
            },

             /**
             *  填充编辑分享分类的id和名称
             */
            editName(ShareClassification) {
                this.edit = true;
                this.ShareClassification = ShareClassification;
                this.TmpShareClassification.id = ShareClassification.id;
                this.TmpShareClassification.name = ShareClassification.name;
            },

            /**
             *  保存编辑的分享分类的名称
             */
            SaveShareClassification() {
                this.ShareClassification._method = "PUT";
                this.$http.post(this.$adminUrl('shareclassification/') + this.ShareClassification.id, this.ShareClassification).then((response) => {

                    console.log(response.body);
                    this.edit = false;
                    this.ShareClassification = {id: 0, name: ''};

                },
                (response) => {

                });
            },

            /**
             *  取消分享分类的编辑
             */
            cancelEdit(){
                this.edit = false;
                this.ShareClassification.id = this.TmpShareClassification.id;
                this.ShareClassification.name = this.TmpShareClassification.name;
                this.TmpShareClassification = {id: 0, name: ''};
                this.ShareClassification = {id: 0, name: ''};
            },

            /**
             *  分享表单的提交
             */
            validateBeforeSubmit() {
                let form = new FormData();
                form.append('share_classification_id', this.share.share_classification_id);
                form.append('abstract', this.share.abstract);
                form.append('content', this.share.content);
                form.append('status', this.share.status);
                for(let picture of this.pictures){
                    form.append('pictures[]', picture);
                }

                this.$http.post(this.$adminUrl('share'), form, {headers:{'Content-Type':'multipart/form-data'}}).then((response) => {
                    
                }, (response) => {

                });
            },

            /**
             *  获取用户后台页面的所有分享
             */
            getShares() {
                this.$http.get(this.$adminUrl('share/indexAdmin')).then((response) => {

                    // 设置分页的总页数
                    this.total = response.body.last_page;
                    // 更新全局list
                    this.setList(response.body.data);

                }, (response) => {

                });
            },

            /**
             *  删除单个分享
             */
            deleteShare(share) {
                console.log('in');
                this.$http.post(this.$adminUrl('share') + '/' + share.share_id, {_method: "DELETE"}).then((response) => {

                }, (response) => {

                });
            },

            /**
             *  批量删除分享
             */
            batchDeleteShare() {

                this.$http.delete(this.$adminUrl('share/batch-delete'),{params:this.shareIds}).then((response) => {

                }, (response) => {

                });
            },

            /**
             *  搜索分享
             */
            searchShare () {
                this.$http.get(this.$adminUrl('share/query'), {params:this.shareSearch}).then((response) => {

                    // 搜索中一定要用这个全局方法设置分页器的参数
                    this.setPaginatorParams(this.shareSearch)
                    // 设置分页的总页数
                    this.total = response.body.last_page;
                    // 更新全局list
                    this.setList(response.body.data);

                },(response) => {

                });
            },

            /**
             *  获取用户基本信息
             */
            getUserMsg () {
                this.$http.get(this.$adminUrl('getUserMsg')).then((response) => {
                    this.$set(this,'user',response.body);
                }, (response) => {

                });
            },

            /**
             *  获取图片
             */
            getPicture (event) {
                this.picture = event.target.files[0];
            },

            /**
             *  修改用户基本信息
             */
            changeUserMsg () {
                let form = new FormData();
                form.append('sex', this.user.sex);
                form.append('introduction', this.user.introduction);
                form.append('picture', this.picture);

                this.$http.post(this.$adminUrl('saveUserMsg'), form, {headers:{'Content-Type':'multipart/form-data'}}).then((response) => {

                }, (response) => {

                });
            },

            /**
             * 修改密码
             */
            changePassword () {
                // 验证表单
                this.$validator.validateAll();
                // 如果表单报错则不提交
                if(this.errors.any()) {
                    return false;
                }else {
                    this.$http.post(this.$adminUrl('changePassword'), this.password).then((response) => {

                    }, (response) => {

                    });
                }

            },

            /**
             *  获取当前用户某个关注分类的信息
             */
            getClassificationName(){
                this.$http.get(this.$adminUrl('followClassification')+'/25/edit').then((response) => {
                    this.classification.id = response.body.id;
                    this.classification.name = response.body.name;
                }, (response) => {

                });
            },

            /**
             *  新增关注分类
             */
            addClassificationName() {
                this.$http.post(this.$adminUrl('followClassification'), this.newClassification).then((response) => {
                    this.newClassification.id = response.body;
                }, (response) => {

                });
            },

            /**
             *  保存当前用户某个关注分类的编辑后的信息
             */
            saveClassificationName() {
                this.$http.put(this.$adminUrl('followClassification')+'/'+this.classification.id, this.classification).then((response) => {

                }, (response) => {

                });
            },
            /**
             *  删除关注分类
             */
            deleteClassificationName() {
                this.$http.delete(this.$adminUrl('followClassification')+'/'+this.classification.id).then((response) => {

                }, (response) => {

                });
            },

            showBackMsg (msg) {
                console.log(msg);
            },

            move () {

                this.$http.get(this.$adminUrl('collection/move'), {
                    params:{
                        shareIds: [30,31,32,33,35],
                        oldClassificationId: 8,
                        newClassificationId: 13
                    }
                }).then((response) => {

                }, (response) => {

                });
            },

            copy () {
                this.$http.get(this.$adminUrl('collection/copy'), {
                    params:{
                        shareIds: [30,31,32,33,35],
                        oldClassificationId: 13,
                        newClassificationId: 8
                    }
                }).then((response) => {

                }, (response) => {

                });
            },

        }
    }


</script>
