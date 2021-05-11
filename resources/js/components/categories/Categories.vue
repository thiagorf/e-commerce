<template>
    <div>
        <ActionSelect
            @creating="create"
            @searching="search"
        ></ActionSelect>
        <CreateCategories v-if="isCreating"></CreateCategories>
        <ShowCategories v-if="isSearching"></ShowCategories>
    </div>
</template>

<script>
import ActionSelect from './../ActionSelect.vue'
import CreateCategories from './CreateCategories.vue'
import ShowCategories from './ShowCategories.vue'

export default {
    name: 'Categories',
    data() {
        return {
            isCreating: null,
            isSearching: null
        }
    },
    
    components: {
        ActionSelect,
        CreateCategories,
        ShowCategories
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