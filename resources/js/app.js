import "./bootstrap";
// import Vue from "vue";
import { createApp } from "vue";
// import store for use in the app;
import store from "./store/index.js";
// import the app main component
import App from "./App.vue";

//Create the app and mount it to the #app element and use the store
const app = createApp(App);
app.use(store);
app.mount("#app");
