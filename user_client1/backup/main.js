import App from './App'
import store from './store'

import Vue from 'vue'
Vue.config.productionTip = false
App.mpType = 'app'

// 引入全局TuniaoUI
import TuniaoUI from 'tuniao-ui'
Vue.use(TuniaoUI)

// 引入TuniaoUI提供的vuex简写方法
let vuexStore = require('@/store/$t.mixin.js')
Vue.mixin(vuexStore)

// 引入TuniaoUI对小程序分享的mixin封装
let mpShare = require('tuniao-ui/libs/mixin/mpShare.js')
Vue.mixin(mpShare)

//挂载全局方法
import func from '@/utils/function.js'
Vue.prototype.$func = func

// 引入request
import $api from '@/utils/index.js';
Vue.prototype.$api = $api;

const app = new Vue({
  store,
  ...App
})

app.$mount()