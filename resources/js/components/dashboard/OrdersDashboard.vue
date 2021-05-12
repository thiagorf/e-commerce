<template>
    <div>
        <div v-if="orders" class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Usuario</th>
                        <th>Produtos</th>
                        <th>Data de compra</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(order, index) in orders" :key="index">
                        <td v-text="order.id"></td>
                        <td v-text="order.user.name"></td>
                        <td>
                            <select>
                                <option 
                                    v-for="(product, index) in order.products"
                                    :key="index"
                                    :value="product.name"
                                    v-text="product.name"
                                >                                    
                                </option>
                            </select>
                        </td>
                        <td v-text="dateConvert(order.created_at)"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    name: 'OrdersDashboard',
    data() {
        return {
            orders: null
        }
    },
    watch: {
        orders() {
            return this.orders.length
        }
    },
    methods: {
        dateConvert(data) {
            const date = new Date(data)
            return date.toLocaleString()
        }
    },
    beforeCreate() {
        axios.get('/api/orders')
            .then(response => {
                this.orders = response.data.orders
            })
    }
}
</script>
<style lang="scss" scoped>
@import './../../../sass/table';
</style>