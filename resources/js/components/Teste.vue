<template>
    <div>
        <h1>Ta funcionando</h1>
        <router-link to="/teste/products">Home</router-link>
        <router-link to="/teste/about">About</router-link>
        <button @click="logout">Sair</button>
        <button @click="l">carregar</button>]
        <div v-for="user in data" :key="user.id">
            {{ user.name }} - {{user.email}}
        </div>
        {{data}}
        <router-view></router-view>
    </div>
</template>
<script>
export default {
    name: 'Teste',
    data() {
        return {
            data: []
        }
    },
    methods: {
        logout: function () {
            axios.get('/api/logout').then(res => {
                console.log(res)
                this.$router.push('/');
            }).catch(err => {
                console.log(err)
            })
        },
        l: function () {
             axios.get('/api/user').then(response => {
                console.log(response)
                this.data = response
            }).catch(erro => {
                console.log(erro)
            })
        }
    }
}
</script>