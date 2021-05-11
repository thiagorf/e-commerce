import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

import {products} from './modules/products.js'
import {login} from './modules/login.js'
import {sort} from './modules/sort.js'
import {categories} from './modules/categories.js'

const store = new Vuex.Store({
    modules: {
        products,
        login,
        sort,
        categories
    },
    strict: true,
    state: {
        // products -> só os products talvez os favoritos
        // sort -> tags e query
        // login -> login
        //products: [],
        // tags: [],
        // query: '',
        //login: [],
        // favorite: [],
        // favoriteProduct: []
    },
    mutations: {
        // getProducts(state, products) {
        //     state.products = products
        // },
        // sortProducts (state, sort) {
        //     //state.tags.tag.push(sort)
        //     state.tags = sort
        // },
        // queryString(state, value) {
        //     state.query = value
        // },
        // login(state, login) {
        //     state.login = login
        // },
        // favorite(state, value) {
        //     state.favorite = value
        // },
        // favoriteProducts(state, value) {
        //     state.favoriteProduct = value
        // }
    },
    actions: {
        // getProducts({ commit }){
        //     axios.get('/api/products')
        //     .then( response => {
        //         commit('getProducts', response.data.products)
        //     })
        //     .catch(error => {
        //         console.log(error)
        //     })
        // },
        // sortProducts({ commit }, query) {
        //     console.log(query)
        //     //store.dispatch('getProducts')
        //     axios.get(`/api/products${query}`)
        //             .then(res => {
        //                 commit('getProducts', res.data.products)
                        
        //             })
        //             .catch(error => {
        //                 console.log(error)
        //             })
        // },
        // userLogin({ commit }) {
        //     axios.get('/api/login')
        //             .then(response => {
        //                 commit('login', response)
        //             })
        // },
        // userFavorite({ commit }) {
        //     axios.get('/api/check/favorites')
        //             .then(response => {
        //                 commit('favorite', response)
        //             })
        // },
        // favoriteProducts({commit }) {
        //     axios.get(`/api/favorites/1/products`)
        //                 .then(response => {
        //                     commit('favoriteProducts', response.data.products)
        //                 })
        // }
    }
})

export default store