import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import "./registerServiceWorker";
import router from "./router";
import PrimeVue from "primevue/config"
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

import "./index.css"

const pinia = createPinia()

createApp(App).use(router).use(PrimeVue).use(pinia).use(ElementPlus).mount("#app");
