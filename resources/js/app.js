
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
window.moment = moment;
import Gate from './gate.js';
Vue.prototype.$gate = new Gate(window.user);
// validate form
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));

import VueRouter from 'vue-router'
Vue.use(VueRouter)



import Swal from 'sweetalert2';
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Toast = Toast;

import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  });

  import Vue2Editor from "vue2-editor";
  
  Vue.use(Vue2Editor);

let routes = [
    { path: '/admin/dashboard', component: require('./components/admin/Dashboard.vue').default },
    { path: '/admin/developer', component: require('./components/admin/Developer.vue').default },
    { path: '/admin/users', component: require('./components/admin/Users.vue').default },
    { path: '/admin/categories', component: require('./components/admin/Categories.vue').default },
    { path: '/admin/posts', component: require('./components/admin/posts/Index.vue').default },
    { path: '/admin/posts/new', component: require('./components/admin/posts/New.vue').default },
    { path: '/admin/posts/edit', component: require('./components/admin/posts/Edit.vue').default },
    { path: '/admin/profile', component: require('./components/admin/Profile.vue').default },
    { path: '/admin/*', component: require('./components/NotFound.vue').default },


    { path: '/', component: require('./components/frontend/home/Index.vue').default },
    { path: '/category/:slug', component: require('./components/frontend/categories/Index.vue').default },
    { path: '/detail/:slug', component: require('./components/frontend/detail/Index.vue').default },
    { path: '/contact', component: require('./components/frontend/Contact.vue').default },

  ]

const router = new VueRouter({
    mode: 'history',
    routes,
})



Vue.filter('upText', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
  });

Vue.filter('myDate', function (date) {
    return moment(date).format("MMMM Do YYYY"); 
});

Vue.filter('tranformToHour', function (time) {
    return moment(time).startOf('hour').fromNow();
})

Vue.filter('shortenDescription', function(value) {
    if (value) 
        return  value.slice(0, 62) + '...' ;
})

Vue.filter('shortenTitle', function(value) {
    if (value) 
        return  value.slice(0, 32) + '...' ;
})

window.Fire = new Vue();
  
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);


Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router, 

    data: {
        search: ''
    },
    methods: {
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        }, 1000),

    },
    created() {
        Fire.$on("pushRouter", (item) => {
            this.$router.push('/detail/' + item.slug);
            // add a view
            axios.put("/api/frontend/add-view/" + item.id)
            .then()
            .catch(err => console.log(err))
        })
    },
});
