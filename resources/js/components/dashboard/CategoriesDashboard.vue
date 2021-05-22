<template>
    <div>
        <div v-if="categories">
            <div v-if="deletTag.form">
                <h1>Tem certeza que quer excluir</h1>
                <button @click="deleteCategory">Sim</button><button @click="cancelModal">Não</button>
            </div>
            <div v-if="showEditModal">
                <input type="text" v-model="editCategory.tag">
                <button @click="updateCategory(editCategory.id)">Atualizar</button>
                <button @click="showEditModal = false">Cancelar</button>
            </div>
            <CreateCategories @updatedCategories="getCategories"/>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(category, index) in categories" :key="index">
                            <td><input type="text" :value="category.tag"></td>
                            <td><button @click="editModal(category.id)">Edit</button></td>
                            <td><button @click="showModal(category.id, category.name)">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
        <div v-else>
            <Spinner />
        </div>
    </div>
</template>
<script>
import CreateCategories from './../categories/CreateCategories.vue'
import Spinner from './../Spinner'
export default {
    name: 'CategoriesDashboard',
    data() {
        return {
            categories: null,
            formData: {
                tag: ''
            },
            deletTag: {
                form: false,
                tagId: '',
                tagName: ''
            },
            editCategory: null,
            showEditModal: false
        }
    },
    watch: {
        categories() {
            return this.categories.length
        }
    },
    methods: {
        updateCategory(id){
            axios.put(`/api/categories/${id}`, this.editCategory)
                .then(response => {
                    this.showEditModal = false
                    this.getCategories()
                })
        },
        editModal(id) {
            axios.get(`/api/categories/${id}`)
                .then(response => {
                    this.editCategory = response.data.category
                    this.showEditModal = true
                })
        },
        showModal(id, tagName){
            this.deletTag.form = true
            this.deletTag.tagId = id
            this.deletTag.tagName = tagName
        },
        deleteCategory() {
            const id = this.deletTag.tagId
            axios.delete(`/api/categories/${id}`)
                .then(response => {
                    this.getCategories()
                })
        },
        cancelModal() {
            this.deletTag.form = false
        },
        getCategories() {
            axios.get('/api/categories')
            .then(response => {
                this.categories = response.data.categories
            })
        }
    },
    created() {
        this.getCategories()
        
    },
    components: {
        CreateCategories,
        Spinner
    }
}
</script>
<style lang="scss" scoped>
@import './../../../sass/table';
table {
    display: table;
    input {
        width: 100%;
    }
}
</style>