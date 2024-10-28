<script>

import axios from 'axios';
import { store } from '../../store';
import Searchbar from '../partials/Searchbar.vue';
import ApartmentCard from '../general/ApartmentCard.vue';
import Loader from '../partials/Loader.vue';
export default {
  name: "HomeView",
  components: {
    ApartmentCard,
    Searchbar,
    Loader,

  },
  data() {
    return {
      store,
      apartments: [],
      sponsors: [],
      loading: true,
    }
  },
  methods: {
    getAllapartments() {
      axios.get(store.apiUrl + 'appartamenti')
        .then(res => {
          if (res.data.success) {
            console.log(res.data.apartments);
            let all = res.data.apartments;
            all.forEach(element => {
              if (element.sponsors.length > 0) {
                this.sponsors.push(element)
              } else {
                this.apartments.push(element)
              }
              this.loading = false;
            });
          } else {
            this.$router.push({ name: '404' });
            this.loading = false;
          }
        })
        .catch(err => { console.log(err.messages) })

    },
    /*   getUser() {
        axios.get(store.apiUrl + 'utente')
          .then(res => {
            console.log(res.data);
            if (res.data.success) {
              console.log(res.data.user, 'guarda qui');
            } else {
              this.$router.push({ name: '404' })
            }
          })
          .catch(err => { console.error(err.response ? err.response.data : err.message); })
      }, */

  },
  mounted() {
    /* console.log(store); */
    this.getAllapartments()
    /* this.getUser() */
  }
}
</script>

<template>
  <Searchbar></Searchbar>
  <div class=" justify-content-center mt-5 pt-4 ">

    <h1 class="mx-5 text-center text-uppercase text-primary">Appartamenti in evidenza</h1>
    <div class="mx-4 my-5">
      <div id="card-container" class="row row-cols-lg-4 row-cols-1 flex-nowrap overflow-x-scroll">
        <Loader v-if="loading"/>
        <ApartmentCard v-else v-for="apartment in sponsors" :data="apartment" />
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

 #card-container{
    height: 425px;
 }
</style>