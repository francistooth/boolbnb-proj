import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../components/pages/HomeView.vue";
import SearchView from "../components/pages/SearchView.vue";
import ApartmentDetails from "../components/general/ApartmentDetails.vue";
import Try from "../components/pages/Try.vue";
import Error404 from "../components/pages/Error404.vue";
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/ricerca-avanzata",
      name: "search",
      component: SearchView,
    },
    {
      path: "/try",
      name: "Try",
      component: Try,
    },
    {
      path: "/dettagli-appartamento/:slug",
      name: "dettagli",
      component: ApartmentDetails,
    },
    {
      path: "/404",
      name: "404",
      component: Error404,
    },
    {
      path: "/:pathMatch(.*)*",
      redirect: "404",
    },
  ],
});

export default router;
