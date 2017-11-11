webpackJsonp([4],{

/***/ 128:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(129)

	/* script */
	__vue_exports__ = __webpack_require__(131)

	/* template */
	var __vue_template__ = __webpack_require__(137)
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
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\admin-manage\\role.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (false) {(function () {
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-d07fb5a4", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-d07fb5a4", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] role.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 129:
/***/ function(module, exports, __webpack_require__) {

	// style-loader: Adds some css to the DOM by adding a <style> tag

	// load the styles
	var content = __webpack_require__(130);
	if(typeof content === 'string') content = [[module.id, content, '']];
	// add the styles to the DOM
	var update = __webpack_require__(5)(content, {});
	if(content.locals) module.exports = content.locals;
	// Hot Module Replacement
	if(false) {
		// When the styles change, update the <style> tags
		if(!content.locals) {
			module.hot.accept("!!./../../../../../node_modules/css-loader/index.js!./../../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-d07fb5a4!./../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./role.vue", function() {
				var newContent = require("!!./../../../../../node_modules/css-loader/index.js!./../../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-d07fb5a4!./../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./role.vue");
				if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
				update(newContent);
			});
		}
		// When the module is disposed, remove the <style> tags
		module.hot.dispose(function() { update(); });
	}

/***/ },

/***/ 130:
/***/ function(module, exports, __webpack_require__) {

	exports = module.exports = __webpack_require__(4)();
	// imports


	// module
	exports.push([module.id, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

	// exports


/***/ },

/***/ 131:
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});

	var _permission = __webpack_require__(132);

	var _permission2 = _interopRequireDefault(_permission);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	exports.default = {
	    name: 'Role',
	    data: function data() {
	        return {
	            roles: [],
	            edit: false,
	            checkIds: [],
	            roleId: 0,
	            show: false
	        };
	    },
	    mounted: function mounted() {
	        this.getRoles();
	    },

	    components: {
	        Permission: _permission2.default
	    },
	    methods: {
	        getRoles: function getRoles() {
	            var _this = this;

	            this.$http.get(this.$adminUrl('rbac')).then(function (response) {
	                _this.$set(_this, 'roles', response.body.data);
	            }, function (response) {});
	        },
	        addRole: function addRole(payload) {
	            var _this2 = this;

	            this.$http.post(this.$adminUrl('rbac'), payload).then(function (response) {
	                _this2.show = false;
	                _this2.roleId = 0;
	                _this2.getRoles();
	            }, function (response) {});
	        },
	        editRole: function editRole(id) {
	            this.roleId = id;
	            this.edit = true;
	            this.show = true;
	        },
	        deleteRole: function deleteRole(id) {
	            var _this3 = this;

	            this.$http.delete(this.$adminUrl('rbac/') + id).then(function (response) {
	                _this3.getRoles();
	            }, function (response) {});
	        },
	        showAdd: function showAdd() {
	            this.roleId = 0;
	            this.edit = false;
	            this.show = true;
	        },
	        updateRole: function updateRole() {
	            this.edit = false;
	            this.roleId = 0;
	            this.getRoles();
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

/***/ },

/***/ 132:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(133)

	/* script */
	__vue_exports__ = __webpack_require__(135)

	/* template */
	var __vue_template__ = __webpack_require__(136)
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
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\admin-manage\\permission.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (false) {(function () {
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-b0ac83f2", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-b0ac83f2", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] permission.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 133:
/***/ function(module, exports, __webpack_require__) {

	// style-loader: Adds some css to the DOM by adding a <style> tag

	// load the styles
	var content = __webpack_require__(134);
	if(typeof content === 'string') content = [[module.id, content, '']];
	// add the styles to the DOM
	var update = __webpack_require__(5)(content, {});
	if(content.locals) module.exports = content.locals;
	// Hot Module Replacement
	if(false) {
		// When the styles change, update the <style> tags
		if(!content.locals) {
			module.hot.accept("!!./../../../../../node_modules/css-loader/index.js!./../../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-b0ac83f2!./../../../../../node_modules/sass-loader/index.js!./../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./permission.vue", function() {
				var newContent = require("!!./../../../../../node_modules/css-loader/index.js!./../../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-b0ac83f2!./../../../../../node_modules/sass-loader/index.js!./../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./permission.vue");
				if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
				update(newContent);
			});
		}
		// When the module is disposed, remove the <style> tags
		module.hot.dispose(function() { update(); });
	}

/***/ },

/***/ 134:
/***/ function(module, exports, __webpack_require__) {

	exports = module.exports = __webpack_require__(4)();
	// imports


	// module
	exports.push([module.id, "/**\r\n * $px can has unit or hasn't\r\n*/\n.permission {\n  width: 37.5rem;\n}\n.permission .permission-item {\n    float: left;\n    width: 12.5rem;\n}\n", ""]);

	// exports


/***/ },

/***/ 135:
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

	exports.default = {
	    name: 'Permission',
	    props: {
	        edit: {
	            type: Boolean,
	            default: false
	        },
	        id: {
	            type: Number,
	            default: 0
	        }
	    },
	    data: function data() {
	        return {
	            role: {
	                id: 0,
	                name: '',
	                display_name: '',
	                description: '',
	                permissionIds: []
	            },
	            permissionList: []
	        };
	    },

	    computed: {
	        roleId: function roleId() {
	            this.editRole(this.id);
	            return this.id;
	        }
	    },
	    mounted: function mounted() {
	        console.log(this.role);
	        this.getPermissionByClassification();
	    },

	    methods: {
	        getPermissionByClassification: function getPermissionByClassification() {
	            var _this = this;

	            this.$http.get(this.$adminUrl('rbac/getPermissionByClassification')).then(function (response) {
	                _this.$set(_this, 'permissionList', response.body);
	            }, function (response) {});
	        },
	        addRole: function addRole() {
	            this.$emit('addRole', this.role);
	        },
	        updateRole: function updateRole() {
	            var _this2 = this;

	            this.$http.put(this.$adminUrl('rbac/') + this.roleId, this.role).then(function (response) {
	                _this2.$emit('saveSuccess');
	                _this2.$emit('cancel');
	            }, function (response) {});
	        },
	        editRole: function editRole(id) {
	            var _this3 = this;

	            if (id == 0) {
	                return;
	            }
	            this.$http.get(this.$adminUrl('rbac/') + id + '/edit').then(function (response) {
	                _this3.$set(_this3, 'role', response.body);
	            }, function (response) {});
	        },
	        cancel: function cancel() {
	            this.$emit('cancel');
	        }
	    }
	};

/***/ },

/***/ 136:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [_vm._h('div', [_vm._h('label', {
	    attrs: {
	      "for": "role_name"
	    }
	  }, ["角色名"]), " ", _vm._h('input', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.role.name),
	      expression: "role.name"
	    }],
	    attrs: {
	      "type": "text",
	      "id": "role_name"
	    },
	    domProps: {
	      "value": _vm._s(_vm.role.name)
	    },
	    on: {
	      "input": function($event) {
	        if ($event.target.composing) { return; }
	        _vm.role.name = $event.target.value
	      }
	    }
	  }), " ", _vm._h('label', {
	    attrs: {
	      "for": "role_display_name"
	    }
	  }, ["展示名字"]), " ", _vm._h('input', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.role.display_name),
	      expression: "role.display_name"
	    }],
	    attrs: {
	      "type": "text",
	      "id": "role_display_name"
	    },
	    domProps: {
	      "value": _vm._s(_vm.role.display_name)
	    },
	    on: {
	      "input": function($event) {
	        if ($event.target.composing) { return; }
	        _vm.role.display_name = $event.target.value
	      }
	    }
	  }), " ", _vm._h('label', {
	    attrs: {
	      "for": "role_description"
	    }
	  }, ["描述"]), " ", _vm._h('input', {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: (_vm.role.description),
	      expression: "role.description"
	    }],
	    attrs: {
	      "type": "text",
	      "id": "role_description"
	    },
	    domProps: {
	      "value": _vm._s(_vm.role.description)
	    },
	    on: {
	      "input": function($event) {
	        if ($event.target.composing) { return; }
	        _vm.role.description = $event.target.value
	      }
	    }
	  }), " ", (!_vm.edit) ? _vm._h('button', {
	    on: {
	      "click": _vm.addRole
	    }
	  }, ["新增角色"]) : _vm._h('button', {
	    on: {
	      "click": _vm.updateRole
	    }
	  }, ["保存修改"]), " ", " ", _vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.cancel
	    }
	  }, ["取消"])]), " ", _vm._h('div', {
	    staticClass: "permission"
	  }, [_vm._l((_vm.permissionList), function(permissionItem) {
	    return _vm._h('div', {
	      staticClass: "permission-item"
	    }, [_vm._h('h4', [_vm._s(permissionItem.permissionClassification)]), " ", _vm._l((permissionItem.permissions), function(permission) {
	      return _vm._h('p', [_vm._h('input', {
	        directives: [{
	          name: "model",
	          rawName: "v-model",
	          value: (_vm.role.permissionIds),
	          expression: "role.permissionIds"
	        }],
	        attrs: {
	          "type": "checkbox",
	          "id": permission.id + '-' + permission.name
	        },
	        domProps: {
	          "value": permission.id,
	          "checked": Array.isArray(_vm.role.permissionIds) ? _vm._i(_vm.role.permissionIds, permission.id) > -1 : _vm._q(_vm.role.permissionIds, true)
	        },
	        on: {
	          "change": function($event) {
	            var $$a = _vm.role.permissionIds,
	              $$el = $event.target,
	              $$c = $$el.checked ? (true) : (false);
	            if (Array.isArray($$a)) {
	              var $$v = permission.id,
	                $$i = _vm._i($$a, $$v);
	              if ($$c) {
	                $$i < 0 && (_vm.role.permissionIds = $$a.concat($$v))
	              } else {
	                $$i > -1 && (_vm.role.permissionIds = $$a.slice(0, $$i).concat($$a.slice($$i + 1)))
	              }
	            } else {
	              _vm.role.permissionIds = $$c
	            }
	          }
	        }
	      }), " ", _vm._h('label', {
	        attrs: {
	          "for": permission.id + '-' + permission.name
	        }
	      }, [_vm._s(permission.display_name)])])
	    })])
	  })]), " ", _vm._h('input', {
	    attrs: {
	      "type": "hidden"
	    },
	    domProps: {
	      "value": _vm.roleId
	    }
	  })])
	},staticRenderFns: []}
	if (false) {
	  module.hot.accept()
	  if (module.hot.data) {
	     require("vue-hot-reload-api").rerender("data-v-b0ac83f2", module.exports)
	  }
	}

/***/ },

/***/ 137:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [(_vm.show) ? _vm._h('permission', {
	    attrs: {
	      "edit": _vm.edit,
	      "id": _vm.roleId
	    },
	    on: {
	      "addRole": _vm.addRole,
	      "saveSuccess": _vm.updateRole,
	      "cancel": function($event) {
	        _vm.show = false
	      }
	    }
	  }) : _vm._e(), " ", _vm._h('div', [_vm._h('button', {
	    attrs: {
	      "type": "button"
	    },
	    on: {
	      "click": _vm.showAdd
	    }
	  }, ["新增"])]), " ", _vm._h('div'), " ", _vm._h('table', [_vm._m(0), " ", _vm._l((_vm.roles), function(role, index) {
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
	    })]), " ", _vm._h('td', ["\n                " + _vm._s(role.name) + "\n            "]), " ", _vm._h('td', ["\n                " + _vm._s(role.display_name) + "\n            "]), " ", _vm._h('td', ["\n                " + _vm._s(role.description) + "\n            "]), " ", _vm._h('td', ["\n                " + _vm._s(role.created_at) + "\n            "]), " ", _vm._h('td', [_vm._h('button', {
	      attrs: {
	        "type": "button"
	      },
	      on: {
	        "click": function($event) {
	          _vm.editRole(role.id)
	        }
	      }
	    }, ["编辑"]), " ", _vm._h('button', {
	      attrs: {
	        "type": "button"
	      },
	      on: {
	        "click": function($event) {
	          _vm.deleteRole(role.id)
	        }
	      }
	    }, ["删除"])])])
	  })])])
	},staticRenderFns: [function (){var _vm=this;
	  return _vm._h('tr', [_vm._h('th'), " ", _vm._h('th', ["name"]), " ", _vm._h('th', ["display_name"]), " ", _vm._h('th', ["description"]), " ", _vm._h('th', ["created_time"]), " ", _vm._h('th', ["operation"])])
	}]}
	if (false) {
	  module.hot.accept()
	  if (module.hot.data) {
	     require("vue-hot-reload-api").rerender("data-v-d07fb5a4", module.exports)
	  }
	}

/***/ }

});