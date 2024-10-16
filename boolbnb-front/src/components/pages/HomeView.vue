<script>
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
            <ApartmentCard v-for="index in 8" class="my-2 sponsorcard" />
          </div>
        </div>
        <div class="d-flex flex-wrap justify-content-between mx-5 ">
          <ApartmentCard v-for="index in 12" class="my-2 boh2" />
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