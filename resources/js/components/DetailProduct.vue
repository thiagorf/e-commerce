<template>
    <div>
        <Message  v-bind:testMessage.sync="message" @notifyComponent="changeMessage"/>
        <div v-if="product" class="detail-product">
            <div class="img">
                IMAGEM
            </div>
            <div class="detail-product-content">
                <h4 v-text="product.name"></h4>
                <h6 v-text="product.description"></h6>
                <span v-text="product.price"></span>
                <div v-if="login.data">
                    <button v-if="!isInCart(product.id)" @click="addCart(product.id)">Adicionar ao Carrinho</button>
                    <button v-else @click="addCart(product.id)" disabled>Adicionar ao Carrinho</button>
                </div>
                <div v-else>
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
    width: 84.5%;
    margin: 0 auto;
    border: 1px solid $border-color;
    border-radius: 5px;
    .img {
        border-bottom: 1px solid black;
        width: 100%;
        height: 240px;
    }
}

.detail-product-content {
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
        margin-top: 5px;
        border-top: 1px solid $border-color;
        border-radius: 0 0 5px 5px;
    }
}

</style>