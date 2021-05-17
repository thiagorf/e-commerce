<template>
    <div> 
        <div class="nav-bar">
            <div class="links">
                <router-link to="/">Home</router-link>

                    <button v-if="isLogged.data" @click="showProfile">Porfile</button>
                    <div v-if="profileModal" class="popUp">
                        <button @click="profileModal = false">Fechar</button>
                        <router-link v-if="role" to="/dashboard">Dashboard</router-link>
                        <button @click="logout">Sair</button>
                    </div>

                <!--
                <div v-if="isLogged.data">
                    <button @click="showProfile">Porfile</button>
                    <div v-if="profileModal">
                        <button @click="profileModal = false">Fechar</button>
                        <div v-if="role">
                            <router-link to="/dashboard">Dashboard</router-link>
                        </div>
                        <button @click="logout">Sair</button>
                    </div>
                </div>-->
                <router-link v-if="!isLogged.data" to="/login">Login</router-link>
                <!-- <router-link to="/register">Register</router-link> -->
                <router-link to="/cart">Cart</router-link>
                <router-link to="/favorite">Favorite</router-link>
            </div>
        </div>
            <router-view></router-view>
    </div>
</template>
<script>
import {mapActions} from 'vuex'
import {SET_LOGIN, SET_FAVORITE, SET_FAVORITE_PRODUCT, SET_ROLE} from './../store/modules/mutations-type'
export default {
    name: 'Container',
    data() {
        return {
            profileModal: false
        }
    },
    //watch: {
    //   role() {
    //        console.log(this.haveAccess)
    //        return this.haveAccess.length
    //    }        
    //},
    computed: {
        role() {
            return this.$store.state.login.role
        },
        isLogged() {
            return this.$store.state.login.login
        }
    },
    methods: {
        ...mapActions({
            login: SET_LOGIN,
            favorite: SET_FAVORITE,
            favoriteProducts: SET_FAVORITE_PRODUCT,
            checkRole: SET_ROLE
        }),
        logout() {
            axios.get('/api/logout').then(res => {
                console.log(res)
                this.$store.commit('SET_ROLE', null)
                this.login()
                this.favorite()
                this.profileModal = false
                if(!(this.$route.path == '/')) {
                    this.$router.push('/')
                }
                //this.$router.push('/');
            }).catch(err => {
                console.log(err)
            })
        },
        showProfile() {
            this.profileModal = true
        }
    },
    created() {
        console.log('Container component')
        this.checkRole()
        this.login()
    },
    updated() {
       
    }
}
</script>
<style lang="scss">

@use './../../sass/base';

.nav-bar {
    margin: 5px auto 5px auto;
    .links {
        position: relative;
        display: flex;
        width: 84.5%;
        height: 100%;
        justify-content: space-between;
        margin: 0 auto;
        border-bottom: 1px solid rgb(218, 149, 149);
    }
    .links a {
        padding: 3px;
    }
    .links a.router-link-exact-active {
        background: rgb(218, 149, 149);
    }
    padding: 5px 0;
}

.popUp {
    position: absolute;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    background: #FFF;    
    z-index: 60;
    padding: 5px;
    width: 100px;
    height: 80px;
    top: 16px;
    left: 28%;
}
</style>