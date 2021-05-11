<template>
    <div>
        <div v-if="deletTag.form">
            <h1>Tem certeza que quer excluir</h1>
            <button @click="deleteCategory">Sim</button><button @click="cancelModal">Não</button>
        </div>

        <CreateCategories @updatedCategories="getCategories"/>
        <div v-if="categories">
            <table>
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <!-- <th>Editar</th> -->
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(category, index) in categories" :key="index">
                        <td><input type="text" :value="category.tag" @blur="editCategory(category.id, $event)"></td>
                        <!-- <td><button @click="editCategory(category.id)">Edit</button></td> -->
                        <td><button @click="showModal(category.id, category.name)">Delete</button></td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</template>
<script>
import CreateCategories from './../categories/CreateCategories.vue'
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
            }
        }
    },
    watch: {
        categories() {
            return this.categories.length
        }
    },
    methods: {
        editCategory(id, e){
            this.formData.tag = e.target.value
            const data = this.formData

            axios.put(`/api/categories/${id}`, data)
                .then(response => {
                    console.log(response.data.message)
                })
        },
        // Pensar na paginação de cada dashboard
        showModal(id, tagName){
            this.deletTag.form = true
            this.deletTag.tagId = id
            this.deletTag.tagName = tagName
        },

        deleteCategory() {
            const id = this.deletTag.tagId
            axios.delete(`/api/categories/${id}`)
                .then(response => {
                    console.log(response.data.message)
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
        CreateCategories
    }
}
</script>