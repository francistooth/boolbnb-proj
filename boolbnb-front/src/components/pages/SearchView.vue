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
      radiusFilter: '5',
      wifiFilter: false,
      poolFilter: false,
    }
  },
  computed: {
    filteredSponsors() {
      return this.sponsors.filter(apartment => {
        const matchesAddress = this.addressFilter === '' || apartment.address.toLowerCase().includes(this.addressFilter);
        const matchesRooms = this.roomFilter === '' || apartment.room === this.roomFilter;
        const matchesBeds = this.bedFilter === '' || apartment.bed === this.bedFilter;
        const matchesRadius = this.radiusFilter === '' || apartment.distance <= this.radiusFilter;

        return matchesAddress && matchesRooms && matchesBeds && matchesRadius;
      });
    },
    filteredApartments() {
      return this.apartments.filter(apartment => {
        const matchesAddress = this.addressFilter === '' || apartment.address.toLowerCase().includes(this.addressFilter);
        const matchesRooms = this.roomFilter === '' || apartment.room === this.roomFilter;
        const matchesBeds = this.bedFilter === '' || apartment.bed === this.bedFilter;
        const matchesRadius = this.radiusFilter === '' || apartment.distance <= this.radiusFilter;

        return matchesAddress && matchesRooms && matchesBeds && matchesRadius;
      });
    },
  },
  methods: {
    searchApartment(lat, lon) {
      const radius = 20;
      console.log('Lat:', lat, 'Lon:', lon, 'Radius:', radius);


      axios.post('http://localhost:8000/api/appartamenti-nel-raggio', {
        lat: lat,
        lon: lon,
        radius: radius
      })
        .then(response => {
          // Salva i risultati nel data
          console.log(response.data);
          this.apartments = response.data;
          console.log(response.data);
        })
        .catch(error => {
          console.error("Errore durante la ricerca degli appartamenti:", error);
        });
    },
    getservice() {
      axios.get(store.apiUrl + 'servizi')
        .then(res => {
          this.services = res.data.result,
            console.log(res.data.result)
        }

        ).catch(error => {
          console.error("Errore durante la ricerca dei servizi", error);
        });
    }
    /* addFilter(){
            axios.get('https://api.tomtom.com/search/2/geocode/' + this.addressFilter + '.json?key=M9AeCjwAbvaw4tXTx63ReRmUuBtIbnoZ&countrySet=IT')
                .then(res =>{
                    this.lat = res.data.results[0].position.lat;
                    this.lon = res.data.results[0].position.lon;
                    this.coordinateInput = lon + ', ' + lat;
                    
                })
                .catch(er => {
                    console.log(er.message);
                })
      
    } */
  },
  mounted() {
    this.getservice();
    const lat = this.$route.params.lat;
    const lon = this.$route.params.lon;

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
              <input type="text" class="form-control" id="adressfilter" placeholder="Example input placeholder"
                v-model="addressFilter">
            </div>
            <div class="col-3 mb-3">
              <label for="room-number" class="form-label">Numero di Stanze</label>
              <input type="number" class="form-control" id="room-number" placeholder="Es.2" v-model="roomFilter">
            </div>
            <div class=" col-3 mb-3">
              <label for="bed-number" class="form-label">Numero di Letti</label>
              <input type="number" class="form-control" id="bed-number" placeholder="Es.3" v-model="bedFilter">
            </div>
            <div class="col-3 mb-3">
              <label for="radiusfilter" class="form-label">Raggio di ricerca</label>
              <input type="number" class="form-control" id="radiusfilter" placeholder="20" v-model="radiusFilter">
            </div>
            <div class="col-12 row row-cols-6 d-flex mt-0a">
              <div v-for='service in services' class=" col d-line  mb-3">
                <input type="checkbox" name="service[]" class="d-block text-center" :id="service.name"
                  :value="service.id" v-model="servicesfilter">
                <label :for="service.name" class="form-label ">{{ service.name }}</label>
              </div>

            </div>
          </div>
          <button class="btn btn-danger" type="submit" @click.prevent="addFilter()">Ricerca</button>
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
