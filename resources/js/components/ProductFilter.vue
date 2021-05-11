<template>
   <div>
       <div v-if="categories" class="sort-content">
           <div class="sort-search">
                <input type="text" v-model="formData.sort" placeholder="Procure algo...">
                <button @click="apllySort">Procurar</button>
           </div>
           <div class="tags-selection">
                <div v-for="(category, index) in categories" :key="index">
                    <input type="checkbox" 
                        :value="category.tag"
                        :id="category.tag"
                        v-model="formData.tags"
                    >
                    <label 
                        :for="category.tag"
                        v-text="category.tag"
                    >
                    </label>
                </div>
            </div>
       </div>
       <div v-else>
           Carregando...
       </div>
   </div> 
</template>
<script>
export default {
   name:"ProductFilter",
   data() {
       return {
           categories: null,
           formData: {
               sort: '',
               tags: []
           }
       }
   }, 
   watch: {
       categories() {
           return this.categories.length
       }
   },
   methods: {
       apllySort() {
           const sortStructure = 'sort='
           const tagsStructure = 'tags[]='
           const tags = this.formData.tags
           const sort = this.formData.sort
           let query = ''
           
           if((sort !== '' && tags.length !== 0)) {
               query += sortStructure + sort + '&'
               for (let i = 0; i < tags.length; i++) {
                   if(!((i + 1) == tags.length)) {
                       query += tagsStructure + tags[i] + '&'
                   }else {
                      query += 'tags[]=' + tags[i]
                   }
               }
           } else if(sort) {
               query += sortStructure + sort
           } else {
               for (let i = 0; i < tags.length; i++) {
                   if(!((i + 1) == tags.length)) {
                       query += tagsStructure + tags[i] + '&'
                   }else {
                      query += 'tags[]=' + tags[i]
                   }
               }
           }

           this.$emit('sortData', query)
           query = ''
           //if(this.formData.tags.length > 0) {

           //} 
           //this.$emit('queryString', )
       },
       // Testar a refatoração
       queryStructure() {
            for (let i = 0; i < tags.length; i++) {
                if(!((i + 1) == tags.length)) {
                    query += tagsStructure + tags[i] + '&'
                }else {
                    query += 'tags[]=' + tags[i]
                }
            }
       }
   },
   beforeCreate() {
       axios.get('/api/categories')
            .then(response => {
                this.categories = response.data.categories
            })
   }
}
</script>
<style lang="scss" scoped>

.sort-content {
    .sort-search button {
        align-self: flex-end;
        font-weight: 800;
        height: 100%;
        width: 25%;
        background: #f8ceb9;
        border-radius: 0 5px 5px 0;
    }
    .sort-search input {
        width: 75%;
        border: 0;
        border-right: 1px solid rgb(218, 149, 149);
        border-radius: 5px 0 0 5px;
    }
    display: flex;
    margin: 0 auto;
    //flex-direction: column;
    flex-wrap: wrap;
    width: 84.5%;
    //height: 100px;
    //border: 1px solid black;
    //border: 1px solid rgb(218, 149, 149);
}

.tags-selection {
    div input[type="checkbox"] {
        display: none;
    }

    div input[type="checkbox"] + label::before{
        content: "";
        display: inline-block;
        vertical-align: middle;
        margin-right: 1px;
        width: 13px;
        height: 13px;
        border: 1px solid rgb(218, 149, 149);
        border-radius: 3px;
    }
    div input[type="checkbox"]:checked + label::before {
        content: "";
        display: inline-block;
        width: 13px;
        height: 13px;
        background: rgb(224, 140, 140);
        border: 1px solid rgb(218, 149, 149);
        border-radius: 3px;
    }
    display: flex;
    flex-direction: column;
    flex-basis: 100%;
    flex: 1;
}

.sort-search {
    border: 1px solid rgb(218, 149, 149);
    display: flex;
    width: 100%;
    border-radius: 5px;
}
</style>