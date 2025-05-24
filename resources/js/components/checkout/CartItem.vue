<template>
    <div class="items-card">
        <div class="item-image">
            <img :src="cartItem.image" width="114" height="114" alt="cartItem.title"/>
            <div class="counter">
                <span class="signs increase d-flex align-items-center" @click="changeItemCount(increase)">
                    <i class="fa-solid fa-plus fa-xs"></i>
                </span>
                <div>
                    <loading :is-loading="isLoading" v-if="isLoading" />
                    <span class="number" v-else>
                        {{ cartItem.pivot.count }}
                    </span>
                </div>
                <span
                    class="signs decrease d-flex align-items-center"
                    @click="cartItem.pivot.count === 1 ? deleteItem() : changeItemCount(decrease)"
                >
                    <i class="fa-solid fa-trash fa-xs" v-if="cartItem.pivot.count === 1"></i>
                    <i class="fa-solid fa-minus fa-xs" v-else></i>
                </span>
            </div>
        </div>
        <div class="item-description">
            <div class="item-title mb-3">
                {{ cartItem.title }}
            </div>
            <div class="item-details">
                {{ getDescription(cartItem.description) }}
            </div>
            <div class="item-price mt-3">
                <span class="price-number">{{ new Intl.NumberFormat().format(cartItem.price * cartItem.pivot.count) }}</span>
                <span> تومان </span>
            </div>
        </div>
    </div>
</template>

<script>
import { HTTP_STATUS_CODES } from '@/helpers/constants/httpStatusCodes';

export default {
    props: {
        cartItem: Object,
    },
    data() {
        return {
            increase: 'increase',
            decrease: 'decrease',
            isLoading: false,
            errorMessage: 'خطایی اتفاق افتاده است!'
        }
    },
    methods: {
        getDescription(description) {
            return description.length > 100 ? description.substring(0, 100) + '...' : description;
        },
        changeItemCount(type) {
            this.isLoading = true;
            axios.patch(`/api/carts/products/${this.cartItem.pivot.product_id}/changeCount`, { type })
                .then(response => {
                    if (response.status == HTTP_STATUS_CODES.OK) {
                        this.cartItem.pivot.count += (type === this.increase ? 1 : -1);
                        this.emitter.emit('cart-count-update', { type });
                    }
                })
                .catch(() => this.showError())
                .finally(() => this.isLoading = false);
        },
        deleteItem() {
            this.isLoading = true;
            axios.delete(`/api/carts/products/${this.cartItem.pivot.product_id}`)
                .then(response => {
                    if (response.status == HTTP_STATUS_CODES.OK) {
                        this.$emit('deleteItem', this.cartItem.pivot.product_id);
                        this.emitter.emit('cart-count-update', { type: 'decrease' });
                        this.$emit('showAlert', response.data.response_message, 'success');
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
    .items-card {
        border-bottom: 1px solid #e0e0e2;
        padding: 30px 24px;
        display: flex;
    }
    .item-image {
        margin-left: 20px;
    }
    .item-description {
        font-size: 14px;
    }
    .item-title {
        font-weight: 600;
    }
    .counter {
        margin: 25px 7px 0 7px;
        border: 1px solid #e0e0e2;
        border-radius: 10px;
        padding: 5px 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #ef4056;
        position: relative;
        min-height: 41px;
    }
    .counter .number {
        font-size: 16px;
    }
    .signs {
        font-size: 20px;
        cursor: pointer;
    }
    .item-price .price-number {
        font-size: 17px;
        font-weight: bold;
    }
</style>
