import Vue from "vue"
import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
    // { path: '/admin/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/admin/developer', component: require('./components/Developer.vue').default },
    { path: '/admin/users', component: require('./components/Users.vue').default },
    // { path: '/admin/profile', component: require('./components/Profile.vue').default },
    { path: '/admin/*', component: require('./components/NotFound.vue').default },
    {
        path: "/admin",
        name: "Admin",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
        import(/* webpackChunkName: "about" */ "./components/Dashboard.vue"),
        children: {
            path: "/admin/profile",
            name: "Profile",
            // route level code-splitting
            // this generates a separate chunk (about.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () =>
            import(/* webpackChunkName: "about" */ "./components/Profile.vue"),
        }
    }
  ]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

export default router