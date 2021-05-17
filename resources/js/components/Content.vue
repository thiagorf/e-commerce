<template>
    <div>
        <Message :testMessage.sync="message" @notifyComponent="changeMessage"/>
        <div v-if="products">
            <!--
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Favorito</th>
                        <th>Açoes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products" :key="product.id">
                        <td v-text="product.id"></td>
                        <td v-text="product.name"></td>
                        <td v-text="product.description"></td>
                        <td v-text="product.price"></td>
                        <td v-if="favorite.data">
                            <button v-if="showFavorite(product.id)" @click="removeFavorite(product.id)">Remover dos favoritos</button>
                            <button v-else @click="addFavorite(product.id)">Adicionar aos favoritos</button>
                        </td>
                        <td><button @click="showMore(product.id)">Ver Mais</button></td>
                    </tr>
                </tbody>
            </table>
            -->
            <div class="content" v-if="products">
                <div class="card" v-for="product in products" :key="product.id">
                    <div class="img">
                        Conteudo
                        <div class="fav-layer" v-if="favorite.data">
                            <button 
                                v-if="showFavorite(product.id)" 
                                @click="removeFavorite(product.id)"
                            >
                                F
                            </button>
                           
                            <button 
                                v-else 
                                @click="addFavorite(product.id)"
                            >
                                f
                            </button>
                        </div>
                        <div class="fav-layer" v-else>
                            <button @click="showLogin">FX</button>
                        </div>
                    </div>
                    <div class="card-info">
                        <h6 v-text="product.name"></h6>
                        <span>
                            R${{product.price}},00
                        </span>
                        <button @click="showMore(product.id)">Ver Mais</button>
                    </div>
                </div>
            </div>

        </div>
    <div v-else>
        Carregando...
    </div>
    </div>
</template>
<script>
import Message from './Message.vue'
export default {
    name: 'Content',
    data() {
        return {
            products: null,
            queryString: '',
            favoriteProducts: null,
            message: '',
            formData: {
                id: ''
            }
        }
    },
    props: {
        sort: String
    },
    watch: {
        products() {
            return this.products.length
        },
        sort(propsValue) {
            this.queryString = propsValue
            this.sortedProducts()
        },
        favoriteProducts() {
            return this.favoriteProducts.length
        },
        message() {
            return this.message.length
        }
    },
    computed: {
        favorite() {
            return this.$store.state.login.favorite
        },
        checkId() {
            return this.$store.state.login.favorite
        }
    },
    methods: {
        sortedProducts() {  
            const data = this.queryString ? `?${this.queryString}`: ''
            axios.get('/api/products' + data)
                .then(response => {
                    this.products = response.data.products
                })
        },
        checkFavorite() {
            if(this.favorite.data) {
                axios.get(`/api/favorites/${this.favorite.data.id}/products`)
                    .then(response => {
                        this.favoriteProducts = response.data.products
                    })
            }
        },
        showFavorite(id) {
            const favoriteProducts = this.favoriteProducts
            if(favoriteProducts) {
                for(let i = 0; i < favoriteProducts.length; i++) {
                    if(id == favoriteProducts[i].id) {
                        return true
                        //return 'Yes'
                    }
                }
                return false
                //return 'No';
            }
        },
        async getProducts() {
            await this.$store.dispatch('SET_FAVORITE')
            await this.checkFavorite()
            axios.get('/api/products')
                .then(response => {
                    this.products = response.data.products
                })
        },
        showMore(id) {
            this.$router.push({name: 'products', params: {id: id}})
        },
        removeFavorite(id) {
            this.formData.id = id
            const favoriteId = this.favorite.data.id
            // axios com o metodo delete precisa do propriedade data definida
            axios.delete(`/api/favorites/${favoriteId}/products`, {data: this.formData})
            .then(response => {
                this.message = response.data.message
                this.checkFavorite()
                // muitas requisições feitas para atualizar o botao
                //this.$i()
            })
        },
        addFavorite(id) {
            const favoriteId = this.favorite.data.id
            axios.post(`/api/favorites/${favoriteId}/products`, {
                id:id
            })
            .then(response => {
                this.message = response.data.message
                this.checkFavorite()
                //this.$store.dispatch('SET_FAVORITE')
            })
        },
        changeMessage() {
            this.messsage = ''
        },
        showLogin() {
            this.$router.push('/login')
        }
    },
    created() {
        this.getProducts()
    },
    components: {
        Message
    }
   
}
</script>
<style lang="scss" scoped>
@import './../../sass/grid';


.fav-layer {
    position: absolute;
    z-index: 5;
    top: 0;
    right: 5px;
}
</style>