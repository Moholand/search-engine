<template>
    <transition name="alert-box">
        <div
            class="custom-alert d-flex align-items-center"
            :class="alertData.type"
            v-if="alertData.show"
        >
            <div class="d-flex justify-content-between align-items-center flex-grow-1">
                <span>{{ alertData.message }}</span>
                <span class="close-btn" @click="alertData.show = false">&times;</span>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: {
        alertData: Object
    },
    watch: {
        alertData: function(data) {
            setTimeout(function() {
                data.show = false;
            }, 3000);
        }
    }
}
</script>

<style scoped>
.custom-alert {
    position: fixed;
    top: 10%;
    right: 5%;
    background: #e2fff7;
    color: #57606f;
    width: 320px;
    height: 60px;
    border-radius: 5px;
    padding: 10px 25px 10px 10px;
}

.custom-alert.error {
    background: #fff5e2;
}

.custom-alert:after {
    content: '';
    position: absolute;
    width: 10px;
    height: 100%;
    right: 0;
    border-radius: 0 5px 5px 0;
    background: #55efc4;
}

.custom-alert.error:after {
    background: #e74c3c;
}

.close-btn {
    font-size: 20px;
    margin-left: 10px;
    cursor: pointer;
}

.alert-box-enter-active, .alert-box-leave-active {
    transition: 0.5s all ease;
}

.alert-box-enter-from, .alert-box-leave-to {
    transform: translateX(100px);
    opacity: 0;
}
</style>
