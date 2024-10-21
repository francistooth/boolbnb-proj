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
    }
  },
  methods: {
    searchApartment(lat, lon){
            const radius = 20;
            console.log('Lat:', lat, 'Lon:', lon, 'Radius:', radius);


            axios.post('http://localhost:8001/api/appartamenti-nel-raggio', {
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
        }
    /* getAllapartments() {
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
            });
          } else {
            this.$router.push({ name: '404' })
          }
        })
        .catch(err => { console.log(err.messages) })
    }, */

  },
  mounted() {
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
        <form class="container" action="">
          <div class="row">
            <div class="col-3 mb-3">
              <label for="formGroupExampleInput" class="form-label">Indirizzo</label>
              <input type="text" class="form-control" id="formGroupExampleInput"
                placeholder="Example input placeholder">
            </div>
            <div class="col-3 mb-3">
              <label for="formGroupExampleInput2" class="form-label">Numero di Stanze</label>
              <input type="number" class="form-control" id="formGroupExampleInput2"
                placeholder="Another input placeholder">
            </div>
            <div class=" col-3 mb-3">
              <label for="formGroupExampleInput2" class="form-label">Numero di Letti</label>
              <input type="number" class="form-control" id="formGroupExampleInput2"
                placeholder="Another input placeholder">
            </div>
            <div class="col-3 mb-3">
              <label for="formGroupExampleInput2" class="form-label">Raggio di ricerca</label>
              <input type="number" class="form-control" id="formGroupExampleInput2" placeholder="20">
            </div>
            <div class="col-12 d-flex mt-0a">
              <div class="mb-3">
                <input type="checkbox" name="wifi" id="">
                <label for="formGroupExampleInput2" class="form-label">Wifi</label>
              </div>
              <div class="mb-3">
                <input type="checkbox" name="piscina" id="">
                <label for="formGroupExampleInput2" class="form-label">Piscina</label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-7 myborder ">
        <div class="my-3">
          Campo con filtri

        </div>
        <div class="d-flex flex-wrap justify-content-between mx-5  ">
          <router-link class="sponsorcard" v-for="apartment in sponsors"
            :to="{ name: 'dettagli', params: { slug: apartment.slug } }">
            <ApartmentCard :data="apartment" />
          </router-link>
          <router-link class="boh2" v-for="apartment in apartments"
            :to="{ name: 'dettagli', params: { slug: apartment.slug } }">
            <ApartmentCard :data="apartment" />
          </router-link>
        </div>
      </div>
      <div class="col-5">
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
