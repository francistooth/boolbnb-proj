import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../components/pages/HomeView.vue'
import SearchView from '../components/pages/SearchView.vue'
import NotFound from '../components/pages/NotFound.vue';
import ApartmentDetails from '../components/general/ApartmentDetails.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/ricerca-avanzata',
      name: 'search',
      component: SearchView
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'NotFound',
      component: NotFound
    },
    {
      path: '/dettagli-appartamento',
      name: 'dettagli',
      component: ApartmentDetails
    },
  ]
})

export default router
