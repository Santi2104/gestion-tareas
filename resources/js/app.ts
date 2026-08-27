import "./bootstrap";
import { createApp } from "vue";
import { createPinia } from "pinia";
import { VueQueryPlugin } from "@tanstack/vue-query";
import router from "./src/router/index";
import { Quasar, Notify } from "quasar";
import quasarLang from "quasar/lang/es";

import "@quasar/extras/material-icons/material-icons.css";
import "quasar/src/css/index.sass";

import App from "./App.vue";

const myApp = createApp(App);

const pinia = createPinia();
myApp.use(pinia);
myApp.use(VueQueryPlugin);

myApp.use(Quasar, {
    plugins: {
        Notify,
    },
    lang: quasarLang,
});

myApp.use(router);
myApp.mount("#app");
