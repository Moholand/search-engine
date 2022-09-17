<template>
    <div class="header d-flex align-items-center">
        <div class="header-block w-100">
            <div class="d-flex">
                <a class="logo">
                    <img src="/images/logos/logo.png" width="115" height="45"/>
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                search: null,
                products: null,
            }
        },
        methods: {
            async searchStart(event) {
                if(event.keyCode === 13 && this.search) {
                    try {
                        this.products = (await axios.get(`/api/products/search?query=${this.search}`)).data.hits;
                        this.$emit('onSearch', this.products)
                    } catch (error) {
                        console.log(error);
                    }
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
</style>
