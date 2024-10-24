<script>

import ApartmentCard from '../general/ApartmentCard.vue';
import Map from '../partials/Map.vue';
import { store } from '../../store';
import axios from 'axios';
import CardSearch from '../general/CardSearch.vue';


export default {
  name: "SearchView",
  components: {
    ApartmentCard,
    CardSearch,
    Map
  },
  data() {
    return {
      store,
      apartments: [],
      apartmentSponsor: [],
      apartmentNoSponsor: [],
      sponsors: [],
      services: [],
      servicesfilter: [],
      addressFilter: '',
      roomFilter: 1,
      bedFilter: 1,
      radiusFilter: 20,
      coordinates: {
        lat: null,
        lon: null,
        name: null
      },
      suggests: []
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
              /* services: String(this.servicesfilter.join(',')), */
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
      console.log(this.$route.params);
      this.apartmentSponsor = [];
      this.apartmentNoSponsor = [];
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
          // Salva i risultati nel data
          this.apartments = response.data;
          this.loading = false;
          this.apartments.forEach(element => {
            if (element.sponsors.length > 0) {
              this.apartmentSponsor.push(element)
            } else {
              this.apartmentNoSponsor.push(element)
            }
            console.log(this.apartments);
          })
        })
        .catch(error => {
          console.error("Errore durante la ricerca degli appartamenti:", error);
          this.loading = false;
          if (error.response) {
            console.error('Dati:', error.response.data);
            console.error('Status:', error.response.status);
            console.error('Headers:', error.response.headers);
          }
        });
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
    /* this.servicesfilter = this.$route.params.services ? this.$route.params.services.split(',') : 'Nessun-servizio-selezionato'; */
    if (lat && lon) {
      console.log('Lat:', lat, 'Lon:', lon);
      // Puoi fare ulteriori operazioni qui con lat e lon
      this.searchApartmentfilter(lat, lon, rooms, beds, this.radiusFilter, this.addressFilter, services);

    } else {
      // Gestisci il caso in cui lat e lon non sono presenti
      console.log('Nessuna coordinata fornita.');
    }
  }
}
</script>



<template>

  <div class="container-fluid mt-5">
    <div class="row">
      <div class="col-12">
        <form class="container mb-2" action="">
          <div class="row">
            <div class="col-3 mb-3">
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
            <div class="col-3 mb-3">
              <label for="room-number" class="form-label">Numero di Stanze</label>
              <input type="number" class="form-control" id="room-number" v-model="roomFilter" min="1" @input="addFilter"
                onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
            </div>
            <div class=" col-3 mb-3">
              <label for="bed-number" class="form-label">Numero di Letti</label>
              <input type="number" class="form-control" id="bed-number" v-model="bedFilter" min="1" @input="addFilter"
                onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
            </div>
            <div class="col-3 mb-3">
              <label for="radiusfilter" class="form-label">Raggio di ricerca</label>
              <input type="number" class="form-control" id="radiusfilter" v-model="radiusFilter" @input="addFilter"
                onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
            </div>
            <div class="col-12 row row-cols-6 mt-a">
              <div v-for='service in services' class=" col d-line  mb-3">
                <input type="checkbox" class="d-block text-center" :id="service.name" :value="service.name"
                  v-model="servicesfilter" @change="addFilter">
                <label :for="service.name" class="form-label ">{{ service.name }}</label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class=" col-8 myborder ">

        <div class="ms-5">
          <router-link class="sponsorcard sponsor" v-for="apartment in apartmentSponsor"
            :to="{ name: 'dettagli', params: { slug: apartment.slug } }">
            <CardSearch :data="apartment" />
          </router-link>
          <router-link class="sponsorcard " v-for="apartment in apartmentNoSponsor"
            :to="{ name: 'dettagli', params: { slug: apartment.slug } }">
            <CardSearch :data="apartment" />
          </router-link>

        </div>
      </div>
      <div class="col-4">
        <Map v-if="coordinates.lat !== null && coordinates.lon !== null" :apartments="apartments"
          :coordinates="coordinates" class="mapborder"></Map>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../../styles/general.scss" as *;


.myborder {
  height: 80vh;
  overflow-y: scroll;
}

.mapborder {
  height: 80vh;
  width: 100%;
  border: 2px black solid;
}

.boh {
  width: calc(100%/4 - 20px);
}

.sponsorcard {
  width: calc(100%/5 - 20px);
  height: auto;
}

.sponsor {
  border: 2px solid gold;
}


.boh2 {
  width: calc(100%/6 - 20px);
}
</style>
