<template>
    <div>
        <div v-if="message" >
            <h2 v-text="messageInterval"></h2>
        </div>
    </div>
</template>
<script>
export default {
    name: 'message',
    props: {
        testMessage: String
    },
    data: function() {
        return {
            message: ''
        }
    },
    computed: {
        messageInterval() {
            setTimeout(() => {
                console.log(this.message)
                this.message = ''
                //cria um evento personalizado para o component pai escutar
                this.$emit('notifyComponent')
                console.log(this.message)
            }, 1500)
            
            return this.message
        }
    },
    watch: {
        testMessage(propsValue) {
           this.message = propsValue
        },
    },
    // mounted() {
    //     this.message = this.testMessage
    // }
    
}
</script>