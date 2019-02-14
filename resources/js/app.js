require('./bootstrap');

window.Vue = require('vue');

let axios = require('axios');

Vue.component('comments', require('./components/CommentComponent.vue').default);

const app = new Vue({
    el: '#app'
});
