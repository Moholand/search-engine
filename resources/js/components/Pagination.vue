<template>
    <div class="d-flex justify-content-center mt-4">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
        border: 1px solid #b2bec3;
        padding: 1px 5px;
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
        border: 1px solid #35d4d4;
        background: #81ecec;
    }
</style>
