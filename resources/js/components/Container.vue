<template>
    <div> 
        <div class="nav-bar">
            <div class="links">
                <router-link to="/">Home</router-link>

                <router-link to="/cart"><font-awesome-icon :icon="['fas', 'shopping-cart']" /></router-link>
                <router-link to="/favorite"><font-awesome-icon :icon="['fas', 'heart']" /></router-link>
                    <button 
                        v-if="isLogged.data" 
                        @click="profileModal = !profileModal" 
                        ref="dropdown"
                        :class="{dropdown: profileModal}"
                    >
                        <font-awesome-icon :icon="['fas', 'user']" />
                    </button>
                        <div class="popUp"  v-if="profileModal">
                            <router-link v-if="role" to="/dashboard">Dashboard</router-link>
                            <button @click="logout">Sair</button>
                        </div>
                <router-link v-if="!isLogged.data" to="/login">Login</router-link>
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
        showModal() {
            this.profileModal = !this.profileModal
        },
        close(e) {
            let el = this.$refs.dropdown
            let target = e.target
            if(el) {
                if ((el !== target) && !el.contains(target)) {
                    this.profileModal = false
                }
            }
        },
        logout() {
            axios.get('/api/logout').then(res => {
                this.$store.commit('SET_ROLE', null)
                this.login()
                this.favorite()
                this.profileModal = false
                if(!(this.$route.path == '/')) {
                    this.$router.push('/')
                }
            }).catch(err => {
                console.log(err)
            })
        },
    },
    created() {
        console.log('Container component')
        document.addEventListener("click", this.close)
        this.checkRole()
        this.login()
    },
    destroyed() {
        document.removeEventListener("click", this.close)
    }
}
</script>
<style lang="scss">

@import'./../../sass/base';
@import './../../sass/variables';

.nav-bar {
    margin: 5px auto 5px auto;
    padding: 5px 0;
    .links {
        position: relative;
        display: flex;
        width: 84.5%;
        height: 100%;
        justify-content: space-between;
        margin: 0 auto;
        border-bottom: 1px solid rgb(218, 149, 149);
    }
    .links a, .links button {
        padding: 3px;
    }
    .links a.router-link-exact-active {
        background: rgb(218, 149, 149);
    }
    .links a.router-link-exact-active:first-child {
        background: rgb(218, 149, 149);
        border-top-left-radius: 3px;
    }
    .links a.router-link-exact-active:last-child {
        background: rgb(218, 149, 149);
        border-top-right-radius: 3px;
    }
}

.popUp {
    position: absolute;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    background: $border-color;    
    border-radius: 3px 0 3px 3px;
    z-index: 60;
    padding: 5px;
    width: 100px;
    height: 80px;
    top: 24px;
    right: 0;
}
.dropdown {
    background: rgb(218, 149, 149);
    border-top-right-radius: 3px;
}
</style>