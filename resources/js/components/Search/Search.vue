<template>
    <!--    TODO: View for product-->
</template>

<script>
export default {
    data() {
        return {
            products: null
        }
    },
    created() {
        axios.get('/api/products/search?' + this.getQueryParams())
            .then(response => this.products = response.data).catch(error => console.log(error));
    },
    methods: {
        getQueryParams() {
            return Object.keys(this.$route.query).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(this.$route.query[key])).join('&');
        }
    }
}
</script>

<style>

</style>
