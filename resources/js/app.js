import './bootstrap';
import { createApp } from 'vue';
import Chat from './components/Chat.vue';
 
const app = createApp({});
app.component('chat', Chat);
app.mount('#app'); 