<template>
    <div class="form-wrapper">
        <form method="POST">
            <h1>Crie sua conta</h1>
            <div class="field">
                <label for="name">Nome</label>
                <input type="text" v-model="formData.name" id="name">
            </div>
            <div class="field">
                <label for="email">E-mail</label>
                <input type="email" v-model="formData.email" id="email">
            </div>
            <div class="field">
                <label for="pw">Senha</label>
                <input type="password" v-model="formData.password" id="pw">
            </div>
            <router-link to="/login">ja possui uma conta?</router-link>
            <button type="submit" @click.prevent="createAccount">Cadastrar</button>
        </form>
    </div>  
</template>
<script>
    export default {
        name: 'Register',
        data () {
            return {
                formData: {
                    name: '',
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
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
       a {

       }
    }
</style>