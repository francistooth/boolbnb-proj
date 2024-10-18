<script>
import ApartmentCard from '../general/ApartmentCard.vue';
import axios from 'axios';
import { store } from '../../store';
export default {
  name: "HomeView",
  components: {
    ApartmentCard
  },
  data() {
    return {
      store,
      apartments: [],
      sponsors: [],
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
            });
          } else {
            this.$router.push({ name: '404' })
          }
        })
        .catch(err => { console.log(err.messages) })

    },

  },
  mounted() {
    console.log(store);
    this.getAllapartments()
  }
}
</script>

<template>
  <main>
    <div class="d-flex justify-content-center mt-5 pt-3">
      <div>

        <div class="d-flex justify-content-center">
          <form action="">
            <select class="border-0" name="" id="">
              <option class="w-50" value="1">Roma</option>
            </select>
            <button type="submit" class="btn btn-success">Cerca</button>
          </form>
        </div>
        <div>
          <h2 class="mx-5">Appartamenti in evidenza</h2>
          <div class="d-flex flex-wrap justify-content-between mx-5 ">
            <router_link class="sponsorcard" v-for="apartment in sponsors"
              :to="{ name: 'dettagli', params: { slug: apartment.slug } }">
              <ApartmentCard :data="apartment" />
            </router_link>

          </div>
        </div>
        <div class="d-flex flex-wrap justify-content-between mx-5 ">
          <router_link class="boh2" v-for="apartment in apartments"
            :to="{ name: 'dettagli', params: { slug: apartment.slug } }">
            <ApartmentCard :data="apartment" />
          </router_link>

        </div>
      </div>
    </div>
  </main>
</template>


<style lang="scss" scoped>
@use "../../styles/general.scss" as *;

.sponsorcard {
  width: calc(100%/5 - 20px);
  height: auto;
}


.boh2 {
  width: calc(100%/6 - 20px);
}
</style>