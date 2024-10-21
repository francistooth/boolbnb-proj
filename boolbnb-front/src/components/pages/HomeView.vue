<script>

import axios from 'axios';
import { store } from '../../store';
import Searchbar from '../partials/Searchbar.vue';
import ApartmentCard from '../general/ApartmentCard.vue';
export default {
  name: "HomeView",
  components: {
    ApartmentCard,
    Searchbar

  },
  data() {
    return {
      store,
      apartments: [],
      sponsors: [],
    }
  },
  methods: {
    getAllapartments() {
      axios.get(store.apiUrl + 'appartamenti')
        .then(res => {
          if (res.data.success) {
            /* console.log(res.data.apartments); */
            let all = res.data.apartments;
            all.forEach(element => {
              if (element.sponsors.length > 0) {
                this.sponsors.push(element)
              } else {
                this.apartments.push(element)
              }
            });
          } else {
            this.$router.push({ name: '404' })
          }
        })
        .catch(err => { console.log(err.messages) })

    },

  },
  mounted() {
    /* console.log(store); */
    this.getAllapartments()
  }
}
</script>

<template>
  <Searchbar></Searchbar>
  <div class=" justify-content-center mt-5 pt-4 ">

    <h1 class="mx-5 text-center text-uppercase text-primary">Appartamenti in evidenza</h1>
    <div class="mx-4">
      <div class="row row-cols-lg-4 row-cols-1 flex-nowrap overflow-x-scroll">
        <ApartmentCard v-for="apartment in sponsors" :data="apartment" />
      </div>
    </div>
  </div>

</template>


<style lang="scss" scoped>
@use "../../styles/general.scss" as *;

//responsive:
/* 
toggle menu abbassa il jumbotrone
searchbar da ridurre
lista appartamenti da overflow-x-scrollable a scroll y
 */
</style>