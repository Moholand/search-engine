<template>
    <Header />
    <router-view></router-view>
</template>

<script>
import Header from "./components/Header/Header.vue";

export default {
    components: { Header },
}
</script>
