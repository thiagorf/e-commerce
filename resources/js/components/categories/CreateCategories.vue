<template>
    <div class="wrapper">
        <form action="">
            <h1>Crie sua Categoria</h1>
            <p v-if="erros.tag" v-text="erros.tag"></p>
            <div class="field">
                <label for="tag">Categoria</label>
                <input type="text" name="tag" id="tag" v-model="formData.tag">
            </div>
            <button type="submit" @click.prevent="checkIfCategoryExist">Criar</button>
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
            },
            erros: {
                tag: ''
            }
            
        }
    },
    methods: {
        ...mapActions({
            setCategories: SET_CATEGORIES 
        }),
        checkIfCategoryExist() {
            let tag = this.formData.tag
            axios.get(`/api/categories?tag=${tag}`)
                .then(response => {
                   if(response.data) {
                       this.erros.tag = 'Essa Categoria ja existe'
                   }else {
                       this.erros.tag = ''
                       this.createCategory()
                   }
                })
        },
        createCategory() {
            axios.post('/api/categories', this.formData).then(response => {
                console.log(response)
                //this.setCategories()
                this.$emit('updatedCategories')
            })
        }
    }
}
</script>
<style lang="scss" scoped>
@import './../../../sass/variables';
@import './../../../sass/productsForm';

/*.wrapper {
    position: absolute;
    top: 20%;
    z-index: 9999;
    width: 84.5%;
}
div {
    width: 84.5%;
    margin: 0 auto;

    form {
        display: flex;
        flex-direction: column;
        background: #FFE9DE;
        width: 100%;
        margin: 0 auto;
        max-width: 350px;
        padding: 10px;
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
}*/
</style>