<template>
    <div>
        <div v-if="products" class="content">
            <div class="card" v-for="product in products" :key="product.id">
                <div class="img">
                    CONTEUDO
                </div>
                <div class=card-info>
                    <h6 v-text="product.name"></h6>
                    <p v-text="product.description"></p>
                    <span>
                        R${{product.price}},00
                    </span>
                    <button @click="removeFromFavorites(product.id)">Desfavoritar</button>
                </div>
            </div>
            <!--<p
            v-for="product in products" :key="product.id"
            v-text="product.name"
            >
            </p> -->
        </div>
        <div v-else>
            <Spinner />
        </div>
    </div>
</template>
<script>
import Spinner from './Spinner'
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
    methods: {
        async getFavorite() {
            await this.$store.dispatch('SET_FAVORITE') 
            if(this.favorite.data){
                axios.get(`/api/favorites/${this.favorite.data.id}/products`)
                    .then(response => {
                        this.products = response.data.products
                    })
            }else {
                this.$router.push('/login')
            }
        },
        removeFromFavorites(id) {
            const favoriteId = this.favorite.data.id
            axios.delete(`/api/favorites/${favoriteId}/products`, {
                data: id
            })
            .then(response => {
                //possivelmente o component message entraria aqui
                console.log(response.data.message)
                this.getFavorite()
            })
        }
    },
    created() {
        this.getFavorite()
    },
    components: {
        Spinner
    }

}
</script>
<style lang="scss" scoped>
@import './../../sass/grid';
p {
    overflow-x: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
</style>