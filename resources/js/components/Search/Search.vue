<template>
    <div class="products">
        <div class="products-wrapper d-flex">
            <Filter />
            <div class="product-list-wrapper">
                <div v-if="isLoading">
                    <loading :is-loading="isLoading" />
                </div>
                <div v-else>
                    <div v-if="products.data.length">
                        <ListHeader :total="products.total" />
                        <div class="d-flex flex-wrap">
                            <ProductItem
                                v-for="(product, index) in products.data"
                                :key="`product-${index}`"
                                :product="product"
                            />
                        </div>
                        <Pagination :links="products.links" @getForPage="getForPage"/>
                    </div>
                    <div class="alert alert-danger text-center flex-grow-1" role="alert" v-else>
                        محصولی انتخابی وجود ندارد!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ProductItem from "../products/ProductItem.vue";
import Pagination from "../Tools/Pagination/Pagination.vue";
import ListHeader from "./Sorting.vue";
import Filter from "../filter/Filter.vue";

export default {
    components: { Filter, ListHeader, ProductItem, Pagination },
    data() {
        return {
            products: null,
            isLoading: false
        }
    },
    created() {
        this.fetchProducts();
    },
    methods: {
        getQueryParams() {
            return Object.keys(this.$route.query)
                .map(key => encodeURIComponent(key) + '=' + encodeURIComponent(this.$route.query[key]))
                .join('&');
        },
        async fetchProducts() {
            this.isLoading = true;

            try {
                this.products = (await axios.get('/api/products/search?' + this.getQueryParams())).data
            } catch (error) {
                console.log(error)
            } finally {
                this.isLoading = false;
            }
        },
        async getForPage(link = {}) {
            link.url = link && link.url ? link.url : '/api/products';
            if(!link.url || link.active) {
                return;
            }

            try {
                this.products = (await axios.get(link.url)).data;
                window.scrollTo({ top: 0, behavior: 'smooth' }); // add scroll to top
            } catch (error) {
                throw error;
            }
        }
    },
    watch: {
        '$route.query': {
            handler: 'fetchProducts',
            immediate: true
        }
    }
}
</script>

<style scoped>
    .products {
        padding: 40px 0;
        color: #424750;
        font-size: 20px;
        font-weight: bold
    }
    .products-wrapper {
        margin: 0 81px;
    }
    .product-list-wrapper {
        position: relative;
        width: 80%;
    }
</style>
