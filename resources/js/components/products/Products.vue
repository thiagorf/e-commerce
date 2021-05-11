<template>
    <div>
        <ActionSelect 
            @creating="create"
            @searching="search"
            
        >
        </ActionSelect>
        <CreateProducts v-if="isCreating"></CreateProducts>
        <ShowProducts v-if="isSearching"></ShowProducts>
    </div>
    
</template>
<script>
import ActionSelect from './../ActionSelect.vue'
import CreateProducts from './CreateProducts.vue'
import ShowProducts from './ShowProducts.vue'

export default {
    name: 'Products',
    data() {
        return {
            isSearching: null,
            isCreating: null,
        }
    },
    components: {
        ActionSelect,
        CreateProducts,
        ShowProducts
    },
    methods: {
        search(sch) {
            if(!this.isSearching || this.isCreating) {
                this.isSearching = sch
                this.isCreating = false
            }
            
            
        },
        create(crt) {
            if(this.isSearching || !this.isCreating) {
                this.isCreating = crt
                this.isSearching = false
            }
            
        }
    }
    
}
</script>