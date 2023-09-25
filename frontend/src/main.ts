import { createApp } from "vue";

import App from "@/App.vue";
import { router } from "@/router";

import "bootstrap/scss/bootstrap.scss";
import "bootstrap-icons/font/bootstrap-icons.css";

const app = createApp(App).use(router);

app.config.globalProperties.apiBaseUrl = import.meta.env.VITE_API_BASE_URL;
app.config.globalProperties.mediaBaseUrl = import.meta.env.VITE_MEDIA_BASE_URL;

import dateTimeFormatter from "./mixins/dateTimeFormatterMixin"
app.mixin(dateTimeFormatter)

router.isReady().then(() => app.mount("#app"));

