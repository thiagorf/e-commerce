const EMAIL_REGEX = /^[a-z0-9]+@[a-z]+\.+[a-z]/i
const PASSWORD_REGEX = /[a-z0-9]/i
const NAME_REGEX = /[a-z0-9]/i
const validationMixin = {
    data() {
        //var self = this;
        return {
            validate: {
                email: (value) => {

                    return this.verifyRegex(EMAIL_REGEX, value, 'email')
                },
                password: (value) => {
                    return this.verifyRegex(PASSWORD_REGEX, value, 'password')
                },
                name: (value) => {
                    return this.verifyRegex(NAME_REGEX, value , 'name')
                }
            }
        }
    },
    methods: {
        verifyRegex(regex, value, inputName) {
            if(value == ''){
                return this.erros[inputName] = 'O campo não pode ficar vazio'
            }
            if(regex.test(value)) {
                this.erros[inputName] = ''
                console.log(this.erros[inputName])
                return regex.test(value)
            }else {
                return this.erros[inputName] = `${inputName} invalido`
                
            }
        },
        verify(event, inputName) {
            let value = event.target.value
            this.validate[inputName](value)
        },
        /*
        validateEmail(event) {
            let value = event.target.value
            this.validate.email(value)
        },
        validatePassword(event) {
            let value = event.target.value
            this.validate.password(value)
        },
        validateName(event) {
            let value = event.target.value
            this.validate.name(value)
        },*/
        validateForm(value) {
            let form = {}
            let formIsValid = true
            console.log(value)
            for (const input in value) {
                const erros = this.validate[input](value[input])
                
                if(erros.length) {
                    formIsValid = false
                }
                console.log(erros)
                console.log(erros.length)
                form[input] = erros
            }
            form.formIsValid = formIsValid
            console.log(form)
            return form
        },
    }
}

export default validationMixin;