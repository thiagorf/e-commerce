<template>
    <div>
        <input type="text" placeholder="search..." v-model="searchSort">
        <div v-if="categories">
            <div 
                v-for="category in categories" 
                :key="category.id">
                <input 
                    type="checkbox"
                    :id="category.tag" 
                    :value="category.tag" 
                    v-model="tags"
                >
                <label 
                    :for="category.tag"
                    v-text="category.tag"
                >
                </label>
            </div>
            <button @click="sort">Apply filter</button>
        </div>
    </div>
</template>
<script>
import {mapActions} from 'vuex'
import {SET_TAGS} from './../store/modules/mutations-type'
let i = 0
let tag = 'tags[]='
export default {
    name: 'searchfilter',
    data() {
        return {
            categories: null,
            searchSort: ''
        }
    },
    computed: {
        tags: {
            get() {
                return this.$store.state.sort.tags
            },
            set(value) {
                this.$store.commit('SET_TAGS', value)
            }
            
        },
        queryString: {
            get() {
                return this.$store.state.sort.query
            },
            set(value) {
                this.$store.commit('SET_QUERY', value)
            }
        }
    },
    watch: {
        categories() {
            return this.categories.length
        },
        queryString() {
            return this.queryString.length
        },
        tags() {
            return this.tags.length
        }
    },
    methods: {
        ...mapActions({
            sorts: SET_TAGS
        }),
        sort () {
            //refatorar
            //incluir as variaveis aqui *tentar
            console.log(this.searchSort)
            console.log(this.tags.length)
            if (this.searchSort && !(this.tags.length == 0)) {
                this.queryString += `sort=${this.searchSort}&`
            }else if(this.searchSort) {
                this.queryString += `sort=${this.searchSort}`
            }
            for(i; i < this.tags.length; i++){
                if(!((i + 1) === this.tags.length)) {
                    this.queryString += tag + this.tags[i] + '&'
                }else {
                    this.queryString += tag + this.tags[i]
                }    
            }
            i = 0
            this.sorts(`?${this.queryString}`)
            this.queryString = ""
            this.searchSort = ""
        },
    },
    beforeCreate: function() {
        axios.get('/api/categories')
            .then(response => {
                this.categories = response.data.categories
            })
    }
}
</script>