<template>
    <div class="my-tooltip">
        <i class="fa-solid fa-info"></i>
        <div class="box">{{ text }}</div>
    </div>
</template>

<script>
    export default {
        props: {
            text: {
                type: String
            }
        }
    }
</script>

<style scoped>
    .my-tooltip {
        position: relative;
        display: inline-block;
    }
    .my-tooltip i {
        color: #9e9fb1;
        padding: 4px 6px;
        border: 1px solid #9e9fb1;
        border-radius: 50%;
        font-size: 8px;
    }
    .box {
        display: none;
        background-color: #3f4064;
        padding: 10px;
        margin-top: 10px;
        position: absolute;
        width: 300px;
        border-radius: 5px;
        color: #ffffff
    }
    .my-tooltip:hover .box {
        display: block;
        position: absolute;
    }
</style>
