<template>
    <div class="filtre-wrapper">
        <div class="filter-title">فیلترها</div>
        <div class="filter-list-wrapper">
            <ul class="filter-list mt-4 px-0" v-if="categories">
                <li>
                    <div class="o-container">
                        <div class="o-row o-flex u-mt2">
                                <MultiSelect :options="brands" @checked="onCheckBrand"></MultiSelect>
                            <div class="col"><pre>{{ selectedBrands }}</pre></div>
                        </div>
                    </div>
                </li>
                <hr>
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
                    <PriceRange @priceFilter="priceFilter"/>
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
            brands: null,
            selectedBrands: [],
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

        axios.get('api/brands')
            .then((response) => {
                this.brands = response.data;
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
        async priceFilter(priceFrom, priceTo) {
            try {
                this.products = (await axios.get(`/api/products/search?query=&price_from=${priceFrom}&price_to=${priceTo}`)).data;
                this.$emit('filterOn', this.products)
            } catch (error) {
                console.log(error);
            }
        },
        async brandFilter(brand) {
            try {
                this.products = (await axios.get(`/api/products/search?query=&brand=${brand}`)).data;
                this.$emit('filterOn', this.products)
            } catch (error) {
                console.log(error);
            }
        },
        onCheckBrand(val) {
            // this.selectedBrands = val;
            this.brandFilter(val);
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

    .categories-select {
        padding-top: 1px;
        padding-bottom: 1px;
    }
</style>
