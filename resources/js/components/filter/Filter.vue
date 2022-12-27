<template>
    <div class="filtre-wrapper">
        <div class="filter-title">فیلترها</div>
        <div class="filter-list-wrapper">
            <ul class="filter-list mt-4 px-0" v-if="categories">
                <li class="d-flex">
                    <label for="categories" class="ms-3">دسته‌بندی</label>

                    <select class="form-select categories-select" name="categories" id="categories" @change="filterCategory($event)">
                        <option selected>همه دسته‌ها</option>
                        <option v-for="category in categories" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </li>
                <hr>
                <li>
                    <label for="categories" class="ms-3">محدوده قیمت:</label>
                    <PriceRange />
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

export default {
    components: {PriceRange},
    data() {
        return {
            categories: null,
            products: null,
            priceFrom: null,
            priceTo: null
        }
    },
    created() {
        axios.get('api/categories')
            .then((response) => {
                this.categories = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
    },
    methods: {
        async filterCategory(event) {
            try {
                this.products = (await axios.get(`/api/products/search?query=&category=${event.target.value}`)).data;
                this.$emit('filterOn', this.products)
            } catch (error) {
                console.log(error);
            }
        },
        async priceRange() {
            try {
                this.products = (await axios.get(`/api/products/search?query=&priceFrom=${this.priceFrom}&priceTo=${this.priceTo}`)).data;
                this.$emit('filterOn', this.products)
            } catch (error) {
                console.log(error);
            }
        }
    }
}
</script>

<style>
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

    .categories-select {
        padding-top: 1px;
        padding-bottom: 1px;
    }
</style>
