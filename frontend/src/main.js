import { createApp } from 'vue';
import router from './router';
import store from "./store";
import App from './App.vue';

import { POSITION } from "vue-toastification";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";

import { library } from '@fortawesome/fontawesome-svg-core';
import { faInstagram, faTiktok } from '@fortawesome/free-brands-svg-icons';
import { faFileAlt, faCircleCheck } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faInstagram, faTiktok, faFileAlt, faCircleCheck);

const app = createApp(App);

app.use(Toast, {
  transition: "Vue-Toastification__bounce",
  maxToasts: 5,
  newestOnTop: true,
  position: POSITION.TOP_LEFT,
  icon: false,
});

app.use(router);
app.use(store);
app.component('font-awesome-icon', FontAwesomeIcon);
app.mount('#app');