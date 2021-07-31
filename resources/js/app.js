

import Vue from 'vue';

window.Vue = require('vue').default;
window.axios = require('axios');

Vue.config.ignoredElements = ['video-js']
Vue.component('subscribe-button', require('./component/subscribe-button.vue').default)
Vue.component('votes', require('./component/votes.vue').default)
Vue.component('replies', require('./component/replies.vue').default)
Vue.component('comments', require('./component/comments.vue').default)
require('./component/upload-video');
const app = new Vue({
    el: '#app'
}) 