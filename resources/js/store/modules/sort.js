import {SET_TAGS, SET_QUERY} from './mutations-type'

export const sort = {
    state: {
        tags: [],
        query: ''
        
    }, 
    mutations: {
        [SET_TAGS]: (state, payload) => state.tags = payload, 
        [SET_QUERY]: (state, payload) => state.query = payload, 
    },
    actions: {
        [SET_TAGS]: ({ commit }, payload) => {
                axios.get(`/api/products${payload}`)
                        .then(res => {
                            commit('SET_PRODUCTS', res.data.products)
                        })
        }
    }
}