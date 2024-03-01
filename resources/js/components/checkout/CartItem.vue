<template>
    <div class="items-card">
        <div class="item-image w-25">
            <img :src="cartItem.image" width="150" alt="cartItem.title"/>
        </div>
        <div class="item-description w-75">
            <div class="item-title mb-3">
                {{ cartItem.title }}
            </div>
            <div class="item-details">
                {{
                    cartItem.description.length > 100
                        ? cartItem.description.substring(0, 100) + '...'
                        : cartItem.description
                }}
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
        return {}
    }
}
</script>

<style scoped>
    .items-card {
        border-bottom: 1px solid #e0e0e2;
        padding: 30px 24px;
        display: flex;
    }
    .item-description {
        font-size: 14px;
    }
    .item-title {
        font-weight: 600;
    }
</style>
