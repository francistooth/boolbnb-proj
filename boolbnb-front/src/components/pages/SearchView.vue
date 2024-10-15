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
  <div class="container-fluid">
    <div class="row">
      <div class="col-7 myborder">
        <div class="d-flex flex-wrap justify-content-between mx-5 ">
          <ApartmentCard v-for="index in 12" class="my-2 boh"/>
        </div>
      </div>
      <div class="col-5">
        <Map />
      </div>
    </div>
    
  </div>
</template>

<style lang="scss" scoped>
@use "../../styles/general.scss" as *;

.myborder{
  border: 4px black solid;
  height: 1000px;
}
.boh{
    width: calc(100%/4 - 20px);
}
</style>
