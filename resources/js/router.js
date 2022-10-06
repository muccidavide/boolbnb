// 0. If using a module system (e.g. via vue-cli), import Vue and VueRouter
// and then call Vue.use(VueRouter).

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

// 1. Define route components.
// These can be imported from other files

import Home from './Pages/Home';
import Search from './Pages/Search';
import Apartment from './Pages/Apartment';
import PageNotFound from './Pages/error/PageNotFound'

// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// Vue.extend(), or just a component options object.
// We'll talk about nested routes later.

const routes = [
    { path: '/', component: Home, name: 'home' },
    { path: '/search', component: Search, name: 'search' },
    { path: '/apartment/:slug', component: Apartment, name: "apartment" },
    { path: "*", component: PageNotFound },
]

// 3. Create the router instance and pass the routes option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    mode: 'history',
    routes // short for routes: routes
})

export default router;