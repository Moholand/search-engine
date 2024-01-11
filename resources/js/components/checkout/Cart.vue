<template>
    <div class="cart">
        <div class="cart-empty d-flex align-items-center flex-column">
            <img src="/images/logos/cart/empty-cart.svg" width="200" height="150"/>
            <p>سبد خرید شما خالی است!</p>
        </div>
    </div>
</template>

<script>
export default {
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
