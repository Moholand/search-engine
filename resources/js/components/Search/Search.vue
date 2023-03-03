<template>
    <div class="product-list-wrapper" v-if="products.data.length">
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
</template>

<script>
import ProductItem from "../products/ProductItem.vue";
import Pagination from "../Pagination.vue";

export default {
    components: { ProductItem, Pagination},
    data() {
        return {
            products: null
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
        width: 80%;
    }
</style>
