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
                <span class="signs decrease d-flex align-items-center" @click="changeItemCount(decrease)">
                    <i class="fa-solid fa-minus fa-xs"></i>
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
        </div>
    </div>
</template>

<script>
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
            axios.patch(`/api/carts/${this.cartItem.pivot.cart_id}/products/${this.cartItem.pivot.product_id}/changeCount`,
                { type }
                )
                .then(response => {
                    if (response.status == 200) {
                        this.cartItem.pivot.count += (type === this.increase ? 1 : -1);
                    }
                })
                .catch(() => this.$emit('showAlert', {
                    message: this.errorMessage,
                    type: 'error'
                }))
                .finally(() => this.isLoading = false);
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
</style>
