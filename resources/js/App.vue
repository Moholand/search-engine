<template>
    <Header v-if="['login', 'register'].indexOf($route['name']) === -1"/>
    <router-view></router-view>
</template>

<script>
import Header from "./components/Header/Header.vue";

export default {
    components: { Header },
}
</script>
