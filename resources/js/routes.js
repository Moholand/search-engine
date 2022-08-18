import { createRouter, createWebHistory } from 'vue-router';
import Products from './components/Products.vue';

const routes = [
    {
        path: '/',
        component: Products
    }
]

const router = new createRouter({
    history: createWebHistory(),
    routes
});

export default router;
