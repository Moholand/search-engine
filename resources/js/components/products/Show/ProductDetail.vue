<template>
    <section class="product-detail-wrapper">
        <alert :alertData="alertData"></alert>
        <div class="my-breadcrumb">
            محصولات  /  موبایل  /  گوشی موبایل
        </div>
        <div class="d-flex flex-md-row flex-column">
            <div class="col-md-4 col-12 product-image-column md:px-5">
                <img :src="product.image" :alt="product.title"/>
            </div>
            <div class="col-md-8 col-12 product-information-column">
                <div class="title">
                    {{ product.title }}
                </div>
                <div class="aggregation">
                    <i class="fa-solid fa-star"></i>
                    <span class="px-1">{{ product.point / 10 }}</span>
                </div>
                <div class="purchase-block">
                    <div class="price">
                        <Tooltip text="این کالا توسط فروشنده آن قیمت گذاری شده است"/>
                        <div class="price-block">
                            <span class="px-2 d-none d-md-block">قیمت فرشنده</span>
                            <span class="pe-5 number">{{ new Intl.NumberFormat().format(product.price) }}</span>
                            <span class="px-2">تومان</span>
                        </div>
                    </div>
                    <div class="order-btn my-5" @click="addToCart" v-if="countInCart == 0">
                        افزودن به سبد
                    </div>
                    <div class="counter my-5" v-else>
                        <span class="signs increase d-flex align-items-center" @click="changeItemCount(increase)">
                            <i class="fa-solid fa-plus fa-xs"></i>
                        </span>
                        <div>
                            <loading :is-loading="isLoading" v-if="isLoading" />
                            <span class="number" v-else>
                                {{ countInCart }}
                            </span>
                        </div>
                        <span
                            class="signs decrease d-flex align-items-center"
                            @click="countInCart === 1 ? deleteItem() : changeItemCount(decrease)"
                        >
                            <i class="fa-solid fa-trash fa-xs" v-if="countInCart === 1"></i>
                            <i class="fa-solid fa-minus fa-xs" v-else></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="benefits d-flex justify-content-between">
            <div v-for="(benefit, index) in benefits" :key="`benefit-${index}`" class="benefits-item col-md-2 text-center">
                <img :src="`/images/logos/benefits/${benefit.logo}`" :alt="benefit.text"/>
                <span class="text px-2">{{ benefit.text }}</span>
            </div>
        </div>
    </section>
</template>

<script>
import alertMixin from '@/helpers/mixins/alertMixin';
import { HTTP_STATUS_CODES } from '@/helpers/constants/httpStatusCodes';

export default {
    data() {
        return {
            product: null,
            countInCart: 0,
            increase: 'increase',
            decrease: 'decrease',
            isLoading: false,
            benefits: [
                { logo: 'express-delivery.svg', text: 'امکان تحویل اکسپرس' },
                { logo: 'support.svg', text: '۲۴ ساعته، ۷ روز هفته' },
                { logo: 'cash-on-delivery.svg', text: 'امکان پرداخت در محل' },
                { logo: 'days-return.svg', text: 'هفت روز ضمانت بازگشت کالا' },
                { logo: 'original-products.svg', text: 'ضمانت اصل بودن کالا' },
            ],
            errorMessage: 'خطا رخ داده است'
        }
    },
    mixins: [alertMixin],
    created() {
        this.fetchProducts();
    },
    methods: {
        async fetchProducts() {
            this.isLoading = true;

            try {
                this.product = (await axios.get('/api/products/' + this.$route.params.id)).data;
                this.countInCart = this.product.count_in_user_cart;
            } catch (error) {
                this.showAlert(this.errorMessage, 'error');
            } finally {
                this.isLoading = false;
            }
        },
        async addToCart() {
            try {
                let response = (await axios.post('/api/carts/products/' + this.product.id)).data;
                this.countInCart = 1;
                this.emitter.emit('cart-count-update', { type: 'increase' });
                this.showAlert(response.response_message, 'success');
            } catch (error) {
                this.showAlert(this.errorMessage, 'error');
            }
        },
        changeItemCount(type) {
            this.isLoading = true;
            axios.patch(`/api/carts/products/${this.product.id}/changeCount`, { type })
                .then(response => {
                    if (response.status == HTTP_STATUS_CODES.OK) {
                        this.countInCart += (type === this.increase ? 1 : -1);
                        this.emitter.emit('cart-count-update', { type });
                    }
                })
                .catch(() => this.showError())
                .finally(() => this.isLoading = false);
        },
        deleteItem() {
            this.isLoading = true;
            axios.delete(`/api/carts/products/${this.product.id}`)
                .then(response => {
                    if (response.status == HTTP_STATUS_CODES.OK) {
                        this.countInCart = 0;
                        this.emitter.emit('cart-count-update', { type: 'decrease' });
                        this.showAlert(response.data.response_message, 'success');
                    }
                })
                .catch(() => this.showError())
                .finally(() => this.isLoading = false);
        },
        showError() {
            this.$emit('showAlert', this.errorMessage, 'error');
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
        max-width: 100%;
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
        display: flex;
        align-items: center;
    }
    .price-block {
        display: flex;
        align-items: center;
    }
    .price .number {
        font-size: 19px;
        font-weight: bold;
    }
    .order-btn {
        display: flex;
        justify-content: center;
        background-color: #ef4056;
        max-width: 300px;
        padding: 10px 25px;
        color: #ffffff;
        border-radius: 10px;
        font-size: 12px;
        cursor: pointer;
    }
    .benefits {
        margin-top: 10px;
        border-top: 1px solid #e0e0e6;
        border-bottom: 4px solid #f1f2f4;
        padding: 15px 0 35px 0;
    }
    .benefits-item {
        cursor: pointer;
    }
    .benefits .text {
        font-size: 11px;
        font-weight: bold;
        color: #9e9fb1;
    }
    .counter {
        border: 1px solid #e0e0e2;
        border-radius: 10px;
        padding: 5px 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #ef4056;
        position: relative;
        min-height: 41px;
        max-width: 300px;
    }
    .counter .number {
        font-size: 16px;
    }
    .signs {
        font-size: 20px;
        cursor: pointer;
    }
    /* Styles for mobile devices */
    @media only screen and (max-width: 767px) {
        .product-detail-wrapper {
            padding: 0 20px 100px 20px;
        }
        .product-information-column .title {
            font-size: 15px;
        }
        .purchase-block {
            position: fixed;
            bottom: 0;
            z-index: 3;
            display: flex;
            flex-direction: row-reverse;
            left: 0;
            background-color: #ffffff;
            width: 100%;
            height: 100px;
            padding: 12px 20px;
            box-shadow: 0 -1px 1px rgba(0,0,0,.14), 0 -2px 2px rgba(0,0,0,.05);
        }
        .price {
            flex: 1;
            width: 50%;
            display: flex;
            flex-direction: column;
            margin-top: auto;
            align-items: flex-end;
        }
        .price-block {
            font-size: 10px;
        }
        .price-block .number {
            font-size: 16px !important;
        }
        .order-btn {
            flex: 1;
            width: 50%;
            margin: auto 0 0 0 !important;
            max-height: 40px;
        }
    }
</style>
