
import {SET_CATEGORIES} from './mutations-type'

export const categories = {
    state: {
        categories: []
    },
    mutations: {
        [SET_CATEGORIES]: (state, payload) => state.categories = payload 
    },
    actions: {
        [SET_CATEGORIES]: ({ commit }) => {
            axios.get('/api/categories')
                    .then(res => {
                        commit('SET_CATEGORIES', res.data.categories)
                    })
        }
    }
}