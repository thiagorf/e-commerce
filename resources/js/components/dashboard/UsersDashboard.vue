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
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td data-label="Id" v-text="user.id"></td>
                        <td data-label="Nome" v-text="user.name"></td>
                        <td data-label="Email" v-text="user.email"></td>
                        <td data-label="Criado em" v-text="dateConvert(user.created_at)"></td>
                    </tr>
                </tbody>
            </table>
            <!-- <table>
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
            </table> -->
        </div>
        <div v-else>
            <Spinner />
        </div>
    </div>   
</template>
<script>
import Spinner from './../Spinner'
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
            return date.toLocaleDateString()
        }
    },
    beforeCreate() {
        axios.get('/api/users')
            .then(response => {
                this.users = response.data.users
            })
    },
    components: {
        Spinner
    }
}
</script>
<style lang="scss" scoped>
//@import './../../../sass/table';
@import './../../../sass/table2';
</style>