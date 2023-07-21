import { createRouter, createWebHistory } from 'vue-router';
import ProductDetail from './components/products/Show/ProductDetail.vue';
import Register from './components/auth/Register.vue';
import Search from "./components/Search/Search.vue";

const routes = [
    {
        path: '/',
        name: 'home',
        redirect: '/search'
    },
    {
        path: '/register',
        name: "register",
        component: Register
    },
    {
        path: '/products/:id',
        name: 'product.show',
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
