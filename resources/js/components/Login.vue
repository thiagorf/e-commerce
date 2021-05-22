<template>
    <div class="container">
        <button @click="logout">Sair</button>
        <form action="" method="POST">
            <div class="field">
                <label for="email">E-mail</label>
                <input type="email" v-model="formData.email" id="email">
            </div>
            <div class="field">
                <label for="pw">Senha</label>
                <input type="password" v-model="formData.password" id="pw">
            </div>
            <router-link to="/register">Cadastrar</router-link>
            <button type="submit" @click.prevent="login">Entrar</button>
        </form>
    </div>  
</template>
<script>
import {mapActions} from 'vuex'
import {SET_LOGIN, SET_FAVORITE, SET_FAVORITE_PRODUCT, SET_ROLE} from './../store/modules/mutations-type'
    export default {
        name: 'Login',
        data () {
            return {
                formData: {
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            ...mapActions({
                checkLogin: SET_LOGIN,
                favorite: SET_FAVORITE,
                favoriteProducts: SET_FAVORITE_PRODUCT,
                checkRole: SET_ROLE
            }),
            login() {
                axios.get('/sanctum/csrf-cookie')
                    .then(re => {
                        axios.post('/api/users/login', this.formData)
                        .then(res => {
                            this.checkLogin()
                            this.favoriteProducts()
                            this.checkRole()
                            this.favorite()
                                .then(_ => {
                                this.$router.push('/')
                            })

                            
                        })
                    })
            },
            async logout() {
                this.$store.commit('SET_ROLE', null)
                await axios.get('/api/logout')
                await this.$store.dispatch('SET_FAVORITE')
                this.$router.push('/');
            },
        }
    }
</script>
<style lang="scss"  scoped>
    @use './../../sass/form'
</style>