webpackJsonp([20],{

/***/ 275:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(276)

	/* script */
	__vue_exports__ = __webpack_require__(277)

	/* template */
	var __vue_template__ = __webpack_require__(282)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	if (Object.keys(__vue_exports__).some(function (key) { return key !== "default" && key !== "__esModule" })) {console.error("named exports are not supported in *.vue files.")}
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\share-detail\\userFollow.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (true) {(function () {
	  var hotAPI = __webpack_require__(51)
	  hotAPI.install(__webpack_require__(52), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-cbbaed90", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-cbbaed90", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] userFollow.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 276:
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },

/***/ 277:
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});

	var _popFrame = __webpack_require__(278);

	var _popFrame2 = _interopRequireDefault(_popFrame);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	exports.default = {
	    name: 'userFollow',
	    props: {
	        followUserId: ""
	    },
	    data: function data() {
	        return {
	            // user:{
	            //     name:"Samyze",
	            //     sex:"♀",
	            //     portrait:"/images/add.png",
	            //     followings:10,
	            //     favorites:20,
	            // },
	            shareIntro: "啦啦啦",

	            // 当前登录用户的信息
	            user: {
	                'id': 0,
	                'pic': '',
	                'name': ''
	            },
	            // 分享拥有者的信息
	            shareUser: {
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
	                'collections': 0,
	                'statusLike': '',
	                'statusCollection': '',
	                'statusFollow': ''
	            },
	            shareId: 0,
	            followCollection: [],
	            isCollect: false,
	            isCreate: false,
	            createButton: true,
	            createdClassificationId: -1,

	            isJudge: false,

	            isSelf: false
	        };
	    },
	    mounted: function mounted() {
	        this.getShareId();
	        this.getShareDetail();
	        this.getUserFollow();
	        this.getUserMsg();
	    },

	    components: {
	        popFrame: _popFrame2.default
	    },
	    methods: {
	        getShareId: function getShareId() {
	            var href = [];
	            href = location.href.split('/');
	            var shareId = href[href.length - 1];
	            this.shareId = Number(shareId);
	        },

	        /**
	        * 获取分享的详细信息
	        */
	        getShareDetail: function getShareDetail() {
	            var _this = this;

	            this.$http.get(this.$homeUrl('getShareDetail') + '/' + this.shareId).then(function (response) {

	                _this.shareUser.id = response.body.user_id;
	                _this.shareUser.name = response.body.user_name;
	                _this.shareUser.pic = response.body.pic;
	                _this.shareUser.introduction = response.body.introduction;
	                _this.shareUser.sex = response.body.sex;

	                _this.share.id = response.body.share_id;
	                _this.share.pictures = response.body.pictures;
	                _this.share.abstract = response.body.abstract;
	                _this.share.content = response.body.content;
	                _this.share.created_at = response.body.created_at;
	                _this.share.sc_id = response.body.sc_id;
	                _this.share.sc_name = response.body.sc_name;
	                _this.share.likes = response.body.likes;
	                _this.share.collections = response.body.collections;
	                _this.share.statusLike = response.body.statusLike;
	                _this.share.statusCollection = response.body.statusCollection;
	                _this.share.statusFollow = response.body.statusFollow;
	            }, function (response) {});
	        },

	        /*获取用户关注分类*/
	        getUserFollow: function getUserFollow() {
	            var _this2 = this;

	            this.$http.get(this.$adminUrl('followClassification')).then(function (response) {
	                _this2.$set(_this2, 'followCollection', response.body);
	            }, function (response) {
	                alert('fail in getting followCollection!');
	            });
	        },

	        /**
	        * 获取用户信息
	        */
	        getUserMsg: function getUserMsg() {
	            var _this3 = this;

	            this.$http.get(this.$adminUrl('getUserMsg')).then(function (response) {
	                _this3.user.id = response.body.user_id;
	                _this3.user.pic = response.body.pic;
	                _this3.user.name = response.body.name;
	            }, function (response) {});
	        },
	        toFollow: function toFollow() {
	            this.isCollect = true;
	        },

	        /*点击‘x’按钮*/
	        closeCreate: function closeCreate() {
	            this.isCollect = false;
	        },

	        /*点击‘新建关注分类’按钮*/
	        createClassification: function createClassification() {
	            this.createButton = false;
	            this.isCreate = true;
	        },

	        /*点击‘取消’按钮*/
	        cancelCreate: function cancelCreate() {
	            document.getElementById('followName').value = '';
	            this.isCreate = false;
	            this.createButton = true;
	        },

	        /*关注*/
	        follow: function follow(follow_id) {
	            var _this4 = this;

	            this.$http.post(this.$adminUrl('follow'), { 'followed_id': this.followUserId, 'follow_classification_id': follow_id }).then(function (response) {
	                if (response.body != 'false') {
	                    _this4.isCollect = false;
	                    _this4.share.statusFollow = true;
	                    _this4.$alert('关注成功', 's');
	                    console.log('关注成功! 啦啦啦啦~~撒花~~');
	                } else {
	                    console.log('fail in following!');
	                }
	            }, function (response) {
	                console.log(response.body);
	            });
	        },

	        /*新建关注分类*/
	        createFollowClassification: function createFollowClassification() {
	            var _this5 = this;

	            var followName = document.getElementById('followName').value;
	            this.$http.post(this.$adminUrl('followClassification'), { 'name': followName }).then(function (response) {
	                if (!isNaN(response.body)) {
	                    console.log('新建成功! 啦啦啦啦~~撒花~~');
	                    _this5.createdClassificationId = response.body;
	                } else {
	                    console.log('fail in creating followClassification!');
	                }
	            });
	        },

	        /*新建关注分类并关注*/
	        createCollect: function createCollect() {
	            this.createFollowClassification();
	            this.follow(this.createdClassificationId);
	            this.cancelCreate();
	        },

	        /*取消关注*/
	        deleteFollow: function deleteFollow(isDelete) {
	            var _this6 = this;

	            if (isDelete) {
	                this.$http.delete(this.$adminUrl('follow/') + this.shareUser.id).then(function (response) {
	                    if (response.body != 'false') {
	                        _this6.share.statusFollow = false;
	                        _this6.$alert('取消关注成功', 's');
	                    } else {
	                        console.log('fail in deleteFollowing!');
	                    }
	                }, function (response) {
	                    return false;
	                });
	            }

	            this.isJudge = false;
	        },
	        judgeDeleteCollect: function judgeDeleteCollect() {
	            this.isJudge = true;
	        },

	        /*点击‘x’按钮*/
	        closeJudge: function closeJudge() {
	            this.isJudge = false;
	        }
	    }
	}; //
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//

/***/ },

/***/ 278:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(279)

	/* script */
	__vue_exports__ = __webpack_require__(280)

	/* template */
	var __vue_template__ = __webpack_require__(281)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	if (Object.keys(__vue_exports__).some(function (key) { return key !== "default" && key !== "__esModule" })) {console.error("named exports are not supported in *.vue files.")}
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\index\\popFrame.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (true) {(function () {
	  var hotAPI = __webpack_require__(51)
	  hotAPI.install(__webpack_require__(52), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-330e8f57", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-330e8f57", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] popFrame.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 279:
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },

/***/ 280:
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//


	exports.default = {
		name: 'PopFrame',
		mounted: function mounted() {
			// var overlay = document.getElementById('overlay')
			// document.addEventListener('click',(e) => {
			// 	console.log(overlay);
			// 	console.log(e.target);
			// 	if(e.target == overlay) this.show = false;
			// })
		},
		data: function data() {
			return {
				show: true
			};
		},

		props: {
			isShow: {
				type: Boolean,
				default: false
			}
		},
		computed: {
			// show(){
			// 	return this.isCollect;
			// }
		},
		methods: {}
	};

/***/ },

/***/ 281:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    directives: [{
	      name: "show",
	      rawName: "v-show",
	      value: (_vm.isShow),
	      expression: "isShow"
	    }],
	    staticClass: "c-pop"
	  }, [_vm._h('div', {
	    staticClass: "c-pop__overlay"
	  }), " ", _vm._h('div', {
	    staticClass: "c-pop__content"
	  }, [_vm._t("default")])])
	},staticRenderFns: []}
	if (true) {
	  module.hot.accept()
	  if (module.hot.data) {
	     __webpack_require__(51).rerender("data-v-330e8f57", module.exports)
	  }
	}

/***/ },

/***/ 282:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [_vm._h('div', {
	    staticClass: "select-follow"
	  }, [(!(_vm.followUserId == _vm.user.id)) ? _vm._h('span', {
	    directives: [{
	      name: "show",
	      rawName: "v-show",
	      value: (!_vm.share.statusFollow),
	      expression: "!share.statusFollow"
	    }],
	    staticClass: "userInfo__follow",
	    attrs: {
	      "href": ""
	    },
	    on: {
	      "click": _vm.toFollow
	    }
	  }, ["关注用户"]) : _vm._e(), " ", _vm._h('popFrame', {
	    attrs: {
	      "isShow": _vm.isCollect
	    }
	  }, [_vm._h('div', {
	    staticClass: "content-head"
	  }, [_vm._h('p', [_vm._h('span', {
	    staticClass: "follow-title"
	  }, ["关注"]), " ", _vm._h('span', {
	    staticClass: "close-button",
	    on: {
	      "click": _vm.closeCreate
	    }
	  }, ["x"])])]), " ", _vm._h('div', {
	    staticClass: "content-wrap"
	  }, [_vm._h('div', {
	    directives: [{
	      name: "show",
	      rawName: "v-show",
	      value: (_vm.isCreate),
	      expression: "isCreate"
	    }],
	    staticClass: "createClassification"
	  }, [_vm._h('input', {
	    staticClass: "new-input",
	    attrs: {
	      "type": "text",
	      "name": "collectionClassification",
	      "id": "followName",
	      "placeholder": "请输入关注分类的名字"
	    }
	  }), " ", _vm._h('div', {
	    staticClass: "new-buttons"
	  }, [_vm._h('button', {
	    staticClass: "new-sure",
	    on: {
	      "click": _vm.createCollect
	    }
	  }, ["新建并关注"]), " ", _vm._h('button', {
	    staticClass: "new-cancel",
	    on: {
	      "click": _vm.cancelCreate
	    }
	  }, ["取消"])])]), " ", _vm._h('div', {
	    staticClass: "content-list"
	  }, [_vm._l((_vm.followCollection), function(collection) {
	    return _vm._h('p', {
	      staticClass: "user-collection"
	    }, [_vm._h('span', {
	      on: {
	        "click": function($event) {
	          _vm.follow(collection.followClassification.id)
	        }
	      }
	    }, [_vm._s(collection.followClassification.name)])])
	  })]), " ", _vm._h('div', {
	    staticClass: "content-create"
	  }, [_vm._h('p', {
	    directives: [{
	      name: "show",
	      rawName: "v-show",
	      value: (_vm.createButton),
	      expression: "createButton"
	    }],
	    staticClass: "create-button",
	    on: {
	      "click": _vm.createClassification
	    }
	  }, ["新建关注分类"])])])]), " ", (!(_vm.followUserId == _vm.user.id)) ? _vm._h('span', {
	    directives: [{
	      name: "show",
	      rawName: "v-show",
	      value: (_vm.share.statusFollow),
	      expression: "share.statusFollow"
	    }],
	    staticClass: "userInfo__unfollow",
	    attrs: {
	      "href": ""
	    },
	    on: {
	      "click": _vm.judgeDeleteCollect
	    }
	  }, ["取消关注"]) : _vm._e(), " ", _vm._h('popFrame', {
	    attrs: {
	      "isShow": _vm.isJudge
	    }
	  }, [_vm._h('div', {
	    staticClass: "d-titleBar"
	  }, [_vm._h('div', {
	    staticClass: "d-title",
	    staticStyle: {
	      "display": "block"
	    }
	  }, ["删除确认"]), " ", _vm._h('a', {
	    staticClass: "d-close",
	    staticStyle: {
	      "display": "block"
	    },
	    attrs: {
	      "href": "javascript:;"
	    },
	    on: {
	      "click": _vm.closeJudge
	    }
	  }, ["×"])]), " ", _vm._h('div', {
	    staticClass: "judge-frame"
	  }, [_vm._h('div', {
	    staticClass: "d-content",
	    staticStyle: {
	      "padding": "20px 25px"
	    }
	  }, ["你确定要取消关注该用户吗？"]), " ", _vm._h('div', {
	    staticClass: "d-button"
	  }, [_vm._h('button', {
	    staticClass: "sure",
	    on: {
	      "click": function($event) {
	        _vm.deleteFollow(true)
	      }
	    }
	  }, ["确定"]), " ", _vm._h('button', {
	    staticClass: "cancel",
	    on: {
	      "click": function($event) {
	        _vm.deleteFollow(false)
	      }
	    }
	  }, ["取消"])])])])])])
	},staticRenderFns: []}
	if (true) {
	  module.hot.accept()
	  if (module.hot.data) {
	     __webpack_require__(51).rerender("data-v-cbbaed90", module.exports)
	  }
	}

/***/ },

/***/ 311:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(312)

	/* script */
	__vue_exports__ = __webpack_require__(313)

	/* template */
	var __vue_template__ = __webpack_require__(314)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	if (Object.keys(__vue_exports__).some(function (key) { return key !== "default" && key !== "__esModule" })) {console.error("named exports are not supported in *.vue files.")}
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\user-index\\follow.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (true) {(function () {
	  var hotAPI = __webpack_require__(51)
	  hotAPI.install(__webpack_require__(52), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-4af17848", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-4af17848", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] follow.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 312:
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },

/***/ 313:
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});

	var _vuex = __webpack_require__(49);

	exports.default = {
	    name: 'follow',
	    data: function data() {
	        return {
	            followClassification: {
	                'id': 0,
	                'name': '',
	                'user_id': 0
	            },
	            userPic: {
	                'name': '',
	                'pic': ''
	            },
	            userPics: [],
	            followClassifications: [],
	            newfollowclassification: '',
	            newClassification: {
	                'id': 0,
	                'name': ''
	            },
	            item: -1,
	            flag: false,
	            ok: true,
	            pb: {
	                userId: 0,
	                followClassificationId: 0
	            },
	            userMsg: {
	                'user_id': 0,
	                'name': '',
	                'introduction': '',
	                'sex': 0,
	                'pic': ''
	            },
	            AllFollowsByClassifications: []
	        };
	    },

	    computed: (0, _vuex.mapState)(['userMsg']),
	    mounted: function mounted() {
	        this.getfollowClassification();
	        this.getIndexUserMsg();
	    },

	    methods: {
	        getfollowClassification: function getfollowClassification() {
	            var _this = this;

	            this.$http.get(this.$homeUrl('getAllFollwClassification') + '/' + this.userMsg.user_id).then(function (response) {

	                _this.$set(_this, 'followClassifications', response.body);
	            }, function (response) {});
	        },
	        addClassificationName: function addClassificationName() {
	            var _this2 = this;

	            this.$http.post(this.$adminUrl('followClassification'), this.newClassification).then(function (response) {
	                _this2.newClassification.id = response.body;
	            }, function (response) {});
	            this.$alert("新建成功", "s");
	            window.location.reload();
	        },
	        delClassificationName: function delClassificationName(id) {
	            this.$http.delete(this.$adminUrl('followClassification') + '/' + id).then(function (response) {}, function (response) {});
	            this.$alert("删除关注类", "e");
	            window.location.reload();
	        },
	        Mouseover: function Mouseover(x) {
	            this.flag = true;
	            this.item = x;
	        },
	        Mouseout: function Mouseout() {
	            this.flag = false;
	            this.item = -1;
	        },
	        itempicture: function itempicture(x) {
	            this.pb.followClassificationId = x;
	            this.pb.userId = this.userMsg.user_id;
	            this.ok = false;
	            this.getAllFollowsByClassification();
	        },
	        getIndexUserMsg: function getIndexUserMsg() {
	            var _this3 = this;

	            this.$http.get(this.$adminUrl('getUserMsg')).then(function (response) {

	                _this3.$set(_this3, 'userMsg', response.body);
	            }, function (response) {

	                list.$alert("fail in getting data!", "e");
	            });
	        },
	        getAllFollowsByClassification: function getAllFollowsByClassification() {
	            var _this4 = this;

	            this.$http.get(this.$homeUrl('getAllFollowsByClassification'), { params: this.pb }).then(function (response) {
	                _this4.$set(_this4, 'AllFollowsByClassifications', response.body.data);
	            }, function (response) {});
	            this.$alert("fail in getting data!", "e");
	        },
	        delUser: function delUser(id) {
	            this.$http.delete(this.$adminUrl('follow') + '/' + id).then(function (response) {}, function (response) {});
	            this.$alert("取消关注", "s");
	            document.getElementById("box").innerHTML = "";
	        },
	        backing: function backing() {
	            this.ok = true;
	        }
	    }
	}; //
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//

/***/ },

/***/ 314:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [(_vm.ok) ? _vm._h('div', {
	    staticClass: "panel"
	  }, [_vm._h('div', {
	    attrs: {
	      "id": "item"
	    }
	  }, [_vm._l((_vm.followClassifications), function(list, index) {
	    return _vm._h('div', {
	      staticClass: "boxitem"
	    }, [_vm._h('a', {
	      on: {
	        "mouseout": _vm.Mouseout,
	        "mouseover": function($event) {
	          _vm.Mouseover(index)
	        }
	      }
	    }, [_vm._h('div', {
	      staticClass: "boxitem_img",
	      on: {
	        "click": function($event) {
	          _vm.itempicture(list.followClassification.id)
	        }
	      }
	    }, [_vm._l((list.userPics), function(userPic) {
	      return _vm._h('div', {
	        staticClass: "items"
	      }, [_vm._h('img', {
	        attrs: {
	          "src": _vm.$img(userPic.pic)
	        }
	      })])
	    }), " ", _vm._h('div', {
	      staticStyle: {
	        "clear": "both"
	      }
	    })]), " ", _vm._h('h4', [_vm._s(list.followClassification.name)])])])
	  })])]) : _vm._h('div', {
	    attrs: {
	      "id": "user"
	    }
	  }, [_vm._h('button', {
	    staticClass: "btn btn-info ",
	    on: {
	      "click": _vm.backing
	    }
	  }, ["返回"]), " ", _vm._l((_vm.AllFollowsByClassifications), function(list, index) {
	    return _vm._h('div', {
	      staticClass: "user_item"
	    }, [_vm._h('h2', [_vm._h('span', {
	      staticClass: "glyphicon glyphicon-user"
	    }), _vm._s(list.followed_name)])])
	  })])])
	},staticRenderFns: []}
	if (true) {
	  module.hot.accept()
	  if (module.hot.data) {
	     __webpack_require__(51).rerender("data-v-4af17848", module.exports)
	  }
	}

/***/ },

/***/ 333:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(334)

	/* script */
	__vue_exports__ = __webpack_require__(335)

	/* template */
	var __vue_template__ = __webpack_require__(336)
	__vue_options__ = __vue_exports__ = __vue_exports__ || {}
	if (
	  typeof __vue_exports__.default === "object" ||
	  typeof __vue_exports__.default === "function"
	) {
	if (Object.keys(__vue_exports__).some(function (key) { return key !== "default" && key !== "__esModule" })) {console.error("named exports are not supported in *.vue files.")}
	__vue_options__ = __vue_exports__ = __vue_exports__.default
	}
	if (typeof __vue_options__ === "function") {
	  __vue_options__ = __vue_options__.options
	}
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\user-manage\\follow.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (true) {(function () {
	  var hotAPI = __webpack_require__(51)
	  hotAPI.install(__webpack_require__(52), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-5b1aacf7", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-5b1aacf7", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] follow.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 334:
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },

/***/ 335:
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});

	var _userFollow = __webpack_require__(275);

	var _userFollow2 = _interopRequireDefault(_userFollow);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	exports.default = {
	    name: 'follow',
	    components: {
	        userFollow: _userFollow2.default
	    },
	    data: function data() {
	        return {
	            followClassification: {
	                'id': 0,
	                'name': '',
	                'user_id': 0
	            },
	            userPic: {
	                'name': '',
	                'pic': ''
	            },
	            userPics: [],
	            followClassifications: [],
	            newfollowclassification: '',
	            newClassification: {
	                'id': 0,
	                'name': ''
	            },
	            item: -1,
	            flag: false,
	            ok: true,
	            pb: {
	                userId: 0,
	                followClassificationId: 0
	            },
	            userMsg: {
	                'user_id': 0,
	                'name': '',
	                'introduction': '',
	                'sex': 0,
	                'pic': ''
	            },
	            AllFollowsByClassifications: []
	        };
	    },
	    mounted: function mounted() {
	        this.getfollowClassification();
	        this.getIndexUserMsg();
	    },

	    methods: {
	        getfollowClassification: function getfollowClassification() {
	            var _this = this;

	            this.$http.get(this.$adminUrl('followClassification')).then(function (response) {

	                _this.$set(_this, 'followClassifications', response.body);
	            }, function (response) {});
	        },
	        addClassificationName: function addClassificationName() {
	            var _this2 = this;

	            this.$http.post(this.$adminUrl('followClassification'), this.newClassification).then(function (response) {
	                _this2.newClassification.id = response.body;
	                _this2.getfollowClassification();
	                _this2.followClassifications.push(_this2.followClassification);
	                _this2.$alert("新建成功", "s");
	                _this2.newClassification.name = "";
	            }, function (response) {});
	        },
	        delClassificationName: function delClassificationName(id, index) {
	            var _this3 = this;

	            this.$http.delete(this.$adminUrl('followClassification') + '/' + id).then(function (response) {
	                _this3.$alert("取消关注", "e");

	                _this3.followClassifications.splice(index, 1);
	            }, function (response) {});
	        },
	        Mouseover: function Mouseover(x) {
	            this.flag = true;
	            this.item = x;
	        },
	        Mouseout: function Mouseout() {
	            this.flag = false;
	            this.item = -1;
	        },
	        itempicture: function itempicture(x) {
	            this.pb.followClassificationId = x;
	            this.pb.userId = this.userMsg.user_id;
	            this.ok = false;
	            this.getAllFollowsByClassification();
	        },
	        getIndexUserMsg: function getIndexUserMsg() {
	            var _this4 = this;

	            this.$http.get(this.$adminUrl('getUserMsg')).then(function (response) {

	                _this4.$set(_this4, 'userMsg', response.body);
	            }, function (response) {});
	        },
	        getAllFollowsByClassification: function getAllFollowsByClassification() {
	            var _this5 = this;

	            this.$http.get(this.$homeUrl('getAllFollowsByClassification'), { params: this.pb }).then(function (response) {
	                _this5.$set(_this5, 'AllFollowsByClassifications', response.body.data);
	            }, function (response) {});
	        },
	        delUser: function delUser(id) {
	            var _this6 = this;

	            this.$http.delete(this.$adminUrl('follow') + '/' + id).then(function (response) {
	                _this6.getAllFollowsByClassification();
	            }, function (response) {});
	            this.$alert("取消关注", "s");
	            document.getElementById("box").innerHTML = "";
	        },
	        backing: function backing() {
	            this.ok = true;
	        }
	    }
	}; //
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//

/***/ },

/***/ 336:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [(_vm.ok) ? _vm._h('div', {
	    staticClass: "followPanel"
	  }, [_vm._h('div', {
	    staticClass: "form-group addItemBox"
	  }, [_vm._h('p', {
	    staticClass: "form-inline"
	  }, [_vm._h('input', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.newClassification.name),
	      expression: "newClassification.name"
	    }],
	    staticClass: "form-control",
	    attrs: {
	      "type": "text",
	      "name": "classificationName"
	    },
	    domProps: {
	      "value": _vm._s(_vm.newClassification.name)
	    },
	    on: {
	      "input": function($event) {
	        if ($event.target.composing) { return; }
	        _vm.newClassification.name = $event.target.value
	      }
	    }
	  }), " ", _vm._h('button', {
	    staticClass: "btn btn-info",
	    on: {
	      "click": _vm.addClassificationName
	    }
	  }, ["新增"])])]), " ", _vm._h('div', {
	    attrs: {
	      "id": "item"
	    }
	  }, [_vm._l((_vm.followClassifications), function(list, index) {
	    return _vm._h('div', {
	      staticClass: "boxitem"
	    }, [_vm._h('a', {
	      on: {
	        "mouseout": _vm.Mouseout,
	        "mouseover": function($event) {
	          _vm.Mouseover(index)
	        }
	      }
	    }, [_vm._h('div', {
	      staticClass: "boxitem_img",
	      on: {
	        "click": function($event) {
	          _vm.itempicture(list.followClassification.id)
	        }
	      }
	    }, [_vm._l((list.userPics), function(userPic) {
	      return _vm._h('div', {
	        staticClass: "items"
	      }, [_vm._h('img', {
	        attrs: {
	          "src": _vm.$img(userPic.pic)
	        }
	      })])
	    }), " ", _vm._h('div', {
	      staticStyle: {
	        "clear": "both"
	      }
	    })]), " ", _vm._h('h4', [_vm._s(list.followClassification.name)]), " ", _vm._h('p', {
	      directives: [{
	        name: "show",
	        rawName: "v-show",
	        value: (_vm.flag && index == _vm.item && index != 0),
	        expression: "flag && index == item && index!=0"
	      }],
	      staticStyle: {
	        "text-align": "right",
	        "margin-right": "10px"
	      },
	      on: {
	        "click": function($event) {
	          _vm.delClassificationName(list.followClassification.id, index)
	        }
	      }
	    }, ["取消收藏"])])])
	  })])]) : _vm._h('div', {
	    attrs: {
	      "id": "user"
	    }
	  }, [_vm._h('button', {
	    staticClass: "btn btn-info",
	    on: {
	      "click": _vm.backing
	    }
	  }, ["返回"]), " ", _vm._l((_vm.AllFollowsByClassifications), function(list, index) {
	    return _vm._h('div', {
	      staticClass: "user_item"
	    }, [_vm._h('p', [_vm._h('span', {
	      staticClass: "glyphicon glyphicon-user"
	    }), _vm._s(list.followed_name)]), " ", _vm._h('button', {
	      staticClass: "btn btn-default cancelFollowBtn",
	      attrs: {
	        "type": "button"
	      },
	      on: {
	        "click": function($event) {
	          _vm.delUser(list.followed_id)
	        }
	      }
	    }, ["取消关注"])])
	  })])])
	},staticRenderFns: []}
	if (true) {
	  module.hot.accept()
	  if (module.hot.data) {
	     __webpack_require__(51).rerender("data-v-5b1aacf7", module.exports)
	  }
	}

/***/ }

});