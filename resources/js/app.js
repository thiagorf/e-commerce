/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


//window.Vue = require('vue').default;
import Vue from 'vue'

//import router from './routes/router.js'
import router from './routes/routes.js'
import store from './store/store.js'

import Container from './components/Container.vue'

//import { library } from '@fortawesome/vue-fontawesome-svg-core'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faUser, faHeart, faShoppingCart, faTrash, faPen, faSearch } from '@fortawesome/free-solid-svg-icons'
import { faHeart as farHeart } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faUser, faHeart, farHeart, faShoppingCart, faTrash, faPen, faSearch)
Vue.component('font-awesome-icon', FontAwesomeIcon)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({  
    router,
    store,
    components: { Container}
}).$mount("#app");
