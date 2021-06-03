<template>
    <div class="form-wrapper">
        <form method="POST" @submit.prevent="checkForm" novalidate>
            <h1>Fazer Login</h1>
            <div class="field">
                <label for="email">E-mail</label>
                <p v-if="erros.email">{{ erros.email }}</p>
                <input type="email" v-model="formData.email" name="email" id="email" @blur="verify($event, 'email')">
            </div>
            <div class="field">
                <label for="password">Senha</label>
                <p v-if="erros.password">{{ erros.password }}</p>
                <input type="password" v-model="formData.password" name="password" id="password" @blur="verify($event, 'password')">
            </div>
            <router-link to="/register">Cadastrar</router-link>
            <button type="submit" >Entrar</button>
        </form>
    </div>  
</template>
<script>
import { mapActions } from 'vuex'
import { SET_LOGIN, SET_FAVORITE, SET_FAVORITE_PRODUCT, SET_ROLE } from './../store/modules/mutations-type'
import validationMixin from './../mixins/validationMixin.js'
    export default {
        name: 'Login',
        mixins: [validationMixin],
        data () {
            return {
                formData: {
                    email: '',
                    password: ''
                },
                erros: {
                    email: '',
                    password: ''
                },
            }
        },
        watch: {
            erros() {
                return this.erros.length
            },
        },
        methods: {
            ...mapActions({
                checkLogin: SET_LOGIN,
                favorite: SET_FAVORITE,
                favoriteProducts: SET_FAVORITE_PRODUCT,
                checkRole: SET_ROLE
            }),
            checkForm() {
                const isValid = this.validateForm(this.formData)
                if(isValid.formIsValid) {
                    console.log('Axios call')
                    this.login()
                }
            },
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