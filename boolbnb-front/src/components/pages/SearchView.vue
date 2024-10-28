<script>

import ApartmentCard from '../general/ApartmentCard.vue';
import Map from '../partials/Map.vue';
import { store } from '../../store';
import axios from 'axios';
import CardSearch from '../general/CardSearch.vue';
import Loader from '../partials/Loader.vue';


export default {
  name: "SearchView",
  components: {
    ApartmentCard,
    CardSearch,
    Map,
    Loader,
  },
  data() {
    return {
      store,
      apartments: [],
      sponsors: [],
      services: [],
      servicesfilter: [],
      addressFilter: '',
      roomFilter: 1,
      bedFilter: 1,
      radiusFilter: 20,
      page: 1,
      pageApartments: 5,
      coordinates: {
        lat: null,
        lon: null,
        name: null
      },
      suggests: [],
      isLoading: true,
    }
  },
  methods: {
    getSuggest() {
      if (this.addressFilter != '') {
        axios.get('https://api.tomtom.com/search/2/geocode/' + this.addressFilter + '.json?key=M9AeCjwAbvaw4tXTx63ReRmUuBtIbnoZ&storeResult=false&limit=5&countrySet=IT&view=Unified&json&minFuzzyLevel=1')
          .then(result => {
            console.log(result.data)
            this.suggests = result.data.results;
          })
      }
    },
    useSuggest(index) {
      this.addressFilter = this.suggests[index].address.freeformAddress;
      this.suggests = [];
    },
    servicelog() {
      console.log(this.servicesfilter);

    },
    getservice() {
      axios.get(store.apiUrl + 'servizi')
        .then(res => {
          this.services = res.data.result
        }
        ).catch(error => {
          console.error("Errore durante la ricerca dei servizi", error);
        });
    },
    addFilter() {
      const cityName = this.addressFilter
      console.log(this.servicesfilter.join(','));
      const speranza = this.servicesfilter.join(',');
      axios.get('https://api.tomtom.com/search/2/geocode/' + cityName + '.json?key=M9AeCjwAbvaw4tXTx63ReRmUuBtIbnoZ&countrySet=IT')
        .then(res => {
          this.lat = res.data.results[0].position.lat;
          this.lon = res.data.results[0].position.lon;
        })
        .then(() => {
          this.$router.push({
            name: 'search',
            params: {
              address: String(this.addressFilter),
              rooms: String(this.roomFilter),
              beds: String(this.bedFilter),
              radius: String(this.radiusFilter),
              lat: String(this.lat),
              lon: String(this.lon),
              services: String(speranza),
            }
          })
          this.searchApartmentfilter(this.lat, this.lon, this.roomFilter, this.bedFilter, this.radiusFilter, this.addressFilter, speranza);
        })
        .catch(er => {
          console.log(er.message);
        })
    },
    searchApartmentfilter(lat, lon, rooms, beds, radius, address, services) {
      this.isLoading = true;
      console.log(this.$route.params);
      let apartmentSponsor = [];
      let apartmentNoSponsor = [];
      console.log('Lat:', lat, 'Lon:', lon, 'Radius:', radius, 'stanza', rooms, 'letti', beds, 'indirizzo', address, 'servizi', services);
      this.loading = true
      axios.post('http://localhost:8000/api/appartamenti-nel-raggio', {
        lat: lat,
        lon: lon,
        radius: radius,
        rooms: rooms,
        beds: beds,
        services: services
      })
        .then(response => {
          this.apartments = response.data;
          
          console.log(this.apartments);

          this.apartments.forEach(element => {
            if (element.is_visible) {
              if (element.sponsors.length > 0) {
                apartmentSponsor.push(element)
              } else {
                apartmentNoSponsor.push(element)
              }
              this.apartments = apartmentSponsor.concat(apartmentNoSponsor)
              console.log(this.apartments);
            }
            this.isLoading = false;
          })
        })
        .catch(error => {
          console.error("Errore durante la ricerca degli appartamenti:", error);
          this.isLoading = false;
          if (error.response) {
            console.error('Dati:', error.response.data);
            console.error('Status:', error.response.status);
            console.error('Headers:', error.response.headers);
          }
        });
    },
    // Metodo per andare alla pagina successiva
    nextPage() {
      if (this.page < this.pagineTotali) {
        this.page++;
      }
    },

    // Metodo per andare alla pagina precedente
    prevPage() {
      if (this.page > 1) {
        this.page--;
      }
    },
    changePage(index) {
      this.page = index;
      console.log(this.page);
    }
  }, computed: {
    // Calcola il numero totale di pagine
    pagineTotali() {
      return Math.ceil(this.apartments.length / this.pageApartments);
    },

    // Restituisce gli appartamenti della pagina corrente
    apartmentsOnPage() {
      const start = (this.page - 1) * this.pageApartments;
      const end = start + this.pageApartments;
      return this.apartments.slice(start, end);
    },
  },
  mounted() {
    this.getservice();
    const lat = this.$route.params.lat;
    const lon = this.$route.params.lon;
    const beds = this.$route.params.beds;
    const rooms = this.$route.params.rooms;
    const services = this.$route.params.services;
    this.coordinates.lat = this.$route.params.lat;
    this.coordinates.lon = this.$route.params.lon;
    this.coordinates.name = this.$route.params.address
    this.bedFilter = beds ? beds : this.bedFilter;
    this.roomFilter = this.$route.params.rooms ? this.$route.params.rooms : this.roomFilter;
    this.radiusFilter = this.$route.params.radius ? this.$route.params.radius : this.radiusFilter;
    this.addressFilter = this.$route.params.address;
    if (services) {
      const arrayServices = this.$route.params.services.split(',');
      this.servicesfilter = arrayServices;
    }

    if (lat && lon) {
      console.log('Lat:', lat, 'Lon:', lon);

      this.searchApartmentfilter(lat, lon, rooms, beds, this.radiusFilter, this.addressFilter, services);

    } else {

      console.log('Nessuna coordinata fornita.');
    }
  }
}
</script>



<template>
  <!-- mappa -->
  <div class="container-fluid mt-5">
    <div v-if="isLoading">
      <Loader />
    </div>
    <div v-else class="row">
      <div class="col-12 mb-3">
        <Map v-if="coordinates.lat !== null && coordinates.lon !== null" :apartments="apartments"
          :coordinates="coordinates" class="mapborder"></Map>
      </div>
      <!-- filtri -->
      <div class="col-3">
        <form class="container mb-2">
          <div class="row row-cols-1">
            <div class="col mb-1">
              <label for="adressfilter" class="form-label">Indirizzo</label>
              <div class="position-relative">
                <input type="text" class="form-control" id="adressfilter" v-model="addressFilter" @input="addFilter"
                  @keyup="getSuggest">
                <ul class="list-group position-absolute top-100 start-0 z-2" v-if="this.suggests.length > 0">
                  <li class="list-group-item" v-for="suggest, index in suggests" :key="index" @click="addFilter">
                    <a href="#" @click="searchCoordinate(useSuggest(index))">{{ suggest.address.freeformAddress }}</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col mb-1">
              <label for="room-number" class="form-label">Numero di Stanze</label>
              <input type="number" class="form-control w-25" id="room-number" v-model="roomFilter" min="1"
                @input="addFilter"
                onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
            </div>
            <div class=" col mb-1">
              <label for="bed-number" class="form-label">Numero di Letti</label>
              <input type="number" class="form-control w-25" id="bed-number" v-model="bedFilter" min="1"
                @input="addFilter"
                onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
            </div>
            <div class="col mb-1">
              <label for="radiusfilter" class="form-label">Raggio di ricerca</label>
              <input type="number" class="form-control w-25" id="radiusfilter" v-model="radiusFilter" @input="addFilter"
                onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
            </div>
            <div class="col ">
              <p class="m-0">Servizi:</p>
              <ul class="row row-cols-1 p-1">
                <li v-for='service in services' class=" col d-line text-nowrap ">
                  <input type="checkbox" :id="service.name" :value="service.name" v-model="servicesfilter"
                    @change="addFilter">
                  <label :for="service.name" class="form-label ">{{ service.name }}</label>
                </li>
              </ul>
            </div>
          </div>
        </form>
      </div>
      <!-- risultato ricerca appartamenti -->
      <div class="col-9 ">

        <div v-if="apartments.length > 0">
          <h2>{{ this.apartments.length }} appartamenti corrispondono alla tua ricerca </h2>
          <router-link v-for="apartment in apartmentsOnPage"
            :to="{ name: 'dettagli', params: { slug: apartment.slug } }">
            <CardSearch :data="apartment" />
          </router-link>

          <!-- guarda qui -->
          <nav v-if="pagineTotali > 1" aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item" :class="page == 1 ? 'disabled' : ''">
                <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <li @click="changePage(index)" v-for="index in pagineTotali" class="page-item"
                :class="page == index ? 'active' : ''">
                <a class="page-link" href="#">{{ index }}</a>
              </li>
              <li @click="nextPage" class="page-item" :class="page == pagineTotali ? 'disabled' : ''">
                <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <div v-else>
          <h2>Spiacente Non trattiamo appartamenti in questa zona</h2>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../../styles/general.scss" as *;

.mapborder {
  height: 400px;
  width: 80%;
  margin: auto;
  border: 2px grey solid;
}

ul {
  list-style: none;
}
</style>
