<template>
    <div>
        <div v-if="products">
            <div v-if="modal" class="wrapper">
                <form enctype="multipart/form-data">
                    <input type="text" v-model="modalProduct.name">
                    <input type="text" v-model="modalProduct.description">
                    <input type="text" v-model="modalProduct.price">
                    <input type="file" name="productImage" @change="takeFile($event)">
                    <div v-for="(category, index) in categories" :key="index" class="categories-wrapper">
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
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Imagem</th>
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
                            <td><img :src="`/storage/${product.productImage}`" alt=""></td>
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
                            <td><button @click="showModal(product.id)"><font-awesome-icon :icon="['fas', 'pen']" /></button></td>
                            <td><font-awesome-icon :icon="['fas', 'trash']"/></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-else>
            <Spinner />
        </div>
    </div>
</template>
<script>
import CreateProduct from './../products/CreateProducts.vue'
import Spinner from './../Spinner'
export default {
    name: 'ProductDashboard',
    data() {
        return {
            products: null,
            categories: null,
            modal: false,
            modalProduct: null,
            fileData: null,
            tags: []
        }
    },
    watch: {
        products() {
            return this.products.length
        }
    },
    methods: {
        takeFile(event) {
            this.fileData = event.target.files[0]
        },
        showModal(id) {
            this.tags = []
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
            let data = new FormData()
            console.log(this.modalProduct)
            data.append("name", this.modalProduct.name)
            data.append("description", this.modalProduct.description)
            data.append("price", this.modalProduct.price)
            this.tags.forEach(element => {
                data.append("tags[]", element)
            });
            if(this.fileData) {
                data.append("productImage", this.fileData)
            }
            data.append("_method", "PUT")
            
            axios.post(`/api/products/${id}`, data, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })
            .then(_=> {
                this.tags = []
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
        CreateProduct,
        Spinner
    }
}
</script>
<style lang="scss" scoped>
@import './../../../sass/table';
@import './../../../sass/productsForm';
</style>