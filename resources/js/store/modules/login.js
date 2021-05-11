import {SET_LOGIN, SET_FAVORITE, SET_FAVORITE_PRODUCT, SET_ROLE} from './mutations-type'

export const login = {
    state: {
        login: [],
        favorite: [],
        favoriteProduct: [],
        role: null
    }, 
    mutations: {
        [SET_LOGIN]: (state, payload) => state.login = payload,
        [SET_FAVORITE]: (state, payload) => state.favorite = payload, 
        [SET_FAVORITE_PRODUCT]: (state, payload) => state.favoriteProduct = payload,
        [SET_ROLE]: (state, payload) => state.role = payload
    },
    actions: {
        [SET_LOGIN]: ({ commit }) => {
            return axios.get('/api/login')
                    .then(response => {
                        commit('SET_LOGIN', response)
                    })
        },
        [SET_FAVORITE]: ({ commit }) => {
            return axios.get('/api/check/favorites')
                    .then(response => {
                        commit('SET_FAVORITE', response)
                    })
        },
        [SET_FAVORITE_PRODUCT]: ({ commit }) => {
            axios.get('/api/check/favorites')
                    .then(response => {
                        axios.get(`/api/favorites/${response.data.id}/products`)
                        .then(response => {
                            commit('SET_FAVORITE_PRODUCT', response.data.products)
                        })
                    })
               
        },
        [SET_ROLE]: ({ commit }) => {
            //axios.get('/api/check/roles')
            //    .then(response => {
            //        commit('SET_ROLE', response)
            //    })
            axios.get('/api/checkPermission')
                .then(response => {
                    commit('SET_ROLE', response.data)
                })
        }
    }
}