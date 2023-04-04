import { createApp } from 'vue';
import router from './routes'; 
import Master from './layouts/Master.vue'; 
const app = createApp(Master);
app.use(router); 
app.mount('#app');