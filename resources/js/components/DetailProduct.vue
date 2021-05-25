<template>
    <div>
        <Message  v-bind:testMessage.sync="message" @notifyComponent="changeMessage"/>
        <div v-if="product" class="detail-product">
            <div class="img">
                <img :src="`/storage/${product.productImage}`" />
            </div>
            <div class="detail-product-content">
                <h4 v-text="product.name"></h4>
                <h6 v-text="product.description"></h6>
                <span v-text="product.price"></span>
                <div v-if="login.data" class="bottom-button">
                    <button v-if="!isInCart(product.id)" @click="addCart(product.id)">Adicionar ao Carrinho</button>
                    <button v-else @click="addCart(product.id)" disabled>Adicionar ao Carrinho</button>
                </div>
                <div v-else class="bottom-button">
                    <button @click="showLoginForm">Adicionar ao Carrinho</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapActions} from 'vuex'
import {SET_LOGIN} from './../store/modules/mutations-type'
import Message from './Message.vue'

export default {
    name: 'DetailProduct',
    data() {
        return {
            product: null,
            formData: {
                id: ''
            },
            message: '',
            cartItem: null,
            defaultBehavior: true
        }
    },
    computed: {
        login(){
            return this.$store.state.login.login
        }
    },
    watch: {
        product() {
            return this.product.length
        }
    },
    methods: {
        ...mapActions({
            checkLogin: SET_LOGIN
        }),
        addCart(id) {
            this.formData.id = id

            const data = this.formData

            if(!this.login.data) {
                this.message = 'Você precisa estar logado para usar o carrinho'

            }else {
                axios.post(`/api/carts/${this.login.data.id}/products`, data)
                    .then(response => {
                        this.message = response.data.message
                        this.getProduct()
                })
            }
        },
        changeMessage() {
            this.message = ''
        },
        checkCart() {
            const cartId = this.login.data.id
            axios.get(`/api/carts/${cartId}/products`)
                .then(response => {
                    this.cartItem = response.data.products
                })
        },
        async getProduct() {
            const id = this.$route.params.id
            await this.checkLogin()
            if(this.login.data) {
                this.checkCart()
            }
            axios.get(`/api/products/${id}`)
                        .then(response => {
                            this.product = response.data.product
                        })
        },
        isInCart(id) {
            const items = this.cartItem
            for (let i = 0; i < items.length; i++) {
                if(items[i].id == id) {
                    return true
                }
            }
            return false

        },
        showLoginForm() {
            this.$router.push({name: 'login'})
        }
        
    },
    created() {
        this.getProduct()
    },
    components: {
        Message
    }
}
</script>
<style lang="scss" scoped>
@import './../../sass/variables';

.detail-product {
    display: flex;
    flex-direction: column;
    width: 84.5%;
    max-width: 336px;
    margin: 0 auto;
    border: 1px solid $border-color;
    border-radius: 5px;
    .img {
        //border: 1px solid $border-color;
        width: 100%;
        height: 240px;
    }
    
}
img {
    width: 100%;
    height: 100%;
}
.detail-product-content {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    height: 100%;
    //height: fit-content;

    h4, h6, span {
        padding-left: 5px;
    }
    h4 {
        font-size: 37px;
        margin-bottom: -6px;
    }
    h6 {
        margin-bottom: 4px;
        font-size: 21px;
    }
    div button {
        width: 100%;
        height: 34px;
        background: $button-color;
        border-top: 1px solid $border-color;
        border-radius: 0 0 5px 5px;
    }
}
.bottom-button {
    width: 100%;
    margin: auto;
    margin-bottom: 0;
}
@media screen and (min-width: 767px) {
    .detail-product-content {
        width: 40%;
    }
    .detail-product {
        flex-direction: row;
        max-width: 85.5%;
        height: 242px;
    }
    .img {
        width: 60% !important;
        border-right: 1px solid $border-color;
    }
}
</style>