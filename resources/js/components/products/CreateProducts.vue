<template>
    <div>
        <form>
            <input type="text" name="name" v-model="formData.name">
            <input type="text" name="description" v-model="formData.description">
            <input type="text" name="price" v-model="formData.price">
            <h3>Escolha as categorias</h3>
            <div v-if="categories">
                <div
                    v-for="(category, index) in categories" 
                    :key="index"
                >
                    <input type="checkbox" 
                        :name="category.tag"
                        :id="category.tag"
                        :value="category.id"
                        v-model="formData.checkData"
                    >
                    <label :for="category.tag">{{category.tag}}</label>
                </div>
                
            </div>
            <button type="submit" @click.prevent="submitProduct">Create</button>
        </form>
    </div>   
</template>
<script>
export default {
    name: 'Createproducts',
    data() {
        return {
            formData: {
                name: '',
                description: '',
                price: '',
                checkData: []
            },
            categories: null
        }
    }, 
    watch: {
        categories() {
            return this.categories.length
        }
    },
    methods: {
        submitProduct () {
            axios.post('api/products', this.formData).then( response => {
                console.log(response.data.message)
                this.$router.push('/products');
            })
        }
    },
    beforeCreate() {
        axios.get('/api/categories').then(response => {
            this.categories = response.data.categories
        })
    }
    
}
</script>