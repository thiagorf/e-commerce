<template>
    <div>
        <div v-if="products">
            <div v-for="product in products" :key="product.id">
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
            </div>
            <div>
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
                 <!-- month/year -->


            </div>
            <button @click="makeOrder">Fazer Pedido</button>
            <!-- <p v-for="product in products" :key="product.id" v-text="product.name"></p>
            <button @click="test">Login</button> -->
            <!-- {{login.data}} -->
        </div>
        <div v-else>
            <p>É necessario fazer login para ver o carrinho</p>
        </div>
    </div>
</template>
<script>
export default {
    name: 'cart',
    data() {
        return {
            products: null,
            formData: {
                productId: [],
                cardNumber: '',
                cvv: '',
                owner: '',
                expiryDate: ''
            }
        }
    },
    computed: {
        login() {
             return this.$store.state.login.login
        }
    },
    watch: {
        products() {
            return this.products.length
        },
        login() {
            return this.login.length
        }
    },
    methods: {
        makeOrder() {
            axios.post('/api/orders', this.formData)
        }
    },
    created() {
        // console.log('Cart component')
        
        // setTimeout(() => {console.log(this.login.data)}, 3000)
        // console.log(loginId)
        if(this.login.data){
            const loginId = this.login.data.id
            axios.get(`/api/carts/${loginId}/products`)
                .then(response => {
                    this.products = response.data.products
                })
        }else {
            this.$router.push('/login')
        }
        
        // setTimeout(() => {
        //         if(!this.login) {
        //             console.log('aaaaaaa')
        //             return;
        //         }else {
        //         axios.get(`/api/carts/${this.login.data.id}/products`)
        //             .then(res => {
        //                 this.products = res.data.products
        //         })
        //     }
        // }, 1000) 
        
    } 
}
</script>