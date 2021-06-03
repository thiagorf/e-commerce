<template>
    <div>
        <div v-if="products">
            <div v-if="modal" class="table-wrapper">
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
            <div class="createProduct">
            <button @click="createModal = true" class="align-icon">
                <font-awesome-icon :icon="['fas', 'plus']"/>
                Adicionar
            </button>
                <div class="blur-wrapper" v-if="createModal">
                    <button @click="createModal = false"><font-awesome-icon :icon="['fas', 'times']" /></button>
                </div>
                <CreateProduct v-show="createModal"/>
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
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in products" :key="index">
                            <td data-label="Id" v-text="product.id"></td>
                            <td data-label="Nome" v-text="product.name"></td>
                            <td data-label="Descrição" v-text="product.description"></td>
                            <td data-label="Preço" v-text="product.price"></td>
                            <td data-label="Imagem">
                                <div>
                                    <img :src="`/storage/${product.productImage}`" alt="">
                                </div>
                            </td>
                            <td data-label="Categorias">
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
                            <td data-label="Ações">
                                <font-awesome-icon @click="showModal(product.id)" :icon="['fas', 'pen']"/>
                                <font-awesome-icon :icon="['fas', 'trash']"/>
                            </td>
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
            createModal: true,
            fileData: null,
            tags: []
        }
    },
    watch: {
        products() {
            return this.products.length
        },
        /*createModal() {
            let blur = document.querySelector('body')
            if(this.createModal) {
                blur.style.filter = 'blur(1px)'
            }else {
                blur.removeAttribute('style')
            }
            
        }*/
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
//@import './../../../sass/table';
@import './../../../sass/table2';
@import './../../../sass/productsForm';
.createProduct {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    width: 84.5%;
    margin: 0 auto;
    .align-icon {
        margin-top: 10px;
        margin-bottom: 5px;
    }
}

</style>