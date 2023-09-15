<template>
    <div class="home-page">
        <div class="categories d-flex justify-content-center">
            <div class="category-item" v-for="category in categories">
                <router-link :to="{ name: 'Search', query: { category: category.name} }"
                             class="d-flex flex-column align-items-center text-decoration-none">
                    <img
                        src="https://ps.w.org/gazchaps-woocommerce-auto-category-product-thumbnails/assets/icon-256x256.png?rev=1848416"
                        width="75" height="75"
                    >
                    <span class="category-name">{{ category.name }}</span>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            categories: null
        }
    },
    created() {
        axios.get('api/categories')
            .then(response => this.categories = response.data)
            .catch(error => console.log(error));
    }
}
</script>

<style scoped>
    .home-page {
        margin: 0 80px;
        padding: 20px 0;
    }
    .category-item {
        margin: 0 40px;
        cursor: pointer;
    }
    .category-item img {
        border-radius: 50%;
    }
    .category-name {
        font-size: 13px;
        margin-top: 5px;
        font-weight: 300;
        color: #333333;
    }
</style>
