/**
*   图片上传组件
*   描述：这是个图片上传组件，支持图片多选。
*
*   picNumber {Number} : 可上传的图片数
*   pattern {Array} : 图片格式
*   picSrc {String} : 新增图片的src
*/

<template>
    <div>
        <div class="show-pic" v-for="(srcPic, index) in srcPics">
            <div @click="selectPic" class="add-pic-btn">
                <img :src="$img(srcPic.src)">
                <div class="edit-shadow" v-if="showShadow" style="">点击重选</div>
            </div>
            <input v-if="picNumber != 1 && srcPic.src == picSrc" name="pictures" type="file" hidden="hidden" style="display: none;" @change="previewPic(srcPic,$event,index)" multiple>
            <input v-else @change="previewPic(srcPic,$event,index)" name="pictures" type="file" hidden="hidden" style="display: none;">
            <div>
                <button v-if="picNumber != 1 && srcPic.src != picSrc" type="button" @click="deletePic(index)" class="delete-pic-btn">删除</button>
            </div>
        </div>
    </div>
</template>

<style lang="sass">

    @import "../../../sass/function";

    .show-pic {
        width: pxToRem(100);
        height: pxToRem(100);
        margin-bottom: 2rem;
        border: 1px solid black;

        .delete-pic-btn {
            width: 92px;
            margin-top: 3px;
            background: white;
            border: 1px solid #9E9E9E;
            cursor: pointer;
        }
        
    }

    .add-pic-btn {
        position:relative;
        text-align:center;
        height: pxToRem(100);

        img {
            width: pxToRem(100);
            height: pxToRem(100);
            cursor:pointer;
    }

        div.edit-shadow {
            display:none;
    }

        &:hover > div.edit-shadow {
            display:block;
            position:absolute;
            top: 0;
            width: pxToRem(100);
            height: pxToRem(100);
            line-height: pxToRem(100);
            color:white;
            background-color: rgba(0, 0, 0, 0.5);
            cursor:pointer;
    }

    }

</style>

<script>

    import {mapMutations} from 'vuex'

    export default{
        name: 'PictureUpload',
        props:{
            // 图片数
            picNumber: {
                type: Number,
                default: 1
            },
            // 图片格式
            pattern: {
                type: Array,
                default () {
                    return ['jpeg', 'png'];
                }
            },
            // 新增图片的src
            picSrc: {
                type: String,
                default: 'images/add.png'
            },
            pictures: {
                type: Array,
                default () {
                    return [];
                }
            },

        },
        data () {
            return {
                showShadow: false,
                fileValue: '',
                srcPics:[]
            }
        },
        mounted () {
            if(this.pictures.length == 0) {
                this.srcPics.push({id:0,src:this.picSrc,order:0});
            }else {
                for(let picture of this.pictures){
                    this.srcPics.push({id:picture.id,src:picture.path,order:picture.order})
                }
                if(this.pictures.length < 6) {
                    this.srcPics.push({id:0,src:this.picSrc,order:0});
                }
            }
        },
        methods: {

            ...mapMutations([
                'pushPicture',
                'splicePicture',
                'deletePicture'
            ]),

            /**
            *  触发input[type="file"]的click事件来选择图片
            *
            * @param  {object} event
            */
            selectPic (event) {

                // 取出空格
                let obj = event.target.parentNode.nextSibling;
                if(obj.tagName != 'INPUT'){
                    obj = obj.nextSibling;
                }
                // 触发input的click事件
                obj.click();

            },
            /**
            *  获取input[type="file"]里的图片，预览到页面上
            *
            * @param  {object} srcPic
            * @param  {object} event
            * @param  {number} order
            */
            previewPic (srcPic, event, order) {

                // 获取选中的图片文件，并判断选中的图片数量是否合法
                let files = event.target.files;
                // 图片数量为0，直接返回
                if(!files.length) return;
                // 图片数量超过预定的数量，提示出错并直接返回
                if(files.length > this.picNumber - this.srcPics.length + 1) {
                    alert("只剩" + (this.picNumber - this.srcPics.length + 1) + "张可选");
                    return;
                }

                // 将pattern数组里的图片格式组装成"xxx|xxx|xxx"这样的格式，如："jpeg|png"
                let regexParams = '';
                for(let index = 0; index < this.pattern.length; index++) {
                   regexParams += this.pattern[index]+(index == this.pattern.length - 1?'':'|');
                }
                // 将组装后的图片格式字符串传给正则表达式构造器，最后生成如/\/(?:jpeg|png)/i这样的正则表达式
                let regex = new RegExp('\/(?:' + regexParams + ')', 'i');

                let end = this.srcPics.length;
                for(let index = 0; index < files.length; index++){

                    // 过滤图片格式，如果出现格式不合法的，则取消此图片的上传操作
                    if (!regex.test(files[index].type)){
                        alert("请选择格式为 " + this.pattern + " 的图片");
                        return;
                    }

                    // 开始读取选中的图片，添加预览到页面
                    let reader = new FileReader();
                    reader.readAsDataURL(files[index]);
                    reader.onload = e => {
                        // 把读取到的第一张图片存入页面中已有的预览模块
                        if(index == 0){
                            srcPic.src = e.target.result;
                            this.showShadow = true;
                            // 图片存入全局变量
                            this.splicePicture({order:order++,file:files[index]});
                        }else {
                            // 其余读取到的图片则需要新建预览模块来存放
                            this.srcPics[end++].src = e.target.result;
                            // 图片存入全局变量
                            this.pushPicture(files[index]);
                        }



                        // 如果预览模块少于预定，且srcPics数组最后一个元素不是新增元素，则加入新增元素
                        if(this.srcPics.length < this.picNumber && this.lastPicSrc()){
                            this.srcPics.push({id:0,src:this.picSrc,order:0});
                        }
                    }
                }

            },

            /**
            *  判断srcPics数组最后一个元素是不是新增元素
            */
            lastPicSrc () {
                return this.srcPics[this.srcPics.length-1].src != this.picSrc;
            },

            /**
            *  删除预览模块
            *
            * @param  {object} event
            */
            deletePic (index) {

                this.srcPics.splice(index, 1);
                this.deletePicture(index);
                if(this.srcPics.length < this.picNumber && this.lastPicSrc()){
                    this.srcPics.push({id:0,src:this.picSrc,order:0});
                }

            }
        },

    }

</script>
