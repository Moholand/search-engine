<template>
    <Header />
    <div class="products">
        <div class="products-wrapper d-flex">
            <Filter @filterOn="filterOn" />
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import Header from "./components/Header/Header.vue";
import Filter from "./components/filter/Filter.vue";

export default {
    components: { Header, Filter },
}
</script>
