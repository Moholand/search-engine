<template>
    <div class="product-list-wrapper">
        <div v-if="isLoading">
            <loading :is-loading="isLoading" />
        </div>
        <div v-else>
            <div v-if="products.data.length">
                <div class="product-list-header d-flex flex-row-reverse">
                    <div class="total-count">
                        <span class="ps-1">{{ new Intl.NumberFormat().format(products.total) }}</span>
                        <span>کالا</span>
                    </div>
                </div>
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
</template>

<script>
import ProductItem from "../products/ProductItem.vue";
import Pagination from "../Pagination.vue";
import Loading from "../Tools/Loading/Loading.vue";

export default {
    components: { ProductItem, Pagination, Loading },
    data() {
        return {
            products: null,
            isLoading: false
        }
    },
    created() {
        this.isLoading = true;
        this.fetchProducts();
        this.isLoading = false;
    },
    methods: {
        getQueryParams() {
            return Object.keys(this.$route.query)
                .map(key => encodeURIComponent(key) + '=' + encodeURIComponent(this.$route.query[key]))
                .join('&');
        },
        fetchProducts() {
            axios.get('/api/products/search?' + this.getQueryParams())
                .then(response => this.products = response.data)
                .catch(error => console.log(error));
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
    .product-list-wrapper {
        position: relative;
        width: 80%;
    }
    .product-list-header {
        padding-bottom: 10px;
        border-bottom: 1px solid #d5d8df;
    }
    .product-list-header .total-count {
        font-size: 14px;
        font-weight: 400;
    }
</style>
