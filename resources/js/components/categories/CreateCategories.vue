<template>
    <div>
        <form action="" method="POST">
            <input type="text" name="tag" v-model="formData.tag">
            <button type="submit" @click.prevent="createCategory">Criar</button>
        </form>
    </div>
</template>
<script>
import {mapActions} from 'vuex'
import {SET_CATEGORIES} from './../../store/modules/mutations-type'

export default {
    name: 'CreateCategory',
    data() {
        return {
            formData: {
                tag: ''
            }
            
        }
    },
    methods: {
        ...mapActions({
            setCategories: SET_CATEGORIES 
        }),
        createCategory() {
            axios.post('/api/categories', this.formData).then(response => {
                console.log(response)
                this.setCategories()
                this.$emit('updatedCategories')
            })
        }
    }
}
</script>