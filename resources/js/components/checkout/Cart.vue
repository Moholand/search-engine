<template>
    <div class="cart">
        <alert :alertData="alertData"></alert>
        <div class="cart-full d-flex" v-if="cartItems">
            <div class="items-wrapper w-75">
                <div class="items-header">سبد خرید شما</div>
                <div class="items-count">{{ cartItems.length }} کالا</div>
                <div class="items-body">
                    <CartItem
                        v-for="cartItem in cartItems"
                        :key="cartItem.title"
                        :cartItem="cartItem"
                        @showAlert="showAlert"
                    />
                </div>
            </div>
            <div class="pricing w-25">
                pricing
            </div>
        </div>
        <div class="cart-empty d-flex align-items-center flex-column" v-else>
            <img src="/images/logos/cart/empty-cart.svg" width="200" height="150" alt="empty-cart"/>
            <p>سبد خرید شما خالی است!</p>
        </div>
    </div>
</template>

<script>
import CartItem from "./CartItem.vue";

export default {
    components: { CartItem },
    data() {
        return {
            cartItems: null,
            alertData: {
                show: false,
                message: null,
                type: null
            }
        }
    },
    created() {
        axios.get(`/api/carts`)
            .then(response => this.cartItems = response.data)
            .catch((error) => console.log(error))
    },
    methods: {
        showAlert(payload) {
            this.alertData = {
                show: true,
                message: payload.message,
                type: payload.type
            }
        }
    }
}
</script>

<style>
    .cart {
        padding: 75px 300px 50px 300px;
    }
    .items-wrapper {
        margin-left: 20px;
        border: 1px solid #e0e0e2;
        border-radius: 10px;
        padding: 12px 0;
    }
    .items-header {
        font-weight: 500;
        margin-bottom: 5px;
        padding-right: 24px;
    }
    .pricing {
        border: 1px solid #e0e0e2;
        border-radius: 10px;
        padding: 12px 20px;
    }
    .cart-empty {
        border: 1px solid #e0e0e2;
        border-radius: 10px;
        padding: 20px 0 50px 0;
    }
    .cart-empty p {
        margin-top: 24px;
        font-size: 19px;
        font-weight: 500;
    }
    .items-count {
        font-size: 14px;
        color: #81858b;
        padding-right: 24px;
    }
</style>
