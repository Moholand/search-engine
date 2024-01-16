<template>
    <div class="cart">
        <div v-if="cartItems">
            کارت پر است!
        </div>
        <div class="cart-empty d-flex align-items-center flex-column" v-else>
            <img src="/images/logos/cart/empty-cart.svg" width="200" height="150"/>
            <p>سبد خرید شما خالی است!</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            cartItems: null
        }
    },
    created() {
        axios.get(`/api/carts`)
            .then(response => this.cartItems = response.data)
            .catch((error) => console.log(error))
    },
}
</script>

<style>
    .cart {
        padding: 75px 300px 50px 300px;
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
</style>
