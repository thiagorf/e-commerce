<template>
    <div>
        <div v-if="products" class="content">
            <div class="card" v-for="product in products" :key="product.id">
                <div class="img">
                    CONTEUDO
                    <div class="fav-layer" @click="removeFromFavorites(product.id)">
                        <font-awesome-icon :icon="['fas', 'heart']" class="fav-wrapper"/>
                    </div>
                </div>
                <div class=card-info>
                    <h6 v-text="product.name"></h6>
                    <p v-text="product.description"></p>
                    <span>
                        R${{product.price}},00
                    </span>
                    <button @click="showMore(product.id)">Ver Mais</button>
                </div>
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
    name: 'Favorite',
    data() {
        return {
            products: null,
            formData: {
                id: ''
            }
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
            console.log(id)
            this.formData.id = id
            const favoriteId = this.favorite.data.id
            axios.delete(`/api/favorites/${favoriteId}/products`, {
                data: this.formData
            })
            .then(response => {
                //possivelmente o component message entraria aqui
                console.log(response.data.message)
                this.getFavorite()
            })
        },
        showMore(id) {
            this.$router.push({name: 'products', params: {id: id}})
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