webpackJsonp([1],{

/***/ 108:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(109)

	/* script */
	__vue_exports__ = __webpack_require__(111)

	/* template */
	var __vue_template__ = __webpack_require__(112)
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
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\admin-manage\\classification.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (false) {(function () {
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-4b83b89e", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-4b83b89e", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] classification.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 109:
/***/ function(module, exports, __webpack_require__) {

	// style-loader: Adds some css to the DOM by adding a <style> tag

	// load the styles
	var content = __webpack_require__(110);
	if(typeof content === 'string') content = [[module.id, content, '']];
	// add the styles to the DOM
	var update = __webpack_require__(5)(content, {});
	if(content.locals) module.exports = content.locals;
	// Hot Module Replacement
	if(false) {
		// When the styles change, update the <style> tags
		if(!content.locals) {
			module.hot.accept("!!./../../../../../node_modules/css-loader/index.js!./../../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-4b83b89e!./../../../../../node_modules/sass-loader/index.js!./../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./classification.vue", function() {
				var newContent = require("!!./../../../../../node_modules/css-loader/index.js!./../../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-4b83b89e!./../../../../../node_modules/sass-loader/index.js!./../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./classification.vue");
				if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
				update(newContent);
			});
		}
		// When the module is disposed, remove the <style> tags
		module.hot.dispose(function() { update(); });
	}

/***/ },

/***/ 110:
/***/ function(module, exports, __webpack_require__) {

	exports = module.exports = __webpack_require__(4)();
	// imports


	// module
	exports.push([module.id, "/**\r\n * $px can has unit or hasn't\r\n*/\n.addShareClassification {\n  width: 31.25rem;\n  margin: 0 auto;\n  padding: 10px 0;\n  text-align: center;\n}\n.addShareClassification input {\n    width: 12.125rem;\n    height: 1.5625rem;\n    padding-left: 0.375rem;\n}\n.addShareClassification button {\n    padding: 0 0.8125rem;\n    height: 1.8125rem;\n    background-color: white;\n    border: 1px solid #9E9E9E;\n    cursor: pointer;\n}\n.addShareClassification .cancel {\n    background-color: #9E9E9E;\n    color: white;\n}\n.classification-list {\n  width: 31.25rem;\n  margin: 1.25rem auto;\n  text-align: center;\n}\n.classification-list tr:nth-child(odd) {\n    background-color: #f1f1f1;\n}\n.classification-list tr .name {\n    padding: 0.4375rem 0;\n    cursor: pointer;\n}\n.classification-list tr button {\n    width: 3.625rem;\n    height: 1.625rem;\n    background-color: white;\n    border: 1px solid #f1f1f1;\n    cursor: pointer;\n}\n.batch-delete {\n  width: 31.25rem;\n  margin: 0 auto;\n}\n.batch-delete button {\n    height: 1.8125rem;\n    padding: 0 1.0625rem;\n    background-color: white;\n    border: 1px solid #9E9E9E;\n    cursor: pointer;\n}\n", ""]);

	// exports


/***/ },

/***/ 111:
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
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
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
	    name: 'Classification',
	    mounted: function mounted() {
	        this.getShareClassifications();
	    },
	    data: function data() {
	        return {
	            TmpShareClassification: {
	                id: 0,
	                name: ''
	            },
	            ShareClassification: {
	                id: 0,
	                name: ''
	            },
	            ShareClassifications: [],
	            checkIds: [],
	            edit: false,
	            show: false,
	            type: 0,
	            deleteTmp: {
	                id: 0,
	                index: 0
	            }
	        };
	    },

	    methods: {
	        /**
	         *  获取所有分享分类
	         */
	        getShareClassifications: function getShareClassifications() {
	            var _this = this;

	            this.$http.get(this.$homeUrl('getAllClassification')).then(function (response) {

	                _this.$set(_this, 'ShareClassifications', response.body);
	            }, function (response) {

	                _this.$alert('连接错误', 'e');
	            });
	        },


	        /**
	         *  新增分享分类
	         */
	        addShareClassification: function addShareClassification() {
	            var _this2 = this;

	            this.$http.post(this.$adminUrl('shareclassification'), this.ShareClassification).then(function (response) {

	                if (response.body != 'false') {

	                    _this2.ShareClassification.id = response.body;
	                    _this2.ShareClassifications.push(_this2.ShareClassification);
	                    _this2.ShareClassification = { id: 0, name: '' };
	                    _this2.$alert('新增成功', 's');
	                } else {

	                    _this2.$alert('新增失败', 'e');
	                }
	            }, function (response) {

	                if (response.body.name[0] == 'The name field is required.') {
	                    _this2.$alert('分类名必填', 'e');
	                } else if (response.body.name[0] == 'The name has already been taken.') {
	                    _this2.$alert('分类名重复', 'e');
	                } else if (response.body.name[0] == 'The name may not be greater than 10 characters.') {
	                    _this2.$alert('长度小于10', 'e');
	                } else {
	                    _this2.$alert('连接错误', 'e');
	                }
	            });
	        },


	        /**
	         *  显示删除提示框
	         */
	        showConfirm: function showConfirm(type) {
	            var index = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
	            var id = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;

	            this.type = type;
	            if (type == 0) {
	                this.show = true;
	                this.deleteTmp.index = index;
	                this.deleteTmp.id = id;
	            } else {
	                if (this.checkIds.length == 0) {
	                    this.$alert('请选择');
	                } else {
	                    this.show = true;
	                }
	            }
	        },


	        /**
	         *  根据type判断是单个删除还是批量删除
	         */
	        oneOrBatchDelete: function oneOrBatchDelete() {
	            if (this.type == 0) {
	                this.deleteShareClassification(this.deleteTmp.index, this.deleteTmp.id);
	            } else {
	                this.batchDelete();
	            }
	        },


	        /**
	         *  删除单个分享分类
	         */
	        deleteShareClassification: function deleteShareClassification(index, id) {
	            var _this3 = this;

	            this.$http.delete(this.$adminUrl('shareclassification/') + id).then(function (response) {

	                if (response.body == 'true') {
	                    _this3.ShareClassifications.splice(index, 1);
	                    _this3.show = false;
	                    _this3.$alert('删除成功');
	                } else {
	                    _this3.$alert('删除失败', 'e');
	                }
	            }, function (response) {
	                _this3.$alert('连接错误', 'e');
	            });
	        },


	        /**
	         *  批量删除分享分类
	         */
	        batchDelete: function batchDelete() {
	            var _this4 = this;

	            this.$http.delete(this.$adminUrl('shareclassification/batch-delete'), { params: this.checkIds }).then(function (response) {

	                _this4.$set(_this4, 'ShareClassifications', response.body.shareClassifications);
	                _this4.checkIds = [];

	                _this4.show = false;
	                _this4.$alert('成功删除' + response.body.result + '条');
	            }, function (response) {
	                _this4.$alert('连接错误', 'e');
	            });
	        },


	        /**
	        *  填充编辑分享分类的id和名称
	        */
	        editName: function editName(ShareClassification) {
	            this.edit = true;
	            this.ShareClassification = ShareClassification;
	            this.TmpShareClassification.id = ShareClassification.id;
	            this.TmpShareClassification.name = ShareClassification.name;
	        },


	        /**
	         *  保存编辑的分享分类的名称
	         */
	        SaveShareClassification: function SaveShareClassification() {
	            var _this5 = this;

	            this.$http.put(this.$adminUrl('shareclassification/') + this.ShareClassification.id, this.ShareClassification).then(function (response) {

	                if (response.body == 'true') {
	                    _this5.edit = false;
	                    _this5.ShareClassification = { id: 0, name: '' };
	                    _this5.$alert('修改成功', 's');
	                } else if (response.body == "the name already exist") {
	                    _this5.$alert('名字重复', 'e');
	                } else if (response.body == 'nothing change') {} else {
	                    _this5.$alert('修改失败', 'e');
	                }
	            }, function (response) {
	                if (response.body.name[0] == 'The name field is required.') {
	                    _this5.$alert('分类名必填', 'e');
	                } else if (response.body.name[0] == 'The name may not be greater than 10 characters.') {
	                    _this5.$alert('长度小于10', 'e');
	                } else {
	                    _this5.$alert('连接错误', 'e');
	                }
	            });
	        },


	        /**
	         *  取消分享分类的编辑
	         */
	        cancelEdit: function cancelEdit() {
	            this.edit = false;
	            this.ShareClassification.id = this.TmpShareClassification.id;
	            this.ShareClassification.name = this.TmpShareClassification.name;
	            this.TmpShareClassification = { id: 0, name: '' };
	            this.ShareClassification = { id: 0, name: '' };
	        }
	    }
	};

/***/ },

/***/ 112:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [_vm._h('div', {
	    staticClass: "addShareClassification"
	  }, [_vm._h('label', {
	    attrs: {
	      "for": "SCname"
	    }
	  }, ["分享分类名："]), _vm._h('input', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.ShareClassification.name),
	      expression: "ShareClassification.name"
	    }],
	    attrs: {
	      "id": "SCname",
	      "type": "text"
	    },
	    domProps: {
	      "value": _vm._s(_vm.ShareClassification.name)
	    },
	    on: {
	      "input": function($event) {
	        if ($event.target.composing) { return; }
	        _vm.ShareClassification.name = $event.target.value
	      }
	    }
	  }), " ", (!_vm.edit) ? _vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.addShareClassification
	    }
	  }, ["新增"]) : [_vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.SaveShareClassification
	    }
	  }, ["保存修改"]), " ", _vm._h('button', {
	    staticClass: "cancel",
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.cancelEdit
	    }
	  }, ["取消"])], " "]), " ", _vm._h('table', {
	    staticClass: "classification-list"
	  }, [_vm._m(0), " ", _vm._l((_vm.ShareClassifications), function(ShareClassification, index) {
	    return [_vm._h('tr', [_vm._h('td', {
	      staticClass: "check"
	    }, [_vm._h('input', {
	      directives: [{
	        name: "model",
	        rawName: "v-model",
	        value: (_vm.checkIds),
	        expression: "checkIds"
	      }],
	      attrs: {
	        "type": "checkbox"
	      },
	      domProps: {
	        "value": ShareClassification.id,
	        "checked": Array.isArray(_vm.checkIds) ? _vm._i(_vm.checkIds, ShareClassification.id) > -1 : _vm._q(_vm.checkIds, true)
	      },
	      on: {
	        "change": function($event) {
	          var $$a = _vm.checkIds,
	            $$el = $event.target,
	            $$c = $$el.checked ? (true) : (false);
	          if (Array.isArray($$a)) {
	            var $$v = ShareClassification.id,
	              $$i = _vm._i($$a, $$v);
	            if ($$c) {
	              $$i < 0 && (_vm.checkIds = $$a.concat($$v))
	            } else {
	              $$i > -1 && (_vm.checkIds = $$a.slice(0, $$i).concat($$a.slice($$i + 1)))
	            }
	          } else {
	            _vm.checkIds = $$c
	          }
	        }
	      }
	    })]), " ", _vm._h('td', {
	      staticClass: "name",
	      on: {
	        "click": function($event) {
	          _vm.editName(ShareClassification)
	        }
	      }
	    }, ["\n                    " + _vm._s(ShareClassification.name) + "\n                "]), " ", _vm._h('td', {
	      staticClass: "operate"
	    }, [_vm._h('button', {
	      attrs: {
	        "type": "button"
	      },
	      on: {
	        "click": function($event) {
	          _vm.showConfirm(0, index, ShareClassification.id)
	        }
	      }
	    }, ["删除"])])])]
	  })]), " ", _vm._h('div', {
	    staticClass: "batch-delete"
	  }, [_vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": function($event) {
	        _vm.showConfirm(1)
	      }
	    }
	  }, ["批量删除"])]), " ", _vm._h('confirm', {
	    attrs: {
	      "show": _vm.show
	    },
	    on: {
	      "confirmAction": _vm.oneOrBatchDelete,
	      "cancelAction": function($event) {
	        _vm.show = false
	      }
	    }
	  })])
	},staticRenderFns: [function (){var _vm=this;
	  return _vm._h('tr', [_vm._h('th', {
	    staticClass: "check"
	  }), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["name"]), " ", _vm._h('th', {
	    staticClass: "operate"
	  }, ["操作"])])
	}]}
	if (false) {
	  module.hot.accept()
	  if (module.hot.data) {
	     require("vue-hot-reload-api").rerender("data-v-4b83b89e", module.exports)
	  }
	}

/***/ }

});