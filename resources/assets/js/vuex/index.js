// Vuex
import Vuex from 'vuex';
import Vue from 'vue';
Vue.use(Vuex);

const store = new Vuex.Store({
	state: {
		imageList: [{
			img: '/images/slide1.jpg',
			origin: 0,
			current: 0,
			style: {
				'transform': `translateX(0%)`
			},
		}, {
			img: '/images/slide2.jpg',
			origin: 100,
			current: 0,
			style: {
				'transform': `translateX(${ 100 }%)`
			},
		}, {
			img: '/images/slide3.jpg',
			origin: 200,
			current: 0,
			style: {
				'transform': `translateX(${ 200 }%)`
			},
		}, {
			img: '/images/slide1.jpg',
			origin: 300,
			current: 0,
			style: {
				'transform': `translateX(${ 300 }%)`
			},
		}, {
			img: '/images/slide2.jpg',
			origin: 400,
			current: 0,
			style: {
				'transform': `translateX(${ 400 }%)`
			},
		}],
		slideParams: {
			currentPage: 0,
		},
		
		
		tabContents:[
			"content1",
			"content2",
			"content3"
		]
		
	},

	mutations: {
		prev(state) {
			state.slideParams.currentPage = state.slideParams.currentPage > 0 ? --state.slideParams.currentPage : state.imageList.length - 1;
		},
		next(state) {
			state.slideParams.currentPage = state.slideParams.currentPage < state.imageList.length - 1 ? ++state.slideParams.currentPage : 0;
		},
		turnTo(state, num) {
			state.slideParams.currentPage = num;
		},
		changeTransform(state) {
			state.imageList.forEach(
				function(page, index) {
					page.style['transform'] = `translateX(${page.origin + page.current}%)`
				}
			)
		},
		toggleFavourite(state) {
			state.imageList[state.slideParams.currentPage].favourite = !state.imageList[state.slideParams.currentPage].favourite;
		},
		moreCategories(){
			//
		},
		loadContent(state){
			console.log("加载tab内容");
		},
		
	},
});

export default store;