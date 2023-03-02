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
    import Pagination from '../Pagination.vue';

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
            // onSearch(data) {
            //     this.products = data;
            // },
            filterOn(data) {
                this.products = data;
            },
            async getForPage(link = {}) {
                link.url = link && link.url ? link.url : '/api/products';
                if(!link.url || link.active) {
                    return;
                }
                // this.loading = true;

                try {
                    this.products = (await axios.get(link.url)).data;
                } catch (error) {
                    throw error;
                }
                // this.loading = false;
            }
        }
    }
</script>

<style>
    .products {
        padding: 20px 0;
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
