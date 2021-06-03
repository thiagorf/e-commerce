<template>
    <div>
        <div v-if="categories">
            <div v-if="deleteTag.form">
                <h1>Tem certeza que quer excluir</h1>
                <button @click="deleteCategory">Sim</button><button @click="cancelModal">Não</button>
            </div>
            <div v-if="showEditModal">
                <input type="text" v-model="editCategory.tag">
                <button @click="updateCategory(editCategory.id)">Atualizar</button>
                <button @click="showEditModal = false">Cancelar</button>
            </div>
            <div class="createCategory">
                <button @click="createModal = true" class="align-icon">
                    <font-awesome-icon :icon="['fas', 'plus']"/>
                    Adicionar
                </button>
                
                <div class="blur-wrapper" v-if="createModal">
                    <button @click="createModal = false"><font-awesome-icon :icon="['fas', 'times']"/></button>
                </div>
                <CreateCategories @updatedCategories="getCategories" v-if="createModal"/>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Categoria</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(category, index) in categories" :key="index">
                            <td data-label="Id" v-text="category.id"></td>
                            <td data-label="Categoria" v-text="category.tag"></td>
                            <td data-label="Ações">
                                <font-awesome-icon @click="editModal(category.id)" :icon="['fas', 'pen']"/>
                                <font-awesome-icon @click="showModal(category.id, category.name)" :icon="['fas', 'trash']"/>
                            </td>
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
            deleteTag: {
                form: false,
                tagId: '',
                tagName: ''
            },
            editCategory: null,
            showEditModal: false,
            createModal: false
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
            this.deleteTag.form = true
            this.deleteTag.tagId = id
            this.deleteTag.tagName = tagName
        },
        deleteCategory() {
            const id = this.deleteTag.tagId
            axios.delete(`/api/categories/${id}`)
                .then(response => {
                    this.deleteTag.form = false
                    this.getCategories()
                })
        },
        cancelModal() {
            this.deleteTag.form = false
        },
        getCategories() {
            this.createModal = false
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
//@import './../../../sass/table';
@import './../../../sass/table2';
@import './../../../sass/blur';
.createCategory {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    width: 84.5%;
    margin: 0 auto;
    .align-icon {
        margin-top: 10px;
        margin-bottom: 5px;
    }
}
/*table {
    display: table;
    input {
        width: 100%;
    }
}*/
</style>