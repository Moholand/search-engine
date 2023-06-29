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
                    <div class="my-tooltip">
                        <i class="fa-solid fa-info"></i>
                        <span class="tooltiptext">This is a tooltip</span>
                        <div class="box">This is a box that opens when the tooltip is hovered over</div>
                    </div>
                    <span class="px-2">قیمت فرشنده</span>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
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
    .my-tooltip {
        position: relative;
        display: inline-block;
    }
    .my-tooltip i {
        color: #9e9fb1;
        padding: 4px 6px;
        border: 1px solid #9e9fb1;
        border-radius: 50%;
        font-size: 8px;
    }
    .my-tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -60px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .my-tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }

    .box {
        display: none;
        background-color: #f1f1f1;
        padding: 10px;
        margin-top: 10px;
    }

    .my-tooltip:hover .box {
        display: block;
    }
</style>
