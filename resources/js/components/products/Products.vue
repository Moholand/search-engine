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
    import ProductItem from './ProductItem.vue';
    import Pagination from '../Tools/Pagination/Pagination.vue';

    export default {
        components: { ProductItem, Pagination},
        data() {
            return {
                products: null,
            }
        },
        created() {
            axios.get('api/products')
                .then((response) => {
                    this.products = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        methods: {
            filterOn(data) {
                this.products = data;
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
        }
    }
</script>

<style>
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
        width: 80%;
    }
</style>
