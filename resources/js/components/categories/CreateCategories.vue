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
<style lang="scss" scoped>
@import './../../../sass/variables';
div {
    width: 84.5%;
    margin: 0 auto;

    form {
        display: flex;
        width: 100%;
        border: 1px solid $border-color;
        border-radius: 5px;
        margin-bottom: 5px;
    }
    input {
        width: 75%;
        border: 0;
        border-radius: 5px 0 0 5px;
    }
    button {
        width: 25%;
        height: 100%;
        background: $button-color;
        border-left: 1px solid $border-color;
        border-radius: 0 5px 5px 0;
    }
}
</style>