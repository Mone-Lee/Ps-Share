webpackJsonp([4],{

/***/ 130:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(131)

	/* script */
	__vue_exports__ = __webpack_require__(132)

	/* template */
	var __vue_template__ = __webpack_require__(133)
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
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\admin-manage\\report-share.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (true) {(function () {
	  var hotAPI = __webpack_require__(51)
	  hotAPI.install(__webpack_require__(52), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-057c3ebe", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-057c3ebe", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] report-share.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 131:
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },

/***/ 132:
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
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
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
	    name: 'ReportShare',
	    mounted: function mounted() {
	        this.getReports();
	    },
	    data: function data() {
	        return {
	            Report: {
	                id: 0,
	                name: ''
	            },
	            Reports: [],
	            checkIds: [],
	            show: false,
	            type: 0,
	            deleteTmp: {
	                id: 0,
	                reportId: 0,
	                shareId: 0
	            },
	            showMore: false,
	            MoreReports: [],
	            total: 0
	        };
	    },

	    methods: {
	        /**
	         *  获取所有分享分类
	         */
	        getReports: function getReports() {
	            var _this = this;

	            this.$http.get(this.$adminUrl('sharereport')).then(function (response) {

	                _this.$set(_this, 'Reports', response.body.data);
	                _this.total = response.body.last_page;
	            }, function (response) {

	                _this.$alert('连接错误', 'e');
	            });
	        },


	        /**
	         *  显示删除提示框
	         */
	        showConfirm: function showConfirm(type) {
	            var index = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
	            var reportId = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;
	            var shareId = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 0;

	            this.type = type;
	            if (type == 0) {
	                this.show = true;
	                this.deleteTmp.index = index;
	                this.deleteTmp.reportId = reportId;
	                this.deleteTmp.shareId = shareId;
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
	                this.deleteReport(this.deleteTmp.index, this.deleteTmp.reportId, this.deleteTmp.shareId);
	            } else {
	                this.batchDelete();
	            }
	        },


	        /**
	         *  删除单个分享分类
	         */
	        deleteReport: function deleteReport(index, reportId, shareId) {
	            var _this2 = this;

	            this.$http.delete(this.$adminUrl('sharereport/') + reportId, { params: { shareId: shareId } }).then(function (response) {

	                if (response.body == 'true') {
	                    _this2.Reports.splice(index, 1);
	                    _this2.show = false;
	                    _this2.$alert('删除成功');
	                } else {
	                    _this2.$alert('删除失败', 'e');
	                }
	            }, function (response) {
	                _this2.$alert('连接错误', 'e');
	            });
	        },


	        /**
	         *  批量删除分享分类
	         */
	        batchDelete: function batchDelete() {
	            var _this3 = this;

	            this.$http.delete(this.$adminUrl('sharereport/batch-delete'), { params: this.checkIds }).then(function (response) {

	                _this3.$set(_this3, 'Reports', response.body.reportClassfications);
	                _this3.checkIds = [];

	                _this3.show = false;
	                _this3.$alert('成功删除' + response.body.result + '条');
	            }, function (response) {
	                _this3.$alert('连接错误', 'e');
	            });
	        },
	        triggle: function triggle(report) {
	            this.$http.post(this.$adminUrl('sharereport/triggle'), { reportId: report.share_report_id, shareId: report.share_id }).then(function (response) {
	                if (response.body <= 1) {
	                    report.report_status = response.body;
	                }
	            }, function (response) {});
	        },
	        more: function more(id) {
	            var _this4 = this;

	            this.$http.get(this.$adminUrl('sharereport/') + id).then(function (response) {
	                _this4.$set(_this4, 'MoreReports', response.body.data);
	                _this4.showMore = true;
	            }, function (response) {});
	        },
	        back: function back() {
	            this.showMore = false;
	            this.MoreReports = [];
	        },
	        setShareReport: function setShareReport(ShareReport) {
	            this.$set(this, 'Reports', ShareReport.data);
	            this.total = ShareReport.last_page;
	        }
	    }
	};

/***/ },

/***/ 133:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [_vm._h('table', {
	    staticClass: "report-list"
	  }, [_vm._m(0), " ", _vm._l((_vm.Reports), function(Report, index) {
	    return [_vm._h('tr', [_vm._h('td', {
	      staticClass: "name",
	      attrs: {
	        "title": Report.share_abstract
	      }
	    }, ["\n                    " + _vm._s(Report.share_abstract) + "\n                "]), " ", _vm._h('td', {
	      staticClass: "name",
	      attrs: {
	        "title": Report.user_name
	      }
	    }, ["\n                    " + _vm._s(Report.user_name) + "\n                "]), " ", _vm._h('td', {
	      staticClass: "name",
	      attrs: {
	        "title": Report.usered_name
	      }
	    }, ["\n                    " + _vm._s(Report.usered_name) + "\n                "]), " ", _vm._h('td', {
	      staticClass: "name",
	      attrs: {
	        "title": Report.report_classification_name
	      }
	    }, ["\n                    " + _vm._s(Report.report_classification_name) + "\n                "]), " ", _vm._h('td', {
	      staticClass: "name",
	      attrs: {
	        "title": Report.report_content
	      }
	    }, ["\n                    " + _vm._s(Report.report_content) + "\n                "]), " ", _vm._h('td', {
	      staticClass: "name"
	    }, [(Report.report_status == 0) ? _vm._h('span', ["未处理"]) : _vm._h('span', ["屏蔽"]), " "]), " ", _vm._h('td', {
	      staticClass: "name"
	    }, ["\n                    " + _vm._s(Report.total) + "\n                "]), " ", _vm._h('td', {
	      staticClass: "operate"
	    }, [_vm._h('button', {
	      attrs: {
	        "type": "button"
	      },
	      on: {
	        "click": function($event) {
	          _vm.more(Report.share_id)
	        }
	      }
	    }, ["查看"]), " ", (Report.report_status == 0) ? _vm._h('button', {
	      attrs: {
	        "type": "button"
	      },
	      on: {
	        "click": function($event) {
	          _vm.triggle(Report)
	        }
	      }
	    }, ["屏蔽"]) : _vm._h('button', {
	      attrs: {
	        "type": "button"
	      },
	      on: {
	        "click": function($event) {
	          _vm.triggle(Report)
	        }
	      }
	    }, ["解除"]), " ", " ", _vm._h('button', {
	      attrs: {
	        "type": "button"
	      },
	      on: {
	        "click": function($event) {
	          _vm.showConfirm(0, index, Report.share_report_id, Report.share_id)
	        }
	      }
	    }, ["删除"])])])]
	  })]), " ", (_vm.showMore) ? _vm._h('div', {
	    staticClass: "report-dialog"
	  }, [_vm._h('table', {
	    staticClass: "report-list-dialog"
	  }, [_vm._m(1), " ", _vm._l((_vm.MoreReports), function(Report, index) {
	    return [_vm._h('tr', [_vm._h('td', {
	      staticClass: "name",
	      attrs: {
	        "title": Report.share_abstract
	      }
	    }, ["\n                        " + _vm._s(Report.share_abstract) + "\n                    "]), " ", _vm._h('td', {
	      staticClass: "name",
	      attrs: {
	        "title": Report.user_name
	      }
	    }, ["\n                        " + _vm._s(Report.user_name) + "\n                    "]), " ", _vm._h('td', {
	      staticClass: "name",
	      attrs: {
	        "title": Report.usered_name
	      }
	    }, ["\n                        " + _vm._s(Report.usered_name) + "\n                    "]), " ", _vm._h('td', {
	      staticClass: "name",
	      attrs: {
	        "title": Report.report_classification_name
	      }
	    }, ["\n                        " + _vm._s(Report.report_classification_name) + "\n                    "]), " ", _vm._h('td', {
	      staticClass: "name",
	      attrs: {
	        "title": Report.report_content
	      }
	    }, ["\n                        " + _vm._s(Report.report_content) + "\n                    "])])]
	  })]), " ", _vm._h('div', {
	    staticClass: "div-btn"
	  }, [_vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.back
	    }
	  }, ["返回"])])]) : _vm._e(), " ", _vm._h('paginator', {
	    attrs: {
	      "total": _vm.total,
	      "url": "sharereport"
	    },
	    on: {
	      "result": _vm.setShareReport
	    }
	  }), " ", _vm._h('confirm', {
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
	    staticClass: "name"
	  }, ["分享摘要"]), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["举报者"]), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["被举报者"]), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["举报分类"]), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["举报内容"]), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["举报状态"]), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["举报人数"]), " ", _vm._h('th', {
	    staticClass: "operate"
	  }, ["操作"])])
	},function (){var _vm=this;
	  return _vm._h('tr', [_vm._h('th', {
	    staticClass: "name"
	  }, ["分享摘要"]), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["举报者"]), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["被举报者"]), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["举报分类"]), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["举报内容"])])
	}]}
	if (true) {
	  module.hot.accept()
	  if (module.hot.data) {
	     __webpack_require__(51).rerender("data-v-057c3ebe", module.exports)
	  }
	}

/***/ }

});