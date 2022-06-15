import { createApp } from "vue";
import Oruga from '@oruga-ui/oruga-next';
import '@oruga-ui/oruga-next/dist/oruga.css';
import '@oruga-ui/oruga-next/dist/oruga-full.css';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import axios from 'axios';

import App from "./App.vue";
import Router from "./router";

const app = createApp(App)
.component('font-awesome-icon', FontAwesomeIcon)
.use(Oruga)
.use(Router);

app.config.globalProperties.$axios = axios;
window.axios = axios;
app.mount("#app");