require('./bootstrap');

window.Vue = require('vue');

let axios = require('axios');

Vue.component('comments', require('./components/CommentComponent').default);

const app = new Vue({
    el: '#app'
});
