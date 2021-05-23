<template>
    <div class="wrapper">
        <form enctype="multipart/form-data">
            <input type="text" name="name" v-model="formData.name" placeholder="Nome">
            <input type="text" name="description" v-model="formData.description" placeholder="Descrição">
            <input type="text" name="price" v-model="formData.price" placeholder="Preço">
            <div v-if="categories" class="categories-wrapper">
                <h3>Escolha as categorias</h3>
                <div
                    v-for="(category, index) in categories" 
                    :key="index"
                >
                    <input type="checkbox" 
                        :name="category.tag"
                        :id="category.tag"
                        :value="category.id"
                        v-model="formData.tags"
                    >
                    <label :for="category.tag">{{category.tag}}</label>
                </div>
            </div>
            <input type="file" name="productImage" @change="fileStore($event)">
            <button type="submit" @click.prevent="submitProduct">Criar</button>
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
                tags: [],
                productImage: null
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
        fileStore(event) {
            this.formData.productImage = event.target.files[0]
        },
        submitProduct () {
            let data = new FormData();
            data.append("name", this.formData.name)
            data.append("description", this.formData.description)
            data.append("price", this.formData.price)
            this.formData.tags.forEach(element => {
                data.append("tags[]", element)
            });
            data.append("productImage", this.formData.productImage)
            console.log(data)
            axios.post('/api/products', data, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })
            .then( response => {
                console.log(response.data.message)
                //this.$router.push('/products');
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
<style lang="scss" scoped>
@import './../../../sass/productsForm';
</style>