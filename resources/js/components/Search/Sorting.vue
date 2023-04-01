<template>
    <section class="product-list-header d-flex flex-row justify-content-between">
        <div class="sort-list-wrapper d-flex">
            <p class="list-header ms-3 mb-0">
                <i class="fa-solid fa-arrow-down-short-wide"></i>
                <span class="me-2">مرتب‌سازی:</span>
            </p>
            <p
                v-for="sortingTitle in sortingTitles"
                class="sort-list-item"
                :class="{ selected: isSelected(sortingTitle.method) }"
                @click="onSort(sortingTitle.method)"
                :key="'title_' + sortingTitle.method"
            >
                {{ sortingTitle.titleFarsi }}
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
    data() {
        return {
            sortingTitles: [
                { titleFarsi: 'مرتبط‌ترین', method: '_score,desc'},
                { titleFarsi: 'جدید‌ترین' , method: 'created_at,desc'},
                { titleFarsi: 'ارزان‌ترین', method: 'price,asc'},
                { titleFarsi:  'گران‌ترین', method: 'price,desc'},
                { titleFarsi: 'محبوب‌ترین', method: 'point,desc'},
            ]
        }
    },
    methods: {
        onSort(method) {
            // Update query parameters and navigate to 'Search' page
            const queryParams = { ...this.$route.query, sort: method };
            this.$router.push({ name: 'Search', query: queryParams });
        },
        isSelected(method) {
            const sort = this.$route.query.sort;
            return (method === '_score,desc' && !sort) || method === sort;
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
