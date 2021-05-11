<template>
    <div>
        <div v-if="users" class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Criado em</th>
                        <th>Compras feitas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td v-text="user.id"></td>
                        <td v-text="user.name"></td>
                        <td v-text="user.email"></td>
                        <td v-text="dateConvert(user.created_at)"></td>
                        <td>
                            <select>
                                <option 
                                    
                                    v-for="(product, index) in user.orders.products" :key="index"
                                    :value="product.name"
                                    v-text="product.name"
                                >
                                </option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <p>Carregando...</p>
        </div>
    </div>   
</template>
<script>
export default {
    name: 'UsersDashboard',
    data() {
        return {
            users: null
        }
    },
    watch: {
        users() {
            return this.users.length
        }
    },
    methods: {
        dateConvert(data) {
            const date = new Date(data)
            console.log();
            return date.toLocaleDateString()
        }
    },
    beforeCreate() {
        axios.get('/api/users')
            .then(response => {
                this.users = response.data.users
                console.log(this.users)
            })
    }
}
</script>
<style lang="scss" scoped>

.table-wrapper {
    width: 84.5%;
    margin: 0 auto;
}

table {
    table-layout: fixed;
    display: block;
    overflow-x: auto;
    white-space: nowrap;
    border: 1px solid black;
    width: 100%;
    th {
        width: 25%;
    }

}
</style>