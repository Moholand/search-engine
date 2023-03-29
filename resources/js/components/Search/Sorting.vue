<template>
    <section class="product-list-header d-flex flex-row justify-content-between">
        <div class="sort-list-wrapper d-flex">
            <p class="list-header ms-2 mb-0">مرتب‌سازی:</p>
            <p class="sort-list-item" :class="{ selected: isSelected('score') }" @click="onSort('score')">
                مرتبط‌ترین
            </p>
            <p class="sort-list-item" :class="{ selected: isSelected('newest') }" @click="onSort('newest')">
                جدید‌ترین
            </p>
            <p class="sort-list-item" :class="{ selected: isSelected('cheaper') }" @click="onSort('cheaper')">
                ارزان‌ترین
            </p>
        </div>
        <div class="total-count">
            <span class="ps-1">{{ new Intl.NumberFormat().format(total) }}</span>
            <span>کالا</span>
        </div>
    </section>
</template>

<script>
export default {
    props: {
        total: Number
    },
    methods: {
        onSort(type) {
            // Update query parameters and navigate to 'Search' page
            const queryParams = { ...this.$route.query, sort: type };
            this.$router.push({ name: 'Search', query: queryParams });
        },
        isSelected(method) {
            const sort = this.$route.query.sort;
            return (method === 'score' && !sort) || method === sort;
        }
    }
}
</script>

<style scoped>
    .product-list-header {
        padding-bottom: 10px;
        border-bottom: 1px solid #d5d8df;
    }

    .product-list-header .total-count {
        font-size: 14px;
        font-weight: 400;
    }

    .sort-list-wrapper {
        font-size: 14px;
        font-weight: 400;
        color: #767790;
    }

    .sort-list-item {
        cursor: pointer;
        margin-bottom: 0;
        margin-left: 10px;
    }

    .sort-list-item.selected {
        color: #ef394e;
    }

    .list-header {
        font-weight: 700;
    }
</style>
