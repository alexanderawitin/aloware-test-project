require('./bootstrap');

import VueTimeago from 'vue-timeago';
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
import { required } from 'vee-validate/dist/rules';

window.Vue = require('vue');

Vue.use(VueTimeago, {
    locale: 'en',
});

extend('required', {
    ...required,
    message: 'This field is required'
});

Vue.component('validation-observer', ValidationObserver);
Vue.component('validation-provider', ValidationProvider);
Vue.component('alo-posts', require('./components/PostsComponent.vue').default);
Vue.component('alo-post', require('./components/PostComponent.vue').default);
Vue.component('alo-comments', require('./components/CommentsComponent.vue').default);
Vue.component('alo-comment', require('./components/CommentComponent.vue').default);
Vue.component('alo-reply', require('./components/ReplyComponent.vue').default);

const app = new Vue({
    el: '#app',
});
