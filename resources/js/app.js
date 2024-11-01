import './bootstrap';
import '../sass/app.scss'

import { createApp } from 'vue';
import App from './App.vue';
import router from './routes';
import Tooltip from './components/Tools/Tip/Tooltip.vue'
import Loading from './components/Tools/Loading/Loading.vue';
import Alert from './components/Tools/alert/Alert.vue';
import mitt from 'mitt';

const emitter = mitt();

const app = createApp(App);
app.use(router);
app.config.globalProperties.emitter = emitter;

app.component('Tooltip', Tooltip);
app.component('Loading', Loading);
app.component('alert', Alert);

app.mount('#app');
