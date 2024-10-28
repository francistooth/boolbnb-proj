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
      isLoaded: false,
    }
  },
  methods: {
    getAllapartments() {
      this.isLoaded = false;
      axios.get(store.apiUrl + 'appartamenti')
        .then(res => {
          if (res.data.success) {
            let all = res.data.apartments;
            all.forEach(element => {
              if (element.sponsors.length > 0) {
                this.sponsors.push(element);
              } else {
                this.apartments.push(element);
              }
            });
          } else {
            this.$router.push({ name: '404' });
          }
          this.isLoaded = true;
        })
        .catch(err => { 
          console.log(err.messages);
          this.isLoaded = true;
        });
    },
  },
  mounted() {
    this.getAllapartments();
  }
}
</script>

<template>
  <Searchbar />
  <div class="justify-content-center mt-5 pt-4">
    <h1 class="mx-5 text-center text-uppercase text-primary">Appartamenti in evidenza</h1>
    <div id="card-container" class="mx-4 my-5">
      <Loader v-if="!isLoaded" />
      <div v-else id="card-container" class="row row-cols-lg-4 row-cols-1 flex-nowrap overflow-x-scroll">
        <ApartmentCard v-for="apartment in sponsors" :key="apartment.id" :data="apartment" />
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../../styles/general.scss" as *;

#card-container {
  min-height: 425px;
}
</style>
