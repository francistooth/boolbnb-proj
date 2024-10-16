<script >
import ApartmentCard from '../general/ApartmentCard.vue';

export default {
  name: "HomeView",
  components: {
    ApartmentCard
  }
}
</script>

<template>
  <main>
    <div class="d-flex justify-content-center mt-5 pt-3">
      <div>
        
        <div class="d-flex flex-wrap justify-content-between mx-5 ">
          <ApartmentCard v-for="index in 8" class="my-2 boh"/>
        </div>
        <div class="d-flex flex-wrap justify-content-between mx-5 ">
          <ApartmentCard v-for="index in 12" class="my-2 boh2"/>
        </div>
      </div>
    </div>
  </main>
</template>


<style lang="scss" scoped>
@use "../../styles/general.scss" as *;
.boh{
    width: calc(100%/4 - 20px);
}
.boh2{
    width: calc(100%/6 - 20px);
}

</style>