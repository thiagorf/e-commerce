<template>
    <div>
        <div v-if="modal">
            <form>
                <input type="text" v-model="modalProduct.name">
                <input type="text" v-model="modalProduct.description">
                <input type="text" v-model="modalProduct.price">
                <div v-for="(category, index) in categories" :key="index">
                    <input type="checkbox" :id="category.tag" :value="category.id" v-model="tags">
                    <label 
                        :for="category.tag"
                        v-text="category.tag"
                    >
                    </label>
                </div>
                <button type="submit" @click.prevent="updateProduct(modalProduct.id)">Atualizar</button>
            </form>
            <button @click="modal = false">Cancelar</button>
        </div>
        <div>
            <CreateProduct />
        </div>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Categorias</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in products" :key="index">
                    <td v-text="product.id"></td>
                    <td v-text="product.name"></td>
                    <td v-text="product.description"></td>
                    <td v-text="product.price"></td>
                    <td>
                        <select>
                            <option 
                                v-text="category.tag" 
                                :value="category.tag" 
                                v-for="(category, index) in product.categories" 
                                :key="index"
                            >
                            </option>
                        </select>
                    </td>
                    <td><button @click="showModal(product.id)">Editar</button></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import CreateProduct from './../products/CreateProducts.vue'
export default {
    name: 'ProductDashboard',
    data() {
        return {
            products: null,
            categories: null,
            modal: false,
            modalProduct: null,
            tags: []
        }
    },
    watch: {
        products() {
            return this.products.length
        }
    },
    methods: {
        showModal(id) {
            axios.get(`/api/products/${id}`)
                .then(response => {
                    this.modalProduct = response.data.product
                    const ids = response.data.product.categories
                    for (let i = 0; i < ids.length; i++) {
                        this.tags.push(ids[i].id);
                    }
                    this.modal = true
                })
        },
        updateProduct(id) {
            const name = this.modalProduct.name
            const description = this.modalProduct.description
            const price = this.modalProduct.price

            axios.put(`/api/products/${id}`, {
                name: name,
                description: description,
                price: price,
                tags: this.tags
            })
            .then(response => {
                console.log(response.data.message)
                this.modal = false
                this.getProducts()
            })
        },
        getProducts() {
            axios.get('/api/products/categories')
                .then(response => {
                    this.products = response.data.products
                })
        }
    },
    created() {
        this.getProducts()
        axios.get('/api/categories')
                .then(response => {
                    this.categories = response.data.categories
                })
    },
    components: {
        CreateProduct
    }
}
</script>