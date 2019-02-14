require('./bootstrap');

window.Vue = require('vue');

let axios = require('axios');

Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');
Vue.component('comments', require('./components/CommentComponent.vue').default);


const app = new Vue({
    el: '#app'
});
