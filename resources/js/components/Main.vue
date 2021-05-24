<template>
    <div>
        <div class="container" v-show="loading">
            <ProductFilter @sortData="notifyComponent"/>
            <Content :sort="sortData" @loadingDone="showContent"/>
        </div>
        <div v-show="!loading">
            <Spinner />
        </div>
    </div>
</template>
<script>
import Content from './Content.vue'
import ProductFilter from './ProductFilter.vue'
import Spinner from './Spinner'
export default {
    name: 'Main',
    data() {
        return {
            sortData: null,
            loading: false
        }
    },
    watch: {
        sortData() {
            return this.sortData.length
        }, 
        loading() {
            return this.loading.length
        }
    },
    computed: {
        favorite() {
            return this.$store.state.login.favorite
        }
    },
    methods: {
        notifyComponent(value) {
            this.sortData = value
        },
        showContent(value) {
            this.loading = value
        }
    },
   components: {
        ProductFilter,
        Content,
        Spinner
    },
}
</script>
<style lang="scss" scoped>
 
h1 {
    font-size: 5em;
}
</style>