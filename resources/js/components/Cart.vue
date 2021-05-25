<template>
    <div>
        <div v-if="deleteModal">
            <h6>Deseja excluir o produto?</h6>
            <button @click="removeFromCart(deleteModal.productId)">Sim</button>
            <button @click="deleteModal = false">Não</button>
        </div>
        <div v-if="products">
            <div v-if="products.length < 1">
                <p>Não existe produtos no carrinho</p>
            </div>
            <div v-else class="select-products-container">
                <h1>Selecione os produtos</h1>
                <input type="checkbox" id="all" @click="checkAll">
                <label for="all">Selecione todos</label>
                <div v-for="product in products" :key="product.id" class="cart-layer">
                    <input type="checkbox" 
                        :name="product"
                        :id="product.name"
                        :value="product.id"
                        v-model="formData.productId"
                    >
                    <label 
                        :for="product.name"
                        v-text="product.name"
                    >
                    </label>
                    <p>
                        R${{product.price}}
                    </p>
                    <font-awesome-icon :icon="['fas', 'trash']" @click="showModal(product.id)"/>
                </div>
                <p>
                    R$ {{totalValue}}
                </p>
                <button @click="makeOrder">Fazer Pedido</button>
            </div>
            <div>
                <!--
                <div>
                    <label for="cardNumber"></label>
                    <input type="text" id="cardNumber" name="cardNumber" v-model="formData.cardNumber" value="1111 1111 1111 1111">
                </div>
                <div>
                    <label for="cvv"></label>
                    <input type="text" id="cvv" name="cvv" v-model="formData.cvv" value="111">
                </div>
                <div>
                    <label for="owner"></label>
                    <input type="text" id="owner" name="owner" v-model="formData.owner" value="fulano">
                </div>
                <div>
                    <label for="expiryDate"></label>
                    <input type="date" id="expiryDate" name="expiryDate" v-model="formData.expiryDate">
                </div>
                  month/year 
                -->

            </div>
        </div>
        <div v-else>
            <Spinner />
        </div>
    </div>
</template>
<script>
import Spinner from './Spinner'
export default {
    name: 'cart',
    data() {
        return {
            products: null,
            formData: {
                productId: [],
            },
            deleteModal: false,
            productData: {
                id: ''
            }
            /*
                cardNumber: '',
                cvv: '',
                owner: '',
                expiryDate: ''
            */
        }
    },
    computed: {
        login() {
             return this.$store.state.login.login
        },
        totalValue() {
            const products = this.products
            let productsPrice = 0
            const checkItems = this.formData.productId
            const price = ''
            for (let i = 0; i < checkItems.length; i++) {
               for (let j = 0; j < products.length; j++) {
                    if(checkItems[i] == products[j].id) {
                        let p = parseInt(products[j].price)
                        productsPrice = productsPrice + p
                    }  
               } 
            }
            return productsPrice || '0';
        }
    },
    watch: {
        products() {
            return this.products.length
        },
        login() {
            return this.login.length
        }, 
        totalValue() {
            return this.totalValue.length
        }
    },
    methods: {
        checkAll() {
            const products = this.products
            const product = []
            const pId = this.formData.productId
            const data = []
            for (let i = 0; i < products.length; i++) {
                product.push(products[i].id)
            }
            if(this.formData.productId.length == product.length) {
                products.forEach(element => {
                    this.formData.productId.pop()
                });
            }else if(pId.length > 0) {
                for (let i = 0; i < products.length; i++) {
                   for (let j = 0; j < pId.length; j++) {
                      if(!(pId[j].id == products[i].id)) {
                          data.push(products[i].id)
                      } 
                   } 
                }
            }else {
                products.forEach(element => {
                    this.formData.productId.push(element.id)
                });
            }
            pId.push(...data)
            this.formData.productId = [ ...new Set(pId)]
            data.slice(0, data.length)
        },
        makeOrder() {
            axios.post('/api/orders', this.formData)
                .then(response => {
                    console.log(response.data.message)
                    this.showCart()
                })
        },
        async showCart() {
            await this.$store.dispatch('SET_LOGIN')
            if(this.login.data) {
                const loginId = this.login.data.id
                axios.get(`/api/carts/${loginId}/products`)
                    .then(response => {
                        this.products = response.data.products
                    })
            }else {
                this.$router.push('/login')
            }
        },
        showModal(id) {
            console.log(id)
            this.deleteModal = true
            this.productData.id = id
        },
        removeFromCart(id) {
            const cartId = this.login.data.id
            //this.productData.id = id
            console.log(id)
            axios.delete(`/api/carts/${cartId}/products`, {
                data: this.productData
            })
            .then(response => {
                console.log(response.data.message)
                this.deleteModal= false
                this.showCart()
            })
        }
    },
    created() {
        this.showCart()
    },
    components: {
        Spinner
    } 
}
</script>
<style lang="scss" scoped>
@import './../../sass/checkbox';
@import './../../sass/variables';
.select-products-container {
    display: flex;
    flex-direction: column;
    padding: 4px 4px 4px 0;
    width: 84.5%;
    max-width: 336px;
    margin: 0 auto;
    button {
        align-self: flex-end;
        background: $button-color;
        padding: 3px;
        margin-top: 3px;
        width: 100%;
    }
}
.cart-layer {
    display: flex;
    justify-content: space-between;
    p {
        margin-left: 12px;
    }
}
@media screen and (min-width: 767px) {
    .select-products-container {
        width: 84.5%;
    }
}
</style>