export default {
    data() {
        return {
            alertData: {
                show: false,
                message: null,
                type: null
            }
        };
    },
    methods: {
        showAlert(message, type) {
            this.alertData = {
                show: true,
                message: message,
                type: type
            }
        }
    }
};
