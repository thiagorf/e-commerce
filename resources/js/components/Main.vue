<template>
    <div class="container">
        <ProductFilter @sortData="notifyComponent"/>
        <Content :sort="sortData" />
    </div>
</template>
<script>
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
            this.sortData = value
        },
    },
   components: {
        ProductFilter,
        Content
    },
}
</script>
<style lang="scss" scoped>
 
h1 {
    font-size: 5em;
}
</style>