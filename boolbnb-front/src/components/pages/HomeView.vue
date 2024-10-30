<script>
import axios from 'axios';
import { store } from '../../store';
import Searchbar from '../partials/Searchbar.vue';
import ApartmentCard from '../general/ApartmentCard.vue';
import Loader from '../partials/Loader.vue';

// swiper 

// import function to register Swiper custom elements
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import { register } from 'swiper/element/bundle';
import { Autoplay, Pagination } from 'swiper/modules';
// register Swiper custom elements
register();

export default {
  name: "HomeView",
  components: {
    ApartmentCard,
    Searchbar,
    Loader,
    Swiper,
    SwiperSlide
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
  setup() {
      return {
        modules: [Pagination],
      }
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
    <div class="mx-4 my-5">
      <Loader v-if="!isLoaded" />
      <swiper-container v-else
        :slidesPerView="4 "
        :spaceBetween="30"
        :pagination="{
            clickable: true,
        }"
        :breakpoints="{
            1024: { slidesPerView: 4 },
            768: { slidesPerView: 3 },
            640: { slidesPerView: 2 },
            320: { slidesPerView: 1 },
        }"
        :navigation="true"
        :autoplay="{
            delay: 1500,
            disableOnInteraction: false,
        }"
        :loop="true"
        :modules="modules"
        class="mySwiper mx-auto text-center my-5"
    >
       <swiper-slide v-for="apartment in sponsors" :key="apartment.id"><ApartmentCard :data="apartment" /></swiper-slide>
    </swiper-container>
    </div>
  </div>

    
</template>

<style lang="scss" scoped>
@use "../../styles/general.scss" as *;

swiper-container {
    width: 80%;
}

</style>
