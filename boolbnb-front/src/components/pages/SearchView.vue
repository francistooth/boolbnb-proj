<script>
import ApartmentCard from '../general/ApartmentCard.vue';
import Map from '../partials/Map.vue';

export default {
  name: "SearchView",
  components: {
    ApartmentCard,
    Map
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
          <ApartmentCard v-for="index in 12" class="my-2 boh" />
        </div>
      </div>
      <div class="col-5">
        <Map class="mapborder" />
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
</style>
