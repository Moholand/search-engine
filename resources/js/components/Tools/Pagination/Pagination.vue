<template>
    <div class="d-flex justify-content-center mt-4">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li
                        class="nav-item pagination-item"
                        v-for="(link, index) in links"
                        :key="`link-${index}`"
                        :disabled="!link.url || (index === (links.length - 1))"
                        :class="[
                          link.active ? 'link-active' : '',
                          index === 0 ? 'border-right' : '',
                          index === (links.length - 1) ? 'border-left' : '',
                        ]"
                    >
                        <a
                            class="nav-link active"
                            href="#"
                            @click="changeOnPage($event, link)"
                            v-html="link.label"
                        ></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    props: {
        links: Object
    },
    methods: {
        changeOnPage(event, link) {
            event.preventDefault();
            link.url ? this.$emit('getForPage', link) : null;
        }
    }
}
</script>

<style scoped>
    .pagination-item {
        font-size: 12px;
        padding: 0px 6px;
        border-radius: 50%;
    }

    .pagination-item:hover {
        border: 2px solid #ef394e;
    }

    .pagination-item:hover .nav-link {
        color: #ef394e;
    }

    .pagination-item[disabled="true"] a {
        cursor: default !important;
    }

    .border-right {
        border-radius: 0 5px 5px 0;
    }

    .border-left {
        border-radius: 5px 0 0 5px;
    }

    .link-active {
        background: #ef394e;
    }

    .link-active .nav-link {
        color: #ffffff !important;
    }
</style>
