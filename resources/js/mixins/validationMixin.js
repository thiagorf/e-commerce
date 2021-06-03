import {EMAIL_REGEX, PASSWORD_REGEX, NAME_REGEX, DESCRIPTION_REGEX, PRICE_REGEX} from './validation-types'

const validationMixin = {
    data() {
        return {
            validate: {
                email: (value) => {
                    return this.verifyRegex(EMAIL_REGEX, value, 'email')
                },
                password: (value) => {
                    return this.verifyRegex(PASSWORD_REGEX, value, 'password')
                },
                name: (value) => {
                    return this.verifyRegex(NAME_REGEX, value , 'name','nome')
                },
                description: (value) => {
                    return this.verifyRegex(DESCRIPTION_REGEX, value, 'description', 'descrição')
                },
                price: (value) => {
                    return this.verifyRegex(PRICE_REGEX, value, 'price', 'preço')
                }
            }
        }
    },
    methods: {
        verifyRegex(regex, value, propriety, inputName = '') {
            if(!inputName) inputName = propriety
            if(value == ''){
                return this.erros[propriety] = 'O campo não pode ficar vazio'
            }
            if(regex.test(value)) {
                this.erros[propriety] = ''
                return regex.test(value)
            }else {
                return this.erros[propriety] = `${inputName} invalido`
                
            }
        },
        verify(event, inputName) {
            let value = event.target.value
            this.validate[inputName](value)
        },
        validateForm(value) {
            let form = {}
            let formIsValid = true
            for (const input in value) {
                const erros = this.validate[input](value[input])
                
                if(erros.length) {
                    formIsValid = false
                }
                form[input] = erros
            }
            form.formIsValid = formIsValid
            return form
        },
    }
}

export default validationMixin;