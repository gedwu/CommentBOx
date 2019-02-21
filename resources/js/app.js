require('./bootstrap');

window.Vue = require('vue');


window.vueScrollTo = require('vue-scrollTo');
Vue.use(VueScrollTo);

// import VueScrollTo from 'vue-scrollto';
// Vue.use(VueScrollTo);

let axios = require('axios');

Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');
Vue.component('comments', require('./components/CommentComponent.vue').default);


const app = new Vue({
    el: '#app',
    // components:{ VueScrollTo : VueScrollTo },
});


// global.app = app;