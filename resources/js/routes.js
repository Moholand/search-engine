import { createRouter, createWebHistory } from 'vue-router';
import Home from './components/home/Home.vue';
import ProductDetail from './components/products/Show/ProductDetail.vue';
import Register from './components/auth/Register.vue';
import Login from './components/auth/Login.vue';
import Search from "./components/Search/Search.vue";
import Cart from "./components/checkout/Cart.vue";

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/login',
        name: 'login',
        component: Login
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
    },
    {
        path: '/checkout/cart',
        name: 'cart',
        component: Cart
    }
]

const router = new createRouter({
    history: createWebHistory(),
    routes
});

export default router;
