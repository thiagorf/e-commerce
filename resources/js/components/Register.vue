<template>
    <div class="form-wrapper">
        <form method="POST" @submit.prevent="checkForm" novalidate>
            <h1>Crie sua conta</h1>
            <div class="field">
                <label for="name">Nome</label>
                <p v-if="erros.name" v-text="erros.name"></p>
                <input type="text" v-model="formData.name" name="name" id="name" @blur="verify($event, 'name')">
            </div>
            <div class="field">
                <label for="email">E-mail</label>
                <p v-if="erros.email" v-text="erros.email"></p>
                <input type="email" v-model="formData.email" name="email" id="email" @blur="verify($event, 'email')">
            </div>
            <div class="field">
                <label for="password">Senha</label>
                <p v-if="erros.password" v-text="erros.password"></p>
                <input type="password" v-model="formData.password" name="password" id="pasword" @blur="verify($event, 'password')">
            </div>
            <router-link to="/login">ja possui uma conta?</router-link>
            <button type="submit" >Cadastrar</button>
        </form>
    </div>  
</template>
<script>
import validationMixin from './../mixins/validationMixin'
    export default {
        name: 'Register',
        mixins: [validationMixin],
        data () {
            return {
                formData: {
                    name: '',
                    email: '',
                    password: ''
                },
                erros: {
                    name: '',
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            checkForm() {
                const isValid = this.validateForm(this.formData)
                if(isValid.formIsValid) {
                    console.log('axios call')
                }
            },
            createAccount() {
                axios.post('/api/users', this.formData).then(res => {
                    //messagem de sucesso?
                }).catch(err => console.log(err))
            }
        }
    }
</script>
<style lang="scss"  scoped>
    @use './../../sass/form'; 
    form {
       height: 300px;
    }
</style>