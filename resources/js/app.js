
require('./bootstrap');

import Vue from 'vue'
import Notifications from 'vue-notification'
window.Vue = require('vue').default;
Vue.use(Notifications)

import router from "./router.js";
import App from './components/App'

new Vue({
    router: router,
    render: (x) => x(App)
}).$mount('#app');
