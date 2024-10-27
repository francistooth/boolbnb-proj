<script>
import { store } from '../../store';
import Map from '../partials/Map.vue';
import Mail from '../partials/Mail.vue';
import axios from 'axios';
export default {
  name: "ApartmentCard",
  components: {
    Map,
    Mail
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
      }
    }

  },
  methods: {
    incrementVisit(apartmentId) {
      console.log('API URL:', store.apiUrl);
      console.log('Apartment ID:', apartmentId);
      const data = {
        apartment_id: apartmentId
      };
      axios.post(store.apiUrl + 'visite', data)
        .then(response => {
          console.log(response.data.message);
        })
        .catch(error => {
          console.error("Errore nell'incrementare la visita:", error);
        })
    },
    getApi(slug) {

      axios.get(store.apiUrl + 'dettaglio/' + slug)
        .then(res => {
          if (res.data.success) {

            this.apartment = res.data.apartment;
            let lonLan = this.apartment.coordinate.split(',').map(coord => coord.trim());
            console.log(lonLan);
            this.coordinates.lon = lonLan[0];
            this.coordinates.lat = lonLan[1];
            this.coordinates.name = this.apartment.title;
            console.log(this.coordinates)

            this.incrementVisit(this.apartment.id)
          } else {
            console.log('errore 404');
            this.$router.push({ name: '404' })
          }
        })
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
    <div class="row house-card d-flex">
      <div class=" house-card-hader col-sm-12 col-lg-7">
        <h2 class="title text-primary">{{ apartment.title }} </h2>
        <h6 class="subtitle text-primary"> {{ apartment.address }} </h6>
        <h5 class="description text-primary">{{ apartment.description }}</h5>
        <div class="img-container d-flex justify-content-center mx-lg-5 my-4">
          <img class="img-fluid" :src="apartment.img_path" :alt="apartment.img_name">
        </div>
        <div class="house-card-body mb-3">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-details-tab" data-bs-toggle="tab" data-bs-target="#nav-details"
                type="button" role="tab" aria-controls="nav-details" aria-selected="true">Caratteristiche</button>
              <button class="nav-link" id="nav-profile-services" data-bs-toggle="tab" data-bs-target="#nav-services"
                type="button" role="tab" aria-controls="nav-services" aria-selected="false">Servizi aggiuntivi</button>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">
              <div class="services row row-cols-2 row-cols-lg-4 mt-2">
                <div class="service border-light  col d-flex justify-content-center p-lg-3  d-flex">
                  <div class="label  d-flex">
                    <i class="fas fa-bed"></i>
                    <h6 class="d-sm-none d-lg-block">letti</h6>:
                  </div>
                  <div class="service-value">{{ apartment.bed }}</div>
                </div>
                <div class="service border-light  col d-flex justify-content-center p-lg-3">
                  <div class="label d-flex">
                    <i class="fa-solid fa-bath"></i>
                    <h6 class="d-sm-none d-lg-block">bagni</h6>:
                  </div>
                  <div class="service-value">{{ apartment.bathroom }}</div>
                </div>
                <div class="service border-light  col d-flex justify-content-center p-lg-3">
                  <div class="label d-flex">
                    <i class="fa-solid fa-people-roof"></i>
                    <h6 class="d-sm-none d-lg-block">stanze</h6>:
                  </div>
                  <div class="service-value">{{ apartment.room }}</div>
                </div>
                <div class="service border-light  col d-flex justify-content-center p-lg-3">
                  <div class="label d-flex">
                    <i class="fa-solid fa-ruler-combined"></i>
                    <h6 class="d-sm-none d-lg-block">mq</h6>:
                  </div>
                  <div class="service-value">{{ apartment.sqm }}</div>
                </div>
              </div>

            </div>
            <div class="tab-pane fade" id="nav-services" role="tabpanel" aria-labelledby="nav-profile-services">
              <div class="py-4">
                <div class="row">
                  <div class="col label d-flex align-items-start" v-for="service in apartment.services">
                    <i class="" :class="service.icon"></i>
                    <p class="d-sm-none d-lg-block small text-nowrap">: {{ service.name }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="message-card col-sm-12 col-lg-5 pt-5">
        <Map v-if="coordinates.lat !== null && coordinates.lon !== null" :coordinates="coordinates"
          class="mapborder"></Map>
        <Mail :slug="apartment.slug">
        </Mail>
      </div>
    </div>
  </section>
</template>


<style lang="scss" scoped>
// @use "../../styles/general.scss" as *;
.img-container {
  aspect-ratio: 5/3;
  background-color: rgba(88, 88, 81, 0.226);

  img {
    height: 100%;
  }
}

.mapborder {
  height: 300px;
  width: 300px;
  margin: auto;
}
</style>