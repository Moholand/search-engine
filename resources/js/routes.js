import { createRouter, createWebHistory } from 'vue-router';
import Products from './components/products/Products.vue';
import ProductDetail from './components/ProductDetail.vue';
import Search from "./components/Search/Search.vue";

const routes = [
    {
        path: '/',
        name: 'home',
        component: Products
    },
    {
        path: '/products/:id',
        name: 'ProductDetail',
        component: ProductDetail
    },
    {
        path: '/search',
        name: 'Search',
        component: Search
    }
]

const router = new createRouter({
    history: createWebHistory(),
    routes
});

export default router;
