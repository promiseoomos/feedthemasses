import { createApp } from "vue";
import App from "./App.vue";
import "./registerServiceWorker";
import router from "./router";
import PrimeVue from "primevue/config"
import "./index.css"

createApp(App).use(router).use(PrimeVue).mount("#app");
