<template>
    <section class="register d-flex justify-content-center align-items-center">
        <div class="register-form">
            <div class="text-center">
                <a href="/" class="logo">
                    <img src="/images/logos/logo.png" width="115" height="45"/>
                </a>
            </div>
            <h1 class="mt-4 heading">
                ثبت نام
            </h1>
            <p class="mt-4">
                سلام!
            </p>
            <div>
                <label for="name">Name</label>
                <input type="text" v-model="user.name">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="text" v-model="user.email">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" v-model="user.password">
            </div>
            <div>
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" v-model="user.password_confirmation">
            </div>
            <button @click="Register()">Register</button>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            user: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }
        };
    },

    methods: {
        register() {
            console.log(this.user);
            this.axios.post('http://127.0.0.1:8000/api/register', this.user)
                .then(({data}) => {
                    this.$router.push('/login');
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>
    .register {
        height: 100vh;
    }
    .register-form {
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
</style>
