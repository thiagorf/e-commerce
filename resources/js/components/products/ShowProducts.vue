<template>
    <div>
        <!-- name é igual a primeira palavra presente na classe ex: fade-.. -->
        <!-- <transition name="fade">
            <h1 v-if="message" v-text="messageInterval"></h1>
        </transition> -->
        <Message :testMessage="message"  @notifyComponent="changeMessage"/>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action1</th>
                    <th>Action2</th>
                    <th>Favorite?</th>
                    <th>Ver Mais</th>
                </tr>
            </thead>
            <tbody v-if="products">
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.name }}</td>
                    <td>{{ product.description }}</td>
                    <td>{{ product.price }}</td>
                    <td><button @click="addCart(product.id)">Cart</button></td>
                    <td><button @click="addFavorite(product.id)">Favorite</button></td>
                    <td v-if="login.data" v-text="favoriteProduct(product.id)"></td>
                    <td><button @click="showMore(product.id)">Ver Mais</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import {mapActions} from 'vuex'
import {SET_LOGIN, SET_PRODUCTS} from './../../store/modules/mutations-type'
import Message from './../Message.vue'

export default {
    name: 'ShowProducts',
    data() {
        return {
            message: '',
            data: {
                id: ''
            }
        }
    },
    computed: {
        products() {
            return this.$store.state.products.products
        },
        login() {
            return this.$store.state.login.login
        },
        favorite: {
            get() {
                return this.$store.state.login.favorite
            }, 
            set(value) {
                this.$store.commit('SET_FAVORITE', value)
            }
        },
    },
    methods: {
        ...mapActions({
            setStateProducts: SET_PRODUCTS,
            setStateLogin: SET_LOGIN
        }),
        favoriteProduct(id) {
            const productArray = []
            const favoriteProducts = []
            const products = this.$store.state.products.products
            const productsF = this.$store.state.login.favoriteProduct
            
            products.forEach(x => {
                productArray.push(x.id)
            });

            productsF.forEach(x => {
                favoriteProducts.push(x.id)
            })

            const filtered = productArray.filter(value => {
                if(favoriteProducts.includes(value)) {
                    return value
                }            
            })
            // for loop pra verificar cada elemeto do array
            for (let i = 0; i < filtered.length; i++) {
                if(filtered[i] == id) {
                    return 'Yes'
                }
                
            }
            return 'No'
        },
        // addCart(id) {
        //     this.data.id = id
        //     // retornar somemte um boolean não uma string
        //     if(this.login.data == 'Not logged') {
        //         this.message = 'Você precisa estar logado para usar o carrinho'
        //     }else {
        //         //this.$store.dispatch('userLogin')
        //         axios.post(`/api/carts/${this.login.data.id}/products`, this.data)
        //             .then(response => {
        //                 this.message = response.data.message
        //                 // this.message = response
        //         })
        //     }
        // },
        addFavorite(id) {
            this.data.id = id
            if(!this.favorite.data) {
                this.message = 'Logue para adicionar produtos aos favoritos'
            }else {
                axios.post(`/api/favorites/${this.favorite.data.id}/products`, this.data)
                    .then(response => {
                        this.message = response.data.message
                    })
            } 
        },
        showMore(id) {
            const productId = id
            this.$router.push({name: 'products', params: {id: productId}})
        },
        changeMessage(){
            this.message = ''
        }
    },
    watch: {
        products() {
            return this.products.length
        },
        login() {
            return this.login.length
        },
        favorite() {
            return this.favorite.length
        },
        message() {
            return this.message.length
        }
    },
    created() {
        this.setStateProducts();
        this.setStateLogin();
    },
    components: {
        Message
    }
}
</script>
<style scoped>
    .fade-enter-active, .fade-leave-active {
  transition: opacity .3s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>