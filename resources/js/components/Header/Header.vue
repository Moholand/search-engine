<template>
    <div class="header d-flex align-items-center">
        <div class="header-block w-100">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-grow-1">
                    <a href="/" class="logo">
                        <img src="/images/logos/logo.png" width="115" height="45" alt="logo"/>
                    </a>
                    <div class="search-form ml-auto px-2">
                        <div class="input-group rounded">
                            <input
                                type="search"
                                class="form-control rounded search-input"
                                placeholder="جستجو"
                                aria-label="Search"
                                aria-describedby="search-addon"
                                v-model="search"
                                v-on:keydown="searchStart"
                            />
                            <span class="input-group-text border-0" id="search-addon">
                        <i class="fas fa-search"></i>
                    </span>
                        </div>
                        <div class="recommendations-wrapper px-2" v-if="recommendations">
                            <ul class="list-group mb-0 pe-0">
                                <li
                                    class="list-group-item"
                                    v-for="(recommendation, index) in recommendations"
                                    :key="`recommendation-${index}`"
                                    @click="recommendationSelected($event)"
                                >
                                    {{ recommendation.title }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="personal-menu d-flex align-items-center">
                    <div v-if="loggedUser" class="d-flex">
                        <div class="dropdown">
                            <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i>
                            </a>
                            <ul class="dropdown-menu text-small">
                                <li><a class="dropdown-item" href="#" style="pointer-events: none">
                                    {{ loggedUser.name + ' ' + loggedUser.surname }}
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" @click="logout">خروج از حساب کاربری</a></li>
                            </ul>
                        </div>
                        <router-link class="text-decoration-none" to="/checkout/cart">
                            <div class="cart-icon pe-3 me-3">
                                <i class="fa-solid fa-cart-plus"></i>
                                <div class="cart-count" v-if="cartItemCount">{{ cartItemCount }}</div>
                            </div>
                        </router-link>
                    </div>
                    <button class="btn login-register" v-else>
                        <router-link class="text-decoration-none" to="/login">ورود|ثبت‌نام</router-link>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Auth from '../../helpers/auth';
    export default {
        data() {
            return {
                search: null,
                products: null,
                recommendations: null,
                loggedUser: Auth.user,
                cartItemCount: 0
            }
        },
        created() {
            axios.get(`/api/carts/items-count`)
                .then(response => this.cartItemCount = response.data.items_count)
                .catch(() => this.cartItemCount = 0)
        },
        methods: {
            async searchStart(event) {
                if(event.keyCode === 13 && this.search) { // Client pressed enter key
                    try {
                        this.recommendations = null;
                        this.$router.push({ name: 'Search', query: { title: this.search } });
                    } catch (error) {
                        console.log(error);
                    }
                } else if (this.search && this.search.length >= 3) {
                    try {
                        this.recommendations = (await axios.get(`/api/products/recommendations?title=${this.search}`)).data;
                    } catch (error) {
                        console.log(error);
                    }
                } else {
                    this.recommendations = null;
                }
            },
            async recommendationSelected(event) {
                this.search = event.target.innerHTML;
                this.recommendations = null;

                try {
                    this.products = (await axios.get(`/api/products/search?title=${this.search}`)).data;
                    this.$emit('onSearch', this.products)
                } catch (error) {
                    console.log(error);
                }
            },
            async logout() {
                try {
                    await axios.post('/api/logout');
                    Auth.logout();
                    this.loggedUser = null;
                } catch (error) {
                    console.log(error);
                }
            }
        }
    }
</script>

<style>
    .header {
        height: 100px;
        padding: 20px 0;
        border-bottom: #d5d8df 2px solid;
    }
    .header-block {
        background-color: #ffffff;
        margin-right: 81px;
    }
    .logo {
        transform: translate(0, -4px);
    }
    .search-form {
        position: relative;
        width: 35%;
    }
    .search-input {
        padding: 12px 45px;
        font-size: 14px;
        color: #a1a3a8;
    }
    #search-addon {
        background-color: transparent;
        position: absolute;
        right: 0;
        top: 6px;
    }
    #search-addon i {
        color: #a1a3a8;
    }
    .recommendations-wrapper {
        position: absolute;
        left: 0;
        right: 0;
        background-color: #ffffff;
        padding: 10px;
        border-radius: 0 0 5px 5px;
        box-shadow: 0 0 5px rgba(0,0,0, 0.25);
        margin: 0 13px;
        z-index: 20;
    }
    .recommendations-wrapper li {
        cursor: pointer;
    }
    .recommendations-wrapper li:hover {
        cursor: pointer;
        background-color: #f1f2f6;
    }
    .personal-menu {
        margin-left: 80px;
    }
    .link-body-emphasis {
        color: #080a38 !important;
    }
    .dropdown-item {
        font-size: 15px;
        text-align: right;
        cursor: pointer;
    }
    .login-register {
        font-size: 14px;
        font-weight: bold;
    }
    .login-register a {
        color: #080a38 !important;
    }
    .cart-icon {
        border-right: 1px solid #e0e0e2;
        cursor: pointer;
        color: #080a38 !important;
        position: relative;
    }
    .cart-count {
        position: absolute;
        background-color: #ef4056;
        color: #ffffff;
        border-radius: 6px;
        font-size: 10px;
        font-weight: bold;
        min-width: 18px;
        height: 18px;
        border: 2px solid #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        top: 12px;
        left: 12px;
    }
    .dropdown-toggle::after {
        margin-right: 0.355em;
        margin-left: 0;
    }
    .link-body-emphasis {
        color: #3f4064 !important;
    }
</style>
