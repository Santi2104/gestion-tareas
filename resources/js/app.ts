import "./bootstrap";
import { createApp } from "vue";
import router from "./src/router/index";
import { Quasar, Notify } from "quasar";
import quasarLang from "quasar/lang/es";

import "@quasar/extras/material-icons/material-icons.css";

import "quasar/src/css/index.sass";

import App from "./App.vue";

const myApp = createApp(App);

myApp.use(Quasar, {
    plugins: {
        Notify,
    }, // import Quasar plugins and add here
    lang: quasarLang,
});

myApp.use(router);
myApp.mount("#app");
