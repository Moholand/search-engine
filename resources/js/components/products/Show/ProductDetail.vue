<template>
    <section class="product-detail-wrapper">
        <div class="my-breadcrumb">
            محصولات  /  موبایل  /  گوشی موبایل
        </div>
        <div class="d-flex">
            <div class="col-md-4 product-image-column">
                <img :src="product.image" :alt="product.name"/>
            </div>
            <div class="col-md-8 product-information-column">
                <div class="title">
                    {{ product.title }}
                </div>
                <div class="aggregation">
                    <i class="fa-solid fa-star"></i>
                    <span class="px-1">{{ product.point / 10 }}</span>
                </div>
                <div class="price">
                    <Tooltip text="این کالا توسط فروشنده آن قیمت گذاری شده است"/>
                    <span class="px-2">قیمت فرشنده</span>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Tooltip from "../../Tools/Tip/Tooltip.vue";

export default {
    components: {Tooltip},
    data() {
        return {
            product: null,
            isLoading: false
        }
    },
    created() {
        this.fetchProducts();
    },
    methods: {
        async fetchProducts() {
            this.isLoading = true;

            try {
                this.product = (await axios.get('/api/products/' + this.$route.params.id)).data
            } catch (error) {
                console.log(error)
            } finally {
                this.isLoading = false;
            }
        }
    }
}
</script>

<style scoped>
    .product-detail-wrapper {
        padding: 0 100px 50px 100px;
    }
    .my-breadcrumb {
        font-size: 12px;
        font-weight: 400;
        color: #767790;
        padding: 25px 0;
    }
    .product-image-column img {
        max-width: 100%
    }
    .product-information-column .title {
        font-size: 19px;
        font-weight: bold;
        color: #080a38;
        padding: 20px 0;
        border-bottom: 1px solid #e0e0e6;
    }
    .product-information-column .aggregation {
        font-size: 12px;
        padding: 20px 0;
    }
    .product-information-column .aggregation i {
        color: #f9bc00;
    }
    .price {
        font-size: 12px;
    }
</style>
