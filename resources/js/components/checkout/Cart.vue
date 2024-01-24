<template>
    <div class="cart">
        <div class="cart-full d-flex" v-if="cartItems">
            <div class="items-wrapper w-75">
                <div class="items-header">سبد خرید شما</div>
                <div class="items-body">
                    <div>
                        item detail
                    </div>
                    <div>
                        item detail
                    </div>
                    <div>
                        item detail
                    </div>
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
    .items-wrapper {
        margin-left: 20px;
        border: 1px solid #e0e0e2;
        border-radius: 10px;
        padding: 12px 24px;
    }
    .items-header {
        font-weight: 500;
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
</style>
