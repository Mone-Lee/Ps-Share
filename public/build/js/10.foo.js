webpackJsonp([10],{

/***/ 213:
/***/ function(module, exports, __webpack_require__) {

	var __vue_exports__, __vue_options__
	var __vue_styles__ = {}

	/* styles */
	__webpack_require__(214)

	/* script */
	__vue_exports__ = __webpack_require__(215)

	/* template */
	var __vue_template__ = __webpack_require__(216)
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
	__vue_options__.__file = "D:\\PhpProject\\Ps-Share\\resources\\assets\\js\\components\\app\\Foo.vue"
	__vue_options__.render = __vue_template__.render
	__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

	/* hot reload */
	if (true) {(function () {
	  var hotAPI = __webpack_require__(51)
	  hotAPI.install(__webpack_require__(52), false)
	  if (!hotAPI.compatible) return
	  module.hot.accept()
	  if (!module.hot.data) {
	    hotAPI.createRecord("data-v-3263c94a", __vue_options__)
	  } else {
	    hotAPI.reload("data-v-3263c94a", __vue_options__)
	  }
	})()}
	if (__vue_options__.functional) {console.error("[vue-loader] Foo.vue: functional components are not supported and should be defined in plain js files using render functions.")}

	module.exports = __vue_exports__


/***/ },

/***/ 214:
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },

/***/ 215:
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


	exports.default = {
	    name: 'Foo',
	    computed: {
	        count: function count() {
	            return this.$store.state.count;
	        }
	    },
	    methods: {
	        addCount: function addCount() {
	            this.$store.commit('increment');
	        }
	    }
	};

/***/ },

/***/ 216:
/***/ function(module, exports, __webpack_require__) {

	module.exports={render:function (){var _vm=this;
	  return _vm._h('div', [_vm._h('div', {
	    attrs: {
	      "id": "foo"
	    }
	  }, ["this is foo"]), " ", _vm._h('div', [_vm._s(_vm.count)]), " ", _vm._h('button', {
	    on: {
	      "click": _vm.addCount
	    }
	  }, ["addCount"])])
	},staticRenderFns: []}
	if (true) {
	  module.hot.accept()
	  if (module.hot.data) {
	     __webpack_require__(51).rerender("data-v-3263c94a", module.exports)
	  }
	}

/***/ }

});