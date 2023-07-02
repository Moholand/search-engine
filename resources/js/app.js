import './bootstrap';
import '../sass/app.scss'

import { createApp } from 'vue';
import App from './App.vue';
import router from './routes';
import Tooltip from './components/Tools/Tip/Tooltip.vue'

const app = createApp(App);
app.use(router);

app.component('Tooltip', Tooltip);

app.mount('#app');
