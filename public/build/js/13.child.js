webpackJsonp([13],{

/***/ 229:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(230)

	/* script */
	__vue_exports__ = __webpack_require__(231)

	/* template */
	var __vue_template__ = __webpack_require__(232)
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
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\app\\Child.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (true) {(function () {
	  var hotAPI = __webpack_require__(51)
	  hotAPI.install(__webpack_require__(52), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-802ae8c0", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-802ae8c0", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] Child.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 230:
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },

/***/ 231:
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
	    name: 'Child',
	    methods: {}
	};

/***/ },

/***/ 232:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._m(0)
	},staticRenderFns: [function (){var _vm=this;
	  return _vm._h('div', [_vm._h('div', ["this is child"])])
	}]}
	if (true) {
	  module.hot.accept()
	  if (module.hot.data) {
	     __webpack_require__(51).rerender("data-v-802ae8c0", module.exports)
	  }
	}

/***/ }

});