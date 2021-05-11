<template>
    <div class="container">
        <!--<h1>Landing Page</h1>
        <SearchFilter /> -->
        <!-- <ShowProduct /> -->
        <ProductFilter @sortData="notifyComponent"/>
        <Content :sort="sortData" />
    </div>
</template>
<script>
//import ShowProduct from './products/ShowProducts.vue'
//import SearchFilter from './SearchFilter.vue'
import Content from './Content.vue'
import ProductFilter from './ProductFilter.vue'

export default {
    name: 'Main',
    data() {
        return {
            sortData: null,
        }
    },
    watch: {
        sortData() {
            return this.sortData.length
        }
    },
    computed: {
        favorite() {
            return this.$store.state.login.favorite
        }
    },
    methods: {
        notifyComponent(value) {
            //this.$emit('changeProducts', value)
            this.sortData = value
        },
    },
   components: {
        //'ShowProduct': ShowProduct,
        //SearchFilter,
        ProductFilter,
        Content
    },
}
</script>
<style lang="scss" scoped>
 
//@import 'sass/_variables.scss';
h1 {
    font-size: 5em;
}
</style>