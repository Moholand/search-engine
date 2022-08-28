<template>
    <div class="products">
        <div class="products-wrapper d-flex">
            <div class="filtre-wrapper">
                <div>فیلترها</div>
            </div>
            <div class="product-list-wrapper d-flex flex-wrap">
                <ProductItem
                    v-for="(product, index) in products"
                    :key="`product-${index}`"
                    :product="product"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import ProductItem from './ProductItem.vue';

    export default {
        components: {ProductItem},
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
