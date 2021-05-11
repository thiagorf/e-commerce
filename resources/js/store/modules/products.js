// importar as mutations no mutations-type.js
import {SET_PRODUCTS} from './mutations-type'
export const products = {

    state: {
        products: []
    }, 
    mutations: {
        [SET_PRODUCTS]: (state, payload) => state.products = payload
    }, 
    actions: {
        [SET_PRODUCTS]: ({ commit }) => {
            axios.get('/api/products')
            .then( response => {
                commit('SET_PRODUCTS', response.data.products)
            })
            .catch(error => {
                console.log(error)
            })
        }
    }
}