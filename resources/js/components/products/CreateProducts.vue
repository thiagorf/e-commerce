<template>
    <div class="wrapper">
        <div class="modal-content">
            <form enctype="multipart/form-data">
                <h1>Cadastro de Produto</h1>
                <div class="field">
                    <label for="name">Nome</label>
                    <input type="text" id="name" name="name" v-model="formData.name" placeholder="Nome">
                </div>
                <div class="field">
                    <label for="descricao">Descrção</label>
                    <input type="text" id="descricao" name="description" v-model="formData.description" placeholder="Descrição">
                </div>
                <div class="field">
                    <label for="price">Preço</label>
                    <input type="text" id="price" name="price" v-model="formData.price" placeholder="Preço">
                </div>
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
                <p v-if="imageName" v-text="imageName"></p>
                <button type="submit" @click.prevent="submitProduct">Criar</button>
            </form>
        </div>
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
            categories: null,
            imageName: ''
        }
    }, 
    watch: {
        categories() {
            return this.categories.length
        },
        imageName() {
            return this.imageName.length
        }
    },
    methods: {
        fileStore(event) {
            console.log(event)
            this.formData.productImage = event.target.files[0]
            this.imageName = event.target.files[0].name
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

.closeModal {
    background: transparent;
}
</style>