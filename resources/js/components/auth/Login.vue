<template>
    <section class="login d-flex justify-content-center align-items-center">
        <div class="login-form">
            <div class="text-center">
                <a href="/" class="logo">
                    <img src="/images/logos/logo.png" width="115" height="45"/>
                </a>
            </div>
            <h1 class="mt-4 heading">
                ورود
            </h1>
            <form class="mt-4">
                <div class="row mb-3 mx-0">
                    <label for="email" class="form-label">ایمیل:</label>
                    <input type="text" v-model="user.email" :class="{'border-danger': errors && errors.email}">
                    <span
                        v-if="errors && errors.email" v-text="errors.email[0]"
                        class="error-text mt-1"
                    ></span>
                </div>
                <div class="row mb-3 mx-0">
                    <label for="password" class="form-label">رمز عبور:</label>
                    <input type="password" v-model="user.password" :class="{'border-danger': errors && errors.password}">
                    <span
                        v-if="errors && errors.password" v-text="errors.password[0]"
                        class="error-text mt-1"
                    ></span>
                </div>
            </form>
            <button class="submit-button mt-3 w-100" @click.prevent="login">ورود</button>
        </div>
    </section>
</template>

<script>
import axios from 'axios';
import auth from '../../helpers/auth.js';

export default {
    data() {
        return {
            user: {
                email: '',
                password: '',
            },
            errors: null
        };
    },
    methods: {
        login() {
            this.errors = null;

            axios.post('/api/login', this.user)
                .then(({data}) => {
                    auth.login(data.access_token, data.user);
                    this.$router.push('/');
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        }
    }
}
</script>

<style scoped>
    .login {
        height: 100vh;
    }
    .login-form {
        border: 1px solid #e0e0e6;
        border-radius: 5px;
        max-width: 400px;
        padding: 32px;
    }
    .heading {
        font-size: 19px;
        font-weight: bold;
        color: #080a38;
    }
    .form-label {
        font-size: 12px;
        color: #3f4064;
    }
    form label {
        display: block;
        padding: 0;
    }
    form input {
        padding: 8px;
        border-radius: 8px;
        border: 1px solid #3f4064;
    }
    .submit-button {
        background-color: #ef4056;
        border: 1px solid #ef4056;
        color: #ffffff;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 14px;
        font-weight: bold;
    }
    .error-text {
        font-size: 12px;
        color: #ef4056;
    }
</style>
