<template>
    <div v-if="isLoading" class="loading">
        <div class="spinner"></div>
    </div>
</template>

<script>
export default {
    name: 'Loading',
    props: {
        isLoading: {
            type: Boolean,
            required: true,
        },
    },
};
</script>

<style>
    .loading {
        position: absolute; /* Parent element must have relative position */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .spinner {
        border: 4px solid rgba(0, 0, 0, 0.1);
        border-top-color: #ef4056;
        border-radius: 50%;
        width: 1.5em;
        height: 1.5em;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
