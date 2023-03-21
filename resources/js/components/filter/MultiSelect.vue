<template id="MultiSelect">
    <div>
        <div class="dropdown" @click="showDropdown">
            <div class="overselect"></div>
            <div class="c-form-input d-flex justify-content-between align-items-center">
                <div class="title-block">
                    <span>{{ title.persian }}</span>
                    <span class="selected-circle" :class="{ active: selected.length !== 0 }"></span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                    <path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"/>
                </svg>
            </div>
        </div>
        <div class="multiselect" v-if="show">
            <ul class="list d-flex flex-column">
                <li v-for="(option, index) in options" :key="index" class="d-flex align-items-center">
                    <input type="checkbox" class="checkbox-icon" :id="index" :value="option.name" v-model="selected">
                    <div class="brand-text d-flex justify-content-between me-2 w-100">
                        <span>{{ option.name }}</span>
                        <span class="ms-2 me-auto">{{ option.name_farsi }}</span>
                    </div>
                </li>
            </ul>
        </div>
        <div class="selected-items" v-if="selected.length !== 0">
            {{ selected.toString() }}
        </div>
    </div>
</template>

<script>
export default {
    name: 'MultiSelect',
    template: '#MultiSelect',
    props: ['options', 'title'],
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
    },
    mounted() {
        // Updates the selected options based on the query parameters in the URL
        const query = this.$route.query;
        for (let key in query) {
            if (key === this.title.english) {
                this.selected = query[key].split(',');
                break;
            }
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
        padding: 20px 0px;
        top: -1rem;
        width: 100%;
        list-style: none;
        max-height: 200px;
        overflow: auto;
    }
    .multiselect li {
        padding-bottom: 15px;
    }
    .overselect {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
    .title-block {
        font-size: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .selected-circle {
        width: 5px;
        height: 5px;
        margin: 10px;
        background-color: #19bfd3;
        border-radius: 50%;
        display: none;
    }
    .selected-circle.active {
        display: block;
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
    .selected-items {
        font-size: 16px;
        color: #767790;
        padding-top: 15px;
    }
</style>
