require('./bootstrap');

window.Vue = require('vue');

Vue.component('MyNavbar', require('./components/navbar.vue').default);
Vue.component('MySidebar', require('./components/sidebar.vue').default);
Vue.component('MyTaskManager', require('./components/taskManager').default);
Vue.component('MyUserManager', require('./components/userManager').default);

const app = new Vue({
    el: '#app',
});
