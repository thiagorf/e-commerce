import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import Login from './../components/Login.vue'
import Register from './../components/Register.vue'
import Main from './../components/Main.vue'
import Products from './../components/products/Products.vue'
import Favorites from './../components/Favorites.vue'
import Cart from './../components/Cart.vue'
import Categories from './../components/categories/Categories.vue'

import Teste from './../components/Teste.vue'
import Home from './../components/Home.vue'
import About from './../components/About.vue'
import axios from 'axios';


const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'form',
            // component: Login,
            component: Login
            
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {

          // login -> home/products {
          // search bar | content with pagination
          //}
          path: '/home',
          name: 'home',
          component: Main,
          beforeEnter: (to, from, next) => {
            axios.get('/api/autenticathe').then(response => {
              next()
            }).catch(() => {
              return next({name: 'form'})
            })
          },
          children: [
            {
              path: '/',
              name: 'products',
              component: Products
            },
            {
              path: '/favorites',
              name: 'favorites',
              component: Favorites
            },
            {
              path: '/cart',
              name: 'cart',
              component: Cart
            }
          ]
        },
        // {
        //     path: '/teste',
        //     name: 'teste',
        //     component: Teste,
        //     beforeEnter: (to, from, next) => {
        //       axios.get('/api/autenticathe').then(response => {
        //         next()
        //       }).catch(() => {
        //         return next({name: 'form'})
        //       })
        //     },
        // }    
        //     children: [
        //         {
        //             path:'/teste/home',
        //             name: 'home',
        //             component: Home,
        //             meta: { requiresAuth: true },
        //         },
        //         {
        //             path:'/teste/about',
        //             name: 'about',
        //             component: About,
        //             meta: { requiresAuth: true },
        //         },
        //         {
        //           path: '/teste/products',
        //           name: 'product',
        //           component: Product,

        //         }
        //     ]
        // }
    ]
})
function loggedIn() {
    return false
}

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
      // this route requires auth, check if logged in
      // if not, redirect to login page.
      if (!loggedIn()) {
        next({
          path: '/',
          query: { redirect: to.fullPath }
        })
      } else {
        next()
      }
    } else {
      next() // make sure to always call next()!
    }
  })

export default router