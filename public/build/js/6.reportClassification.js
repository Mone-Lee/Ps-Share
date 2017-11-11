webpackJsonp([6],{

/***/ 138:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(139)

	/* script */
	__vue_exports__ = __webpack_require__(140)

	/* template */
	var __vue_template__ = __webpack_require__(141)
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
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\admin-manage\\report-classification.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (true) {(function () {
	  var hotAPI = __webpack_require__(51)
	  hotAPI.install(__webpack_require__(52), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-7b318f97", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-7b318f97", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] report-classification.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 139:
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },

/***/ 140:
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
	//

	exports.default = {
	    name: 'ReportClassification',
	    mounted: function mounted() {
	        this.getReportClassifications();
	    },
	    data: function data() {
	        return {
	            TmpReportClassification: {
	                id: 0,
	                name: ''
	            },
	            ReportClassification: {
	                id: 0,
	                name: ''
	            },
	            ReportClassifications: [],
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
	         *  获取所有举报分类
	         */
	        getReportClassifications: function getReportClassifications() {
	            var _this = this;

	            this.$http.get(this.$homeUrl('getAllReports')).then(function (response) {

	                _this.$set(_this, 'ReportClassifications', response.body);
	            }, function (response) {

	                _this.$alert('连接错误', 'e');
	            });
	        },


	        /**
	         *  新增举报分类
	         */
	        addReportClassification: function addReportClassification() {
	            var _this2 = this;

	            this.$http.post(this.$adminUrl('reportclassification'), this.ReportClassification).then(function (response) {

	                if (response.body != 'false') {

	                    _this2.ReportClassification.id = response.body;
	                    _this2.ReportClassifications.push(_this2.ReportClassification);
	                    _this2.ReportClassification = { id: 0, name: '' };
	                    _this2.$alert('新增成功', 's');
	                } else {

	                    _this2.$alert('新增失败', 'e');
	                }
	            }, function (response) {

	                if (response.body.name[0] == 'The name field is required.') {
	                    _this2.$alert('分类名必填', 'e');
	                } else if (response.body.name[0] == 'The name has already been taken.') {
	                    _this2.$alert('分类名重复', 'e');
	                } else if (response.body.name[0] == 'The name may not be greater than 20 characters.') {
	                    _this2.$alert('长度小于20', 'e');
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
	                this.deleteReportClassification(this.deleteTmp.index, this.deleteTmp.id);
	            } else {
	                this.batchDelete();
	            }
	        },


	        /**
	         *  删除单个举报分类
	         */
	        deleteReportClassification: function deleteReportClassification(index, id) {
	            var _this3 = this;

	            this.$http.delete(this.$adminUrl('reportclassification/') + id).then(function (response) {

	                if (response.body == 'true') {
	                    _this3.ReportClassifications.splice(index, 1);
	                    _this3.show = false;
	                    _this3.$alert('删除成功');
	                } else if (response.body == "can't delete!") {
	                    _this3.show = false;
	                    _this3.$alert('删除失败', 'e');
	                } else {
	                    _this3.show = false;
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

	            this.$http.delete(this.$adminUrl('reportclassification/batch-delete'), { params: this.checkIds }).then(function (response) {

	                _this4.$set(_this4, 'ReportClassifications', response.body.reportClassfications);
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
	        editName: function editName(ReportClassification) {
	            this.edit = true;
	            this.ReportClassification = ReportClassification;
	            this.TmpReportClassification.id = ReportClassification.id;
	            this.TmpReportClassification.name = ReportClassification.name;
	        },


	        /**
	         *  保存编辑的分享分类的名称
	         */
	        SaveReportClassification: function SaveReportClassification() {
	            var _this5 = this;

	            this.$http.put(this.$adminUrl('reportclassification/') + this.ReportClassification.id, this.ReportClassification).then(function (response) {

	                if (response.body == 'true') {
	                    _this5.edit = false;
	                    _this5.ReportClassification = { id: 0, name: '' };
	                    _this5.$alert('修改成功', 's');
	                } else if (response.body == "the name already exist") {
	                    _this5.$alert('名字重复', 'e');
	                } else if (response.body == 'nothing change') {} else {
	                    _this5.$alert('修改失败', 'e');
	                }
	            }, function (response) {
	                if (response.body.name[0] == 'The name field is required.') {
	                    _this5.$alert('分类名必填', 'e');
	                } else if (response.body.name[0] == 'The name may not be greater than 20 characters.') {
	                    _this5.$alert('长度小于20', 'e');
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
	            this.ReportClassification.id = this.TmpReportClassification.id;
	            this.ReportClassification.name = this.TmpReportClassification.name;
	            this.TmpReportClassification = { id: 0, name: '' };
	            this.ReportClassification = { id: 0, name: '' };
	        }
	    }
	};

/***/ },

/***/ 141:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [_vm._h('div', {
	    staticClass: "addReportClassification"
	  }, [_vm._h('label', {
	    attrs: {
	      "for": "SCname"
	    }
	  }, ["举报分类名："]), _vm._h('input', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.ReportClassification.name),
	      expression: "ReportClassification.name"
	    }],
	    attrs: {
	      "id": "SCname",
	      "type": "text"
	    },
	    domProps: {
	      "value": _vm._s(_vm.ReportClassification.name)
	    },
	    on: {
	      "input": function($event) {
	        if ($event.target.composing) { return; }
	        _vm.ReportClassification.name = $event.target.value
	      }
	    }
	  }), " ", (!_vm.edit) ? _vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.addReportClassification
	    }
	  }, ["新增"]) : [_vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.SaveReportClassification
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
	  }, [_vm._m(0), " ", _vm._l((_vm.ReportClassifications), function(ReportClassification, index) {
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
	        "value": ReportClassification.id,
	        "checked": Array.isArray(_vm.checkIds) ? _vm._i(_vm.checkIds, ReportClassification.id) > -1 : _vm._q(_vm.checkIds, true)
	      },
	      on: {
	        "change": function($event) {
	          var $$a = _vm.checkIds,
	            $$el = $event.target,
	            $$c = $$el.checked ? (true) : (false);
	          if (Array.isArray($$a)) {
	            var $$v = ReportClassification.id,
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
	          _vm.editName(ReportClassification)
	        }
	      }
	    }, ["\n                    " + _vm._s(ReportClassification.name) + "\n                "]), " ", _vm._h('td', {
	      staticClass: "operate"
	    }, [_vm._h('button', {
	      attrs: {
	        "type": "button"
	      },
	      on: {
	        "click": function($event) {
	          _vm.showConfirm(0, index, ReportClassification.id)
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
	if (true) {
	  module.hot.accept()
	  if (module.hot.data) {
	     __webpack_require__(51).rerender("data-v-7b318f97", module.exports)
	  }
	}

/***/ }

});