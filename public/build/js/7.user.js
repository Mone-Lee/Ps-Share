webpackJsonp([7],{

/***/ 142:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(143)

	/* script */
	__vue_exports__ = __webpack_require__(144)

	/* template */
	var __vue_template__ = __webpack_require__(149)
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
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\admin-manage\\user.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (true) {(function () {
	  var hotAPI = __webpack_require__(51)
	  hotAPI.install(__webpack_require__(52), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-d07c43fa", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-d07c43fa", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] user.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 143:
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },

/***/ 144:
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});

	var _getIterator2 = __webpack_require__(88);

	var _getIterator3 = _interopRequireDefault(_getIterator2);

	var _roleDialog = __webpack_require__(145);

	var _roleDialog2 = _interopRequireDefault(_roleDialog);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	exports.default = {
	    name: 'User',
	    data: function data() {
	        return {
	            users: [],
	            user: {},
	            search: {
	                'active': 0,
	                'param': ''
	            },
	            checkIds: [],
	            showRoleDialog: false,
	            userId: 0,
	            total: 0
	        };
	    },
	    mounted: function mounted() {
	        this.getAllUser();
	    },

	    components: {
	        RoleDialog: _roleDialog2.default
	    },
	    methods: {

	        /**
	        * 获取所有用户
	        */
	        getAllUser: function getAllUser() {
	            var _this = this;

	            this.$http.get(this.$adminUrl('getAllUser')).then(function (response) {
	                _this.$set(_this, 'users', response.body.data);
	                _this.total = response.body.last_page;
	            }, function (response) {});
	        },


	        /**
	        * 搜索
	        */
	        searchUser: function searchUser() {
	            var _this2 = this;

	            this.$http.get(this.$adminUrl('getAllUser'), { params: this.search }).then(function (response) {
	                _this2.$set(_this2, 'users', response.body.data);
	            }, function (response) {});
	        },


	        /**
	        * 冻结或解冻
	        */
	        triggleUser: function triggleUser(user) {
	            this.$http.get(this.$adminUrl('triggleUser') + '/' + user.id).then(function (response) {
	                if (response.body == 'true') {
	                    if (user.active == 0) {
	                        user.active = 1;
	                    } else {
	                        user.active = 0;
	                    }
	                }
	            }, function (response) {});
	        },


	        /**
	        * 批量冻结
	        */
	        batchLock: function batchLock() {
	            var _this3 = this;

	            this.$http.get(this.$adminUrl('batchLock'), { params: this.checkIds }).then(function (response) {
	                if (response.body != 0) {
	                    var _iteratorNormalCompletion = true;
	                    var _didIteratorError = false;
	                    var _iteratorError = undefined;

	                    try {
	                        for (var _iterator = (0, _getIterator3.default)(_this3.users), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
	                            var user = _step.value;

	                            if (_this3.checkIds.indexOf(user.id) != -1) {
	                                user.active = 1;
	                            }
	                        }
	                    } catch (err) {
	                        _didIteratorError = true;
	                        _iteratorError = err;
	                    } finally {
	                        try {
	                            if (!_iteratorNormalCompletion && _iterator.return) {
	                                _iterator.return();
	                            }
	                        } finally {
	                            if (_didIteratorError) {
	                                throw _iteratorError;
	                            }
	                        }
	                    }
	                }
	                _this3.checkIds = [];
	            }, function (response) {});
	        },


	        /**
	        * 批量解冻
	        */
	        batchUnlock: function batchUnlock() {
	            var _this4 = this;

	            this.$http.get(this.$adminUrl('batchUnlock'), { params: this.checkIds }).then(function (response) {
	                if (response.body != 0) {
	                    var _iteratorNormalCompletion2 = true;
	                    var _didIteratorError2 = false;
	                    var _iteratorError2 = undefined;

	                    try {
	                        for (var _iterator2 = (0, _getIterator3.default)(_this4.users), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
	                            var user = _step2.value;

	                            if (_this4.checkIds.indexOf(user.id) != -1) {
	                                user.active = 0;
	                            }
	                        }
	                    } catch (err) {
	                        _didIteratorError2 = true;
	                        _iteratorError2 = err;
	                    } finally {
	                        try {
	                            if (!_iteratorNormalCompletion2 && _iterator2.return) {
	                                _iterator2.return();
	                            }
	                        } finally {
	                            if (_didIteratorError2) {
	                                throw _iteratorError2;
	                            }
	                        }
	                    }
	                }
	                _this4.checkIds = [];
	            }, function (response) {});
	        },
	        showRole: function showRole(id) {
	            this.showRoleDialog = true;
	            this.userId = id;
	        },
	        setAllUser: function setAllUser(users) {
	            this.$set(this, 'users', users.data);
	            this.total = users.last_page;
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

/***/ },

/***/ 145:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(146)

	/* script */
	__vue_exports__ = __webpack_require__(147)

	/* template */
	var __vue_template__ = __webpack_require__(148)
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
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\admin-manage\\role-dialog.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (true) {(function () {
	  var hotAPI = __webpack_require__(51)
	  hotAPI.install(__webpack_require__(52), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-25b6d077", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-25b6d077", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] role-dialog.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 146:
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },

/***/ 147:
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


	exports.default = {
	    name: 'RoleDialog',
	    props: {
	        userId: {
	            type: Number,
	            default: 0
	        }
	    },
	    data: function data() {
	        return {
	            roles: [],
	            checkIds: []
	        };
	    },
	    mounted: function mounted() {
	        this.getRoles();
	        this.getRoleIds();
	    },

	    methods: {
	        getRoles: function getRoles() {
	            var _this = this;

	            this.$http.get(this.$adminUrl('rbac/getAllRoles')).then(function (response) {
	                _this.$set(_this, 'roles', response.body);
	            }, function (response) {});
	        },
	        getRoleIds: function getRoleIds() {
	            var _this2 = this;

	            this.$http.get(this.$adminUrl('rbac/getUserRole/') + this.userId).then(function (response) {
	                _this2.$set(_this2, 'checkIds', response.body);
	            }, function (response) {});
	        },
	        save: function save() {
	            var _this3 = this;

	            this.$http.post(this.$adminUrl('rbac/userBindRole'), { userId: this.userId, roleIds: this.checkIds }).then(function (response) {
	                if (response.body == 'true') {
	                    _this3.cancel();
	                }
	            }, function (response) {});
	        },
	        cancel: function cancel() {
	            this.$emit('cancel');
	        }
	    }
	};

/***/ },

/***/ 148:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', {
	    staticClass: "role-dialog"
	  }, [_vm._h('div', {
	    staticClass: "role-list"
	  }, [_vm._h('ul', [_vm._l((_vm.roles), function(role, index) {
	    return _vm._h('li', [_vm._h('input', {
	      directives: [{
	        name: "model",
	        rawName: "v-model",
	        value: (_vm.checkIds),
	        expression: "checkIds"
	      }],
	      attrs: {
	        "type": "checkbox",
	        "id": role.id + '-' + role.name
	      },
	      domProps: {
	        "value": role.id,
	        "checked": Array.isArray(_vm.checkIds) ? _vm._i(_vm.checkIds, role.id) > -1 : _vm._q(_vm.checkIds, true)
	      },
	      on: {
	        "change": function($event) {
	          var $$a = _vm.checkIds,
	            $$el = $event.target,
	            $$c = $$el.checked ? (true) : (false);
	          if (Array.isArray($$a)) {
	            var $$v = role.id,
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
	    }), " ", _vm._h('label', {
	      attrs: {
	        "for": role.id + '-' + role.name,
	        "title": role.description
	      }
	    }, [_vm._s(role.display_name)])])
	  })])]), " ", _vm._h('div', {
	    staticClass: "div-btn"
	  }, [_vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.save
	    }
	  }, ["保存"]), " ", _vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.cancel
	    }
	  }, ["取消"])])])
	},staticRenderFns: []}
	if (true) {
	  module.hot.accept()
	  if (module.hot.data) {
	     __webpack_require__(51).rerender("data-v-25b6d077", module.exports)
	  }
	}

/***/ },

/***/ 149:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [_vm._h('div', [_vm._h('div', {
	    staticClass: "search-module"
	  }, [_vm._h('select', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.search.active),
	      expression: "search.active"
	    }],
	    on: {
	      "change": function($event) {
	        _vm.search.active = Array.prototype.filter.call($event.target.options, function(o) {
	          return o.selected
	        }).map(function(o) {
	          var val = "_value" in o ? o._value : o.value;
	          return val
	        })[0]
	      }
	    }
	  }, [_vm._h('option', {
	    attrs: {
	      "value": ""
	    }
	  }, ["全部"]), " ", _vm._h('option', {
	    attrs: {
	      "value": "0"
	    }
	  }, ["unlock"]), " ", _vm._h('option', {
	    attrs: {
	      "value": "1"
	    }
	  }, ["lock"])]), " ", _vm._h('input', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.search.param),
	      expression: "search.param"
	    }],
	    attrs: {
	      "type": "text",
	      "name": "param",
	      "placeholder": "搜索用户名"
	    },
	    domProps: {
	      "value": _vm._s(_vm.search.param)
	    },
	    on: {
	      "input": function($event) {
	        if ($event.target.composing) { return; }
	        _vm.search.param = $event.target.value
	      }
	    }
	  }), " ", _vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.searchUser
	    }
	  }, ["搜素"])])]), " ", _vm._h('table', {
	    staticClass: "user-list"
	  }, [_vm._m(0), " ", _vm._l((_vm.users), function(user, index) {
	    return _vm._h('tr', [_vm._h('td', [_vm._h('input', {
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
	        "value": user.id,
	        "checked": Array.isArray(_vm.checkIds) ? _vm._i(_vm.checkIds, user.id) > -1 : _vm._q(_vm.checkIds, true)
	      },
	      on: {
	        "change": function($event) {
	          var $$a = _vm.checkIds,
	            $$el = $event.target,
	            $$c = $$el.checked ? (true) : (false);
	          if (Array.isArray($$a)) {
	            var $$v = user.id,
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
	      attrs: {
	        "title": user.name
	      }
	    }, ["\n                " + _vm._s(user.name) + "\n            "]), " ", _vm._h('td', {
	      staticClass: "name",
	      attrs: {
	        "title": user.email
	      }
	    }, ["\n                " + _vm._s(user.email) + "\n            "]), " ", _vm._h('td', {
	      staticClass: "name"
	    }, [(user.active == 0) ? _vm._h('span', ["unlock"]) : _vm._h('span', ["lock"]), " "]), " ", _vm._h('td', {
	      staticClass: "name"
	    }, ["\n                " + _vm._s(_vm._f("timeFilter")(user.created_at)) + "\n            "]), " ", _vm._h('td', {
	      staticClass: "operate"
	    }, [(user.active == 0) ? _vm._h('button', {
	      attrs: {
	        "type": "button"
	      },
	      on: {
	        "click": function($event) {
	          _vm.triggleUser(user)
	        }
	      }
	    }, ["冻结"]) : _vm._h('button', {
	      attrs: {
	        "type": "button"
	      },
	      on: {
	        "click": function($event) {
	          _vm.triggleUser(user)
	        }
	      }
	    }, ["解冻"]), " ", " ", (this.isAdmin) ? _vm._h('button', {
	      staticClass: "role-btn",
	      attrs: {
	        "type": "button"
	      },
	      on: {
	        "click": function($event) {
	          _vm.showRole(user.id)
	        }
	      }
	    }, ["角色管理"]) : _vm._e()])])
	  })]), " ", _vm._h('div', {
	    staticClass: "batch"
	  }, [_vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.batchLock
	    }
	  }, ["批量冻结"]), " ", _vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.batchUnlock
	    }
	  }, ["批量解冻"])]), " ", _vm._h('paginator', {
	    attrs: {
	      "total": _vm.total,
	      "url": "getAllUser",
	      "paginatorParams": _vm.search
	    },
	    on: {
	      "result": _vm.setAllUser
	    }
	  }), " ", (_vm.showRoleDialog) ? _vm._h('role-dialog', {
	    attrs: {
	      "userId": _vm.userId
	    },
	    on: {
	      "cancel": function($event) {
	        _vm.showRoleDialog = false
	      }
	    }
	  }) : _vm._e()])
	},staticRenderFns: [function (){var _vm=this;
	  return _vm._h('tr', [_vm._h('th'), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["用户名"]), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["邮箱"]), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["状态"]), " ", _vm._h('th', {
	    staticClass: "name"
	  }, ["注册时间"]), " ", _vm._h('th', {
	    staticClass: "operate"
	  }, ["操作"])])
	}]}
	if (true) {
	  module.hot.accept()
	  if (module.hot.data) {
	     __webpack_require__(51).rerender("data-v-d07c43fa", module.exports)
	  }
	}

/***/ },

/***/ 221:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(222)

	/* script */
	__vue_exports__ = __webpack_require__(223)

	/* template */
	var __vue_template__ = __webpack_require__(224)
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
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\app\\User.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (true) {(function () {
	  var hotAPI = __webpack_require__(51)
	  hotAPI.install(__webpack_require__(52), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-1325fd12", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-1325fd12", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] User.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 222:
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },

/***/ 223:
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

	exports.default = {
	    name: 'User'

	};

/***/ },

/***/ 224:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [_vm._h('div', [_vm._s(_vm.$route.params.id)]), " ", _vm._h('router-view', [_vm._h('router-view')])])
	},staticRenderFns: []}
	if (true) {
	  module.hot.accept()
	  if (module.hot.data) {
	     __webpack_require__(51).rerender("data-v-1325fd12", module.exports)
	  }
	}

/***/ }

});