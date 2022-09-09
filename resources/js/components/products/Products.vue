<template>
    <Header
        @onSearch="onSearch"
    />
    <div class="products">
        <div class="products-wrapper d-flex">
            <div class="filtre-wrapper">
                <div>فیلترها</div>
            </div>
            <div class="product-list-wrapper d-flex flex-wrap" v-if="products.length">
                <ProductItem
                    v-for="(product, index) in products"
                    :key="`product-${index}`"
                    :product="product"
                />
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

    export default {
        components: {ProductItem, Header},
        data() {
            return {
                products: null,
            }
        },
        created() {
            axios.get('api/products')
                .then((response) => {
                    this.products = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        methods: {
            onSearch(data) {
                this.products = data;
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
