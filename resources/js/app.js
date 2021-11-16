
require('./bootstrap');

import Vue from 'vue'
import Notifications from 'vue-notification'
window.Vue = require('vue').default;
Vue.use(Notifications)

import router from "./router.js";
import App from './components/App'

Vue.prototype.$hostname = 'http://127.0.0.1:8000';

new Vue({
    router: router,
    render: (x) => x(App)
}).$mount('#app');
