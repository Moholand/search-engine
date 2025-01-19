<template>
    <div class="cart">
        <alert :alertData="alertData"></alert>
        <div class="cart-full d-flex" v-if="cartItems">
            <div class="items-wrapper w-75">
                <div class="items-header">سبد خرید شما</div>
                <div class="items-count">{{ itemsCount }} کالا</div>
                <div class="items-body">
                    <CartItem
                        v-for="cartItem in cartItems"
                        :key="cartItem.title"
                        :cartItem="cartItem"
                        @showAlert="showAlert"
                        @deleteItem="deleteItem"
                    />
                </div>
            </div>
            <div class="continue-checkout-wrapper w-25">
                <ContinueCheckout 
                    :itemsCount="itemsCount" 
                    :totalPrice="totalPrice"
                />
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
import ContinueCheckout from "./ContinueCheckout.vue";
import alertMixin from '@/helpers/mixins/alertMixin';

export default {
    components: { CartItem, ContinueCheckout },
    data() {
        return {
            cartItems: null,
        }
    },
    mixins: [alertMixin],
    created() {
        axios.get(`/api/carts`)
            .then(response => this.cartItems = response.data)
            .catch((error) => console.log(error))
    },
    methods: {
        deleteItem(id) {
            this.cartItems = this.cartItems.filter(item => item.id !== id);
        }
    },
    computed: {
        itemsCount() {
            return this.cartItems.reduce((count, item) => count + item.pivot.count, 0);
        },
        totalPrice() {
            return this.cartItems.reduce((price, item) => price + (item.pivot.count * item.price), 0);
        },
    },
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
    .continue-checkout-wrapper {
        border: 1px solid #e0e0e2;
        border-radius: 10px;
        padding: 12px 20px;
        height: max-content;
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
