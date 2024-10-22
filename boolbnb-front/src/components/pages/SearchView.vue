<script>

import ApartmentCard from '../general/ApartmentCard.vue';
import Map from '../partials/Map.vue';
import { store } from '../../store';
import axios from 'axios';

export default {
  name: "SearchView",
  components: {
    ApartmentCard,
    Map
  },
  data() {
    return {
      store,
      apartments: [],
      sponsors: [],
      services: [],
      servicesfilter: [],
      addressFilter: '',
      roomFilter: '',
      bedFilter: '',
      radiusFilter: '',

    }
  },
  computed: {
    filteredSponsors() {
      return this.sponsors.filter(apartment => {

        const matchesRooms = this.roomFilter === '' || apartment.room >= this.roomFilter;
        const matchesBeds = this.bedFilter === '' || apartment.bed >= this.bedFilter;
        return matchesAddress && matchesRooms && matchesBeds && matchesRadius;
      });
    },
    filteredApartments() {
      return this.apartments.filter(apartment => {
        const matchesRooms = this.roomFilter === '' || apartment.room >= this.roomFilter;
        const matchesBeds = this.bedFilter === '' || apartment.bed >= this.bedFilter;
        return matchesRooms && matchesBeds;
      });
    },
  },
  methods: {
    searchApartment(lat, lon) {
      const radius = 20;
      /*    if (this.radiusFilter != '') {
           radius = this.radiusFilter;
         } */

      console.log('Lat:', lat, 'Lon:', lon, 'Radius:', radius);


      axios.post('http://localhost:8000/api/appartamenti-nel-raggio', {
        lat: lat,
        lon: lon,
        radius: radius
      })
        .then(response => {
          // Salva i risultati nel data
          this.apartments = response.data;
          console.log(this.apartments);
        })
        .catch(error => {
          console.error("Errore durante la ricerca degli appartamenti:", error);
        });
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
              lon: String(this.lon)
            }

          })

          this.searchApartmentfilter(this.lat, this.lon, this.roomFilter, this.bedFilter, this.radiusFilter, this.addressFilter);
        })
        .catch(er => {
          console.log(er.message);
        })
    }, searchApartmentfilter(lat, lon, rooms, beds, radius, address) {

      if (radius) {
        radius = this.radiusFilter;
      } else {
        radius = 20;
      }
      console.log(this.$route.params);
      console.log('Lat:', lat, 'Lon:', lon, 'Radius:', radius, 'stanza', rooms, 'letti', beds, 'indirizzo', address);


      axios.post('http://localhost:8000/api/appartamenti-nel-raggio', {
        lat: lat,
        lon: lon,
        radius: radius
      })
        .then(response => {
          // Salva i risultati nel data
          this.apartments = response.data;

          console.log(this.apartments);
        })
        .catch(error => {
          console.error("Errore durante la ricerca degli appartamenti:", error);
        });
    },
  },
  mounted() {
    this.getservice();
    const lat = this.$route.params.lat;
    const lon = this.$route.params.lon;
    const beds = this.$route.params.beds;

    this.bedFilter = this.$route.params.beds;
    this.roomFilter = this.$route.params.rooms;
    this.radiusFilter = this.$route.params.radius;
    this.addressFilter = this.$route.params.address;

    if (lat && lon) {
      console.log('Lat:', lat, 'Lon:', lon);
      // Puoi fare ulteriori operazioni qui con lat e lon
      this.searchApartment(lat, lon);
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
              <input type="text" class="form-control" id="adressfilter" v-model="addressFilter" @change="addFilter">
            </div>
            <div class="col-3 mb-3">
              <label for="room-number" class="form-label">Numero di Stanze</label>
              <input type="number" class="form-control" id="room-number" v-model="roomFilter">
            </div>
            <div class=" col-3 mb-3">
              <label for="bed-number" class="form-label">Numero di Letti</label>
              <input type="number" class="form-control" id="bed-number" v-model="bedFilter">
            </div>
            <div class="col-3 mb-3">
              <label for="radiusfilter" class="form-label">Raggio di ricerca</label>
              <input type="number" class="form-control" id="radiusfilter" v-model="radiusFilter" @change="addFilter">
            </div>
            <div class="col-12 row row-cols-6 d-flex mt-0a">
              <div v-for='service in services' class=" col d-line  mb-3">
                <input type="checkbox" name="service[]" class="d-block text-center" :id="service.name"
                  :value="service.id" v-model="servicesfilter">
                <label :for="service.name" class="form-label ">{{ service.name }}</label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-8 myborder ">

        <div class="d-flex flex-wrap justify-content-between mx-5  ">
          <router-link class="sponsorcard" v-for="apartment in filteredApartments"
            :to="{ name: 'dettagli', params: { slug: apartment.slug } }">
            <ApartmentCard :data="apartment" />
          </router-link>
        </div>
      </div>
      <div class="col-4">
        <Map class="mapborder"></Map>
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


.boh2 {
  width: calc(100%/6 - 20px);
}
</style>
