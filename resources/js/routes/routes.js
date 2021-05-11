import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Main from './../components/Main.vue'
import Login from './../components/Login.vue'
import Register from './../components/Register.vue'
import Favorite from './../components/Favorite.vue'
import Cart from './../components/Cart.vue'
import Dashboard from './../components/Dashboard.vue'
import UsersDashboard from './../components/dashboard/UsersDashboard.vue'
import CategoriesDashboard from './../components/dashboard/CategoriesDashboard.vue'
import OrdersDashboard from './../components/dashboard/OrdersDashboard.vue'
import ProductsDashboard from './../components/dashboard/ProductsDashboard.vue'
import DetailProduct from './../components/DetailProduct.vue'
import axios from 'axios'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'main',
            component: Main,
        },
        {
            path: '/products/:id',
            name: 'products',
            component: DetailProduct
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'resgister',
            component: Register
        },
        {
            path: '/cart',
            name: 'cart',
            component: Cart
        },
        {
            path: '/favorite',
            name: 'favorite',
            component: Favorite
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
            meta: {requirePermission: true},
            children: [
                {
                    path: 'users',
                    name: 'users',
                    meta: {requirePermission: true},
                    component: UsersDashboard
                },
                {
                    path: 'categories',
                    name: 'categories',
                    meta: {requirePermission: true},
                    component: CategoriesDashboard
                },
                {
                    path: 'orders',
                    name: 'orders',
                    meta: {requirePermission: true},
                    component: OrdersDashboard
                },
                {
                    path: 'products',
                    name: 'dashboardProducts',
                    meta: {requirePermission: true},
                    component: ProductsDashboard
                }
            ]
        }
  
    ]
})

router.beforeEach(async (to, from, next) => {
    if(to.matched.some(record => record.meta.requirePermission)) {
        console.log(checkPermission())
        if(await checkPermission() ) next()
        else next({path: '/'})
    }
    console.log()
    next() 
            
})

function checkPermission() {
    return axios.get('/api/checkPermission')
    .then(response => {
        console.log(response)
        if (response.data) return true
        //if (response.data) return response.data
        else return false
        
    })   
}

export default router