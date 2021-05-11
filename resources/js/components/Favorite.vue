<template>
    <div>
        <div v-if="products">
            <p
            v-for="product in products" :key="product.id"
            v-text="product.name"
            >
            </p>
        </div>
        <div v-else>
            <p>É necessário fazer login para acessar os favoritos</p>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Favorite',
    data() {
        return {
            products: null
        }
    },
    watch: {
        products() {
            return this.products.length
        },
        favorite(){
            return this.favorite.length
        }
    },
    computed: {
        favorite() {
            return this.$store.state.login.favorite
        },
        //Entaria aqui o state favoriteProduct
        favoriteProduct: {
            get() {
                return this.$store.state.favoriteProduct
            },
            set(value) {
                this.$store.commit('SET_FAVORITE_PRODUCT', value)
            }
        }
    },
    created() {
        console.log(this.favorite.data)
        
        if(this.favorite.data){
            axios.get(`/api/favorites/${this.favorite.data.id}/products`)
                .then(response => {
                    this.products = response.data.products
                })
        }else {
            this.$router.push('/login')
        }
        // setTimeout(() => {
        //     if(this.favorite.data == 'Define favorites relantionship') {
        //         console.log(this.favorite)
        //         return;
        //     }else {
        //         axios.get(`/api/favorites/${this.favorite.data.id}/products`)
        //                 .then(response => {
        //                     this.products = response.data.products
        //                     //[T01] Alternativa aos produtos
        //                     //this.favoriteProduct = response.data.products
        //                 })
        //     }
        // }, 1500) 
    }
}
</script>