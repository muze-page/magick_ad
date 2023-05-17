import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import less from 'less'
const app = createApp(App);
app.use(less)
app.mount("#mgad_show_public");
