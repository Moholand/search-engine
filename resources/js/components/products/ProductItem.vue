<template>
    <div class="product-list-item p-2">
        <router-link :to="{ name: 'ProductDetail', params: { id: product.id  }}" class="text-decoration-none">
            <div class="product-image mb-3">
                <img width="240" heigh="240" :src="product.image" />
            </div>
            <div>
                <div class="title">
                    {{ product.title }}
                </div>
                <div class="status d-flex flex-row-reverse mb-1">
                    <div class="points">
                        <span class="ms-1">{{ product.point }}</span>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <div class="price d-flex flex-row-reverse">
                    <span class="unit">تومان</span>
                    <span class="ms-1">{{ new Intl.NumberFormat().format(product.price) }}</span>
                </div>
            </div>
        </router-link>
    </div>
</template>

<script>
    export default {
        props: {
            product: Object
        }
    }
</script>

<style>
    .product-list-item {
        cursor: pointer;
        border-left: 1px solid rgba(0, 0, 0, 0.1);
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .product-list-item:hover {
        box-shadow: 0 0 7px rgba(0, 0, 0, 0.4);
    }

    .product-list-item:nth-child(5n) {
        border-left: none;
    }

    .title {
        font-size: 14px;
        font-weight: 700;
        line-height: 2.17;
        color: #424750;
    }

    .points {
        font-size: 14px;
    }

    .points i {
        color: #f9bc00;
    }

    .price {
        font-size: 16px;
    }

    .price .unit{
        font-size: 12px;
        transform: translate(0, 3px);
    }
</style>
