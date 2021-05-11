<template>
    <div>
        <CreateCategories />
        <div v-if="message">

        </div>
        <table>
            <thead>
                <tr>
                    <th>tag</th>
                    <th>Action1</th>
                    <th>Action2</th>
                </tr>
            </thead>
            <tbody v-if="categories">
                <tr v-for="(category, index) in categories" :key="index">
                    <td>{{category.tag}}</td>
                    <td><button @click="editCategory(category.id)">Edit</button></td>
                    <td><button @click="deleteCategory(category.id)">Delete</button></td>
                </tr>
            </tbody>
        </table>
        {{categories}}
    </div>
</template>
<script>
import CreateCategories from './CreateCategories.vue'
import {mapActions} from 'vuex'
import {SET_CATEGORIES} from './../../store/modules/mutations-type'
export default {
    name: 'ShowCategory',
    data() {
        return {
            //categories: null,
            message: null
        }
    },
    watch: {
        categories() {
            return this.categories.length
        },
        message() {
            return this.message.length
        }
    },
    computed: {
        categories() {
            return this.$store.state.categories.categories
        }
    },
    methods: {
        ...mapActions({
            setCategories: SET_CATEGORIES 
        }),
        editCategory(id){
            console.log(id)
        },
        deleteCategory(id){
            axios.delete('/api/categories/' + id)
                        .then(res => {
                            this.meessage = res.data.message
                        })
        }
        
    },
    created() {
        this.setCategories()
        // axios.get('/api/categories').then(response => {
        //     console.log(response)
        //     this.categories = response.data.categories
        // })
    },
    components: {
        CreateCategories
    }

}
</script>