<template>
    <div>
        <div class="horizontal-bar">
            <router-link :to="{ name: 'users' }">Usuarios</router-link>
            <router-link :to="{ name: 'categories'}">Categorias</router-link>
            <router-link :to="{ name: 'orders'}">Pedidos</router-link>
            <router-link :to="{name: 'dashboardProducts'}">Produtos</router-link>
        </div>
        <router-view></router-view>
    </div>
</template>
<script>
export default {
    name: 'Dashboard',
}
</script>
<style lang="scss" scoped>

.horizontal-bar {
    display: flex;
    justify-content: space-between;
    width: 84.5%;
    margin: 0 auto;
    a {
        font-size: .75em;
    }
}
</style>
