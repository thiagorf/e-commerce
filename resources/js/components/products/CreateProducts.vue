<template>
    <div class="wrapper">
        <div class="modal-content">
            <form enctype="multipart/form-data" @submit.prevent="checkForm">
                <h1>Cadastro de Produto</h1>
                <div class="field">
                    <label for="name">Nome</label>
                    <p v-if="erros.name" v-text="erros.name"></p>
                    <input type="text" id="name" name="name" v-model="formData.name" placeholder="Nome" @blur="verify($event, 'name')">
                </div>
                <!--
                <div class="field">
                    <label for="description">Descrição</label>
                    <textarea name="description" id="description" cols="30" rows="10">

                    </textarea>
                </div> -->
                <div class="field">
                    <label for="descricao">Descrição</label>
                    <p v-if="erros.description" v-text="erros.description"></p>
                    <input type="text" id="descricao" name="description" v-model="formData.description" placeholder="Descrição" @blur="verify($event, 'description')">
                </div>
                <div class="field">
                    <label for="price">Preço</label>
                    <p v-if="erros.price" v-text="erros.price"></p>
                    <input type="text" id="price" name="price" v-model="formData.price" placeholder="Preço" @blur="verify($event, 'price')">
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
                <input type="file" name="productImage" id="file" @change="fileStore($event)">
                <label for="file">
                    <font-awesome-icon :icon="['fas', 'file-upload']" />
                    {{ imageName || 'Escolha um arquivo' }}
                </label>
                <button type="submit">Criar</button>
            </form>
        </div>
    </div>   
</template>
<script>
import validationMixin from './../../mixins/validationMixin'

export default {
    name: 'Createproducts',
    mixins: [validationMixin],
    data() {
        return {
            formData: {
                name: '',
                description: '',
                price: '',
                tags: [],
                productImage: null
            },
            erros: {
                name: '',
                description: '',
                price: ''
            },
            categories: null,
            imageName: '',
            
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
        checkForm() {
            const isValid = this.validateForm(this.formData)
            if(isValid.formIsValid) {
                console.log('Axios...')
            }
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