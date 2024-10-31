<script>
import { store } from '../../store';
import Map from '../partials/Map.vue';
import Mail from '../partials/Mail.vue';
import axios from 'axios';
import Loader from '../partials/Loader.vue';

export default {
  name: "ApartmentCard",
  components: {
    Map,
    Mail,
    Loader,
  },
  data() {
    return {
      store,
      apartment: {
        id: '',
        title: '',
        description: '',
        room: '',
        bed: '',
        bathroom: '',
        sqm: '',
        address: '',
        coordinate: '',
        img_path: '',
        img_name: '',
        is_visible: '',
        services: []
      },
      coordinates: {
        lat: null,
        lon: null,
        name: null
      },
      isLoaded: false // Variabile per il caricamento
    }
  },
  methods: {
    incrementVisit(apartmentId) {
      const data = { apartment_id: apartmentId };
      axios.post(store.apiUrl + 'visite', data)
        .then(response => console.log(response.data.message))
        .catch(error => console.error("Errore nell'incrementare la visita:", error));
    },
    getApi(slug) {
      axios.get(store.apiUrl + 'dettaglio/' + slug)
        .then(res => {
          if (res.data.success) {
            this.apartment = res.data.apartment;
            console.log(this.apartment);

            let lonLan = this.apartment.coordinate.split(',').map(coord => coord.trim());
            this.coordinates.lon = lonLan[0];
            this.coordinates.lat = lonLan[1];
            this.coordinates.name = this.apartment.title;

            this.incrementVisit(this.apartment.id);

            this.isLoaded = true; // Dati caricati
          } else {
            this.$router.push({ name: '404' });
          }
        })
        .catch(() => this.$router.push({ name: '404' }));
    }
  },
  mounted() {
    const slug = this.$route.params.slug;
    this.getApi(slug);
  }
}
</script>

<template>
  <section class="container mt-5">
    <!-- Mostra il Loader finché i dati non sono caricati -->
    <Loader v-if="!isLoaded" />
    <div v-else class="row house-card d-flex">
      <div class="house-card-hader col-sm-12 col-lg-7">
        <h2 class="title text-primary">{{ apartment.title }} </h2>
        <h6 class="subtitle "> Indirizzo:{{ apartment.address }}</h6>

        <div class="img-container d-flex justify-content-center mx-lg-5 my-4">
          <img class="img-fluid" :src="apartment.img_path" :alt="apartment.img_name">
        </div>
        <h5 class="description ">{{ apartment.description }}</h5>
        <!-- Dettagli appartamento e servizi -->
        <p>Proprietario: {{ apartment.user.name }} {{ apartment.user.surname }}</p>
        <p> {{ apartment.visits.length }} Visualizzazioni</p>
        <div class="house-card-body mb-3">
          <!-- Tab nav -->
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-details-tab" data-bs-toggle="tab" data-bs-target="#nav-details"
                type="button" role="tab" aria-controls="nav-details" aria-selected="true">Caratteristiche</button>
              <button class="nav-link" id="nav-profile-services" data-bs-toggle="tab" data-bs-target="#nav-services"
                type="button" role="tab" aria-controls="nav-services" aria-selected="false">Servizi aggiuntivi</button>
            </div>
          </nav>
          <!-- Tab content -->
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">
              <div class="services row row-cols-2 row-cols-lg-4 mt-2">
                <div class="service border-light col d-flex justify-content-center align-items-center p-lg-3">
                  <div class="label d-flex ">
                    <i class="fas fa-bed"></i>
                    <h6 class="d-lg-block px-2">letti: {{ apartment.bed }}</h6>
                  </div>
                </div>
                <div class="service border-light col d-flex justify-content-center align-items-center p-lg-3">
                  <div class="label d-flex ">
                    <i class="fa-solid fa-bath"></i>
                    <h6 class="d-lg-block px-2">bagni: {{ apartment.bathroom }}</h6>
                  </div>
                </div>
                <div class="service border-light col d-flex justify-content-center align-items-center p-lg-3">
                  <div class="label d-flex">
                    <i class="fa-solid fa-people-roof"></i>
                    <h6 class="d-lg-block px-2">stanze: {{ apartment.room }}</h6>
                  </div>
                </div>
                <div class="service border-light col d-flex justify-content-center align-items-center p-lg-3">
                  <div class="label d-flex">
                    <i class="fa-solid fa-ruler-combined"></i>
                    <h6 class="d-lg-block px-2">mq: {{ apartment.sqm }}</h6>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="nav-services" role="tabpanel" aria-labelledby="nav-profile-services">
              <div class="py-4">
                <div class="row">
                  <div class="col label d-flex align-items-baseline" v-for="service in apartment.services"
                    :key="service.id">
                    <i :class="service.icon"></i>
                    <p class="d-lg-block small text-nowrap ms-1"> {{ service.name }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class=" col-sm-12 col-lg-5 pt-5 text-center">
        <div class="pb-5">
          <button class="btn btn-primary " type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Scrivi al
            Proprietario</button>

          <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
            aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body ">
              <Mail :slug="apartment.slug"></Mail>
            </div>
          </div>
        </div>
        <Map v-if="coordinates.lat !== null && coordinates.lon !== null" :coordinates="coordinates"
          class="mapborder"></Map>

      </div>
    </div>
  </section>
</template>

<style lang="scss" scoped>
section {
  .img-container {
    aspect-ratio: 5/3;


    img {
      height: 100%;
    }
  }

  .mapborder {
    height: 300px;
    width: 300px;
    margin: auto;
    margin-bottom: 40px;
  }

  .offcanvas-body {
    height: 100vh;
  }
}
</style>
