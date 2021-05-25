<template>
        <!-- <Message :testMessage.sync="message" @notifyComponent="changeMessage"/>
        -->
            <div class="content" v-if="products">
                <div class="card" v-for="product in products" :key="product.id">
                    <div class="img">
                        <img :src="`/storage/${product.productImage}`" alt="Imagem do produto">
                        <div class="fav-layer" v-if="favorite.data">
                            <button 
                                v-if="showFavorite(product.id)" 
                                @click="removeFavorite(product.id)"
                            >
                                <font-awesome-icon :icon="['fas', 'heart']" class="fav-wrapper"/>
                            </button>
                           
                            <button 
                                v-else 
                                @click="addFavorite(product.id)"
                            >
                                <font-awesome-icon :icon="['far', 'heart']" class="fav-wrapper"/>
                            </button>
                        </div>
                        <div class="fav-layer" v-else>
                            <button @click="showLogin"><font-awesome-icon :icon="['far', 'heart']" class="fav-wrapper" /></button>
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
                    }
                }
                return false
            }
        },
        async getProducts() {
            await this.$store.dispatch('SET_FAVORITE')
            await this.checkFavorite()
            console.log('aq')
            axios.get('/api/products')
                .then(response => {
                    this.products = response.data.products
                    this.$emit('loadingDone', true)
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
@import './../../sass/variables';


.fav-layer {
    position: absolute;
    z-index: 5;
    top: 0;
    right: 5px;
}
</style>