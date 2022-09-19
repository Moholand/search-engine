<template>
    <Header
        @onSearch="onSearch"
    />
    <div class="products">
        <div class="products-wrapper d-flex">
            <div class="filtre-wrapper">
                <div>فیلترها</div>
            </div>
            <div class="product-list-wrapper d-flex flex-wrap" v-if="products.data.length">
                <ProductItem
                    v-for="(product, index) in products.data"
                    :key="`product-${index}`"
                    :product="product"
                />
                <Pagination :links="products.links" @getForPage="getForPage"/>
            </div>
            <div class="alert alert-danger text-center flex-grow-1" role="alert" v-else>
                محصولی انتخابی وجود ندارد!
            </div>
        </div>
    </div>
</template>

<script>
    import Header from '../header/Header.vue'
    import ProductItem from './ProductItem.vue';
    import Pagination from '../Pagination.vue';

    export default {
        components: {ProductItem, Header, Pagination},
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
            onSearch(data) {
                this.products = data;
            },
            async getForPage(link = {}) {
                link.url = link && link.url ? link.url : '/api/products';
                if(!link.url || link.active) {
                    return;
                }
                // this.loading = true;
                console.log(link);
                try {
                    this.products = (await axios.get(link.url)).data;
                } catch (error) {
                    throw error;
                }
                // this.loading = false;
            },
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

    .filtre-wrapper {
        width: 20%;
        border: 1px solid #d5d8df;
        border-radius: 10px;
        padding: 16px 20px;
        margin-left: 20px;
    }

    .product-list-wrapper {
        width: 80%;
    }
</style>
