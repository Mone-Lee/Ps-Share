webpackJsonp([2],{

/***/ 113:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(114)

	/* script */
	__vue_exports__ = __webpack_require__(116)

	/* template */
	var __vue_template__ = __webpack_require__(117)
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
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\admin-manage\\keyword.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (false) {(function () {
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-001dfa3e", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-001dfa3e", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] keyword.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 114:
/***/ function(module, exports, __webpack_require__) {

	// style-loader: Adds some css to the DOM by adding a <style> tag

	// load the styles
	var content = __webpack_require__(115);
	if(typeof content === 'string') content = [[module.id, content, '']];
	// add the styles to the DOM
	var update = __webpack_require__(5)(content, {});
	if(content.locals) module.exports = content.locals;
	// Hot Module Replacement
	if(false) {
		// When the styles change, update the <style> tags
		if(!content.locals) {
			module.hot.accept("!!./../../../../../node_modules/css-loader/index.js!./../../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-001dfa3e!./../../../../../node_modules/sass-loader/index.js!./../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./keyword.vue", function() {
				var newContent = require("!!./../../../../../node_modules/css-loader/index.js!./../../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-001dfa3e!./../../../../../node_modules/sass-loader/index.js!./../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./keyword.vue");
				if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
				update(newContent);
			});
		}
		// When the module is disposed, remove the <style> tags
		module.hot.dispose(function() { update(); });
	}

/***/ },

/***/ 115:
/***/ function(module, exports, __webpack_require__) {

	exports = module.exports = __webpack_require__(4)();
	// imports


	// module
	exports.push([module.id, "/**\r\n * $px can has unit or hasn't\r\n*/\n.addKeyword {\n  width: 31.25rem;\n  margin: 0 auto;\n  padding: 10px 0;\n  text-align: center;\n}\n.addKeyword input {\n    width: 12.125rem;\n    height: 1.5625rem;\n    padding-left: 0.375rem;\n}\n.addKeyword button {\n    padding: 0 0.8125rem;\n    height: 1.8125rem;\n    background-color: white;\n    border: 1px solid #9E9E9E;\n    cursor: pointer;\n}\n.addKeyword .cancel {\n    background-color: #9E9E9E;\n    color: white;\n}\n.keyword-list {\n  width: 31.25rem;\n  margin: 1.25rem auto;\n  text-align: center;\n}\n.keyword-list tr:nth-child(odd) {\n    background-color: #f1f1f1;\n}\n.keyword-list tr .name {\n    padding: 0.4375rem 0;\n    cursor: pointer;\n}\n.keyword-list tr button {\n    width: 3.625rem;\n    height: 1.625rem;\n    background-color: white;\n    border: 1px solid #f1f1f1;\n    cursor: pointer;\n}\n.batch-delete {\n  width: 31.25rem;\n  margin: 0 auto;\n}\n.batch-delete button {\n    height: 1.8125rem;\n    padding: 0 1.0625rem;\n    background-color: white;\n    border: 1px solid #9E9E9E;\n    cursor: pointer;\n}\n", ""]);

	// exports


/***/ },

/***/ 116:
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
	//
	//
	//

	exports.default = {
	    name: 'Keyword',
	    mounted: function mounted() {
	        this.getKeywords();
	    },
	    data: function data() {
	        return {
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
	            }
	        };
	    },

	    methods: {
	        /**
	         *  获取所有关键字
	         */
	        getKeywords: function getKeywords() {
	            var _this = this;

	            this.$http.get(this.$adminUrl('keyword')).then(function (response) {

	                _this.$set(_this, 'Keywords', response.body);
	            }, function (response) {

	                _this.$alert('连接错误', 'e');
	            });
	        },


	        /**
	         *  新增关键字
	         */
	        addKeyword: function addKeyword() {
	            var _this2 = this;

	            this.$http.post(this.$adminUrl('keyword'), this.Keyword).then(function (response) {

	                if (response.body != 'false') {

	                    _this2.Keyword.id = response.body;
	                    _this2.Keywords.push(_this2.Keyword);
	                    _this2.Keyword = { id: 0, name: '' };
	                    _this2.$alert('新增成功', 's');
	                } else {

	                    _this2.$alert('新增失败', 'e');
	                }
	            }, function (response) {

	                if (response.body.name[0] == 'The name field is required.') {
	                    _this2.$alert('关键字必填', 'e');
	                } else if (response.body.name[0] == 'The name has already been taken.') {
	                    _this2.$alert('关键字重复', 'e');
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
	                this.deleteKeyword(this.deleteTmp.index, this.deleteTmp.id);
	            } else {
	                this.batchDelete();
	            }
	        },


	        /**
	         *  删除单个关键字
	         */
	        deleteKeyword: function deleteKeyword(index, id) {
	            var _this3 = this;

	            this.$http.delete(this.$adminUrl('keyword/') + id).then(function (response) {

	                if (response.body == 'true') {
	                    _this3.Keywords.splice(index, 1);
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
	         *  批量删除分关键字
	         */
	        batchDelete: function batchDelete() {
	            var _this4 = this;

	            this.$http.delete(this.$adminUrl('keyword/batch-delete'), { params: this.checkIds }).then(function (response) {

	                _this4.$set(_this4, 'Keywords', response.body.keywords);
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
	        editName: function editName(Keyword) {
	            this.edit = true;
	            this.Keyword = Keyword;
	            this.TmpKeyword.id = Keyword.id;
	            this.TmpKeyword.name = Keyword.name;
	        },


	        /**
	         *  保存编辑的关键字的名称
	         */
	        SaveKeyword: function SaveKeyword() {
	            var _this5 = this;

	            this.$http.put(this.$adminUrl('keyword/') + this.Keyword.id, this.Keyword).then(function (response) {

	                if (response.body == 'true') {
	                    _this5.edit = false;
	                    _this5.Keyword = { id: 0, name: '' };
	                    _this5.$alert('修改成功', 's');
	                } else if (response.body == "the name already exist") {
	                    _this5.$alert('名字重复', 'e');
	                } else if (response.body == 'nothing change') {} else {
	                    _this5.$alert('修改失败', 'e');
	                }
	            }, function (response) {
	                if (response.body.name[0] == 'The name field is required.') {
	                    _this5.$alert('关键字必填', 'e');
	                } else if (response.body.name[0] == 'The name may not be greater than 10 characters.') {
	                    _this5.$alert('长度小于10', 'e');
	                } else {
	                    _this5.$alert('连接错误', 'e');
	                }
	            });
	        },


	        /**
	         *  取消关键字的编辑
	         */
	        cancelEdit: function cancelEdit() {
	            this.edit = false;
	            this.Keyword.id = this.TmpKeyword.id;
	            this.Keyword.name = this.TmpKeyword.name;
	            this.TmpKeyword = { id: 0, name: '' };
	            this.Keyword = { id: 0, name: '' };
	        }
	    }
	};

/***/ },

/***/ 117:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [_vm._h('div', {
	    staticClass: "addKeyword"
	  }, [_vm._h('label', {
	    attrs: {
	      "for": "KWname"
	    }
	  }, ["关键字："]), _vm._h('input', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.Keyword.name),
	      expression: "Keyword.name"
	    }],
	    attrs: {
	      "id": "KWname",
	      "type": "text"
	    },
	    domProps: {
	      "value": _vm._s(_vm.Keyword.name)
	    },
	    on: {
	      "input": function($event) {
	        if ($event.target.composing) { return; }
	        _vm.Keyword.name = $event.target.value
	      }
	    }
	  }), " ", (!_vm.edit) ? _vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.addKeyword
	    }
	  }, ["新增"]) : [_vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.SaveKeyword
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
	    staticClass: "keyword-list"
	  }, [_vm._m(0), " ", _vm._l((_vm.Keywords), function(Keyword, index) {
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
	        "value": Keyword.id,
	        "checked": Array.isArray(_vm.checkIds) ? _vm._i(_vm.checkIds, Keyword.id) > -1 : _vm._q(_vm.checkIds, true)
	      },
	      on: {
	        "change": function($event) {
	          var $$a = _vm.checkIds,
	            $$el = $event.target,
	            $$c = $$el.checked ? (true) : (false);
	          if (Array.isArray($$a)) {
	            var $$v = Keyword.id,
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
	          _vm.editName(Keyword)
	        }
	      }
	    }, ["\n                    " + _vm._s(Keyword.name) + "\n                "]), " ", _vm._h('td', {
	      staticClass: "count"
	    }, ["\n                    " + _vm._s(Keyword.count) + "\n                "]), " ", _vm._h('td', {
	      staticClass: "operate"
	    }, [_vm._h('button', {
	      attrs: {
	        "type": "button"
	      },
	      on: {
	        "click": function($event) {
	          _vm.showConfirm(0, index, Keyword.id)
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
	  }, ["关键字"]), " ", _vm._h('th', {
	    staticClass: "count"
	  }, ["命中次数"]), " ", _vm._h('th', {
	    staticClass: "operate"
	  }, ["操作"])])
	}]}
	if (false) {
	  module.hot.accept()
	  if (module.hot.data) {
	     require("vue-hot-reload-api").rerender("data-v-001dfa3e", module.exports)
	  }
	}

/***/ }

});