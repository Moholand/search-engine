import { createRouter, createWebHistory } from 'vue-router';
import Products from './components/products/Products.vue';
import ProductDetail from './components/ProductDetail.vue';

const routes = [
    {
        path: '/',
        component: Products
    },
    {
        path: '/products/:id',
        name: 'ProductDetail',
        component: ProductDetail
    }
]

const router = new createRouter({
    history: createWebHistory(),
    routes
});

export default router;
