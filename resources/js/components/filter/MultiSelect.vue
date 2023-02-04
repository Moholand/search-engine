<template id="MultiSelect">
    <div>
        <div class="dropdown" @click="showDropdown">
            <div class="overselect"></div>
            <div class="c-form-input d-flex justify-content-between align-items-center">
                <span>برند</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                    <path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"/>
                </svg>
            </div>
        </div>
        <div class="multiselect" v-if="show">
            <ul class="list">
                <li v-for="(option, index) in options" :key="index" class="d-flex align-items-center">
                    <input type="checkbox" class="checkbox-icon" :id="index" :value="option.value" v-model="selected">
                    <div class="brand-text d-flex justify-content-between me-2">
                        <span>{{ option.text }}</span>
                        <span class="me-auto">ایسوس</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'MultiSelect',
    template: '#MultiSelect',
    props: ['options'],
    data() {
        return {
            show: false,
            selected: []
        }
    },
    methods: {
        showDropdown() {
            this.show = !this.show
        }
    },
    watch: {
        selected(val) {
            this.$emit('checked', val)
        }
    }
}
</script>

<style scoped>
    .dropdown {
        position: relative;
        cursor: pointer;
    }

    .multiselect {
        position: relative;
    }

    .multiselect ul {
        left: 0px;
        padding: 10px 0px;
        top: -1rem;
        width: 100%;
        list-style: none;
        max-height: 150px;
        overflow: auto;
    }

    .overselect {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }

    .bi-caret-down {
        transform: translateY(5px);
    }

    .checkbox-icon {
        width: 15px;
        height: 15px;
    }

    .brand-text {
        font-size: 16px;
    }
</style>
