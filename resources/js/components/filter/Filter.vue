<template>
    <div class="filtre-wrapper">
        <div class="filter-title">فیلترها</div>
        <div class="filter-list-wrapper">
            <ul class="filter-list mt-4 px-0" v-if="categories">
                <li>
                    <MultiSelect
                        :title="{ english: 'brand', persian: 'برند' }"
                        :options="brands"
                        @checked="onCheckBrand"
                    />
                </li>
                <hr>
                <li>
                    <MultiSelect
                        :title="{ english: 'category', persian: 'دسته بندی' }"
                        :options="categories"
                        @checked="onCheckCategory"
                    />
                </li>
                <hr>
                <li>
                    <label for="categories" class="ms-3">محدوده قیمت:</label>
                    <PriceRange
                        @priceFilter="priceFilter"
                    />
                </li>
                <hr>
            </ul>
            <div v-else>
                بارگذاری...
            </div>
        </div>
    </div>
</template>

<script>
import PriceRange from "./PriceRange.vue";
import MultiSelect from "./MultiSelect.vue";

export default {
    components: { PriceRange, MultiSelect },
    data() {
        return {
            categories: null,
            products: null,
            brands: null
        }
    },
    created() {
        axios.get('api/categories').then(response => this.categories = response.data).catch(error => console.log(error));
        axios.get('api/brands').then(response => this.brands = response.data).catch(error => console.log(error));
    },
    methods: {
        categoryFilter(categories) {
            // Navigate to the appropriate route with the selected categories
            this.$router.push({ name: 'Search', query: { query: '', category: categories.join(',') } });
        },
        priceFilter(priceFrom, priceTo) {
            // Update query parameters and navigate to 'Search' page
            const queryParams = { ...this.$route.query, price_from: priceFrom, price_to: priceTo };
            this.$router.push({ name: 'Search', query: queryParams });
        },
        brandFilter(brands) {
            // Navigate to the appropriate route with the selected brand
            const queryParams = { ...this.$route.query, brand: brands.join(',') };
            this.$router.push({ name: 'Search', query: queryParams });
        },
        onCheckBrand(brands) {
            this.brandFilter(brands);
        },
        onCheckCategory(categories) {
            this.categoryFilter(categories);
        }
    }
}
</script>

<style scoped>
    .filtre-wrapper {
        width: 20%;
        border: 1px solid #d5d8df;
        border-radius: 10px;
        padding: 16px 20px;
        margin-left: 20px;
    }
    .filter-list {
        list-style-type: none;
    }
</style>
