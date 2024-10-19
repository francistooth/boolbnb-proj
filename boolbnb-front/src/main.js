import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
// Impotrazione di FontAwsome
import "@fortawesome/fontawesome-free/css/all.min.css";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import "./styles/general.scss";

const app = createApp(App);

app.use(router);

app.mount("#app");
