<script>
export default {
  name: 'Paginator',
  props: {
    data: Object
  },
  methods: {
    callApi(link) {
      console.log(link);
      this.$emit('callApi', link)
    }
  }
}
</script>


<template>
  <div class="paginator">
    <button class="btn btn-light mx-0 border" :class="link.active ? 'bg bg-primary opacity-100 text-light' : ''"
      v-for="(link, index) in data.links" :key="index" v-html="link.label" :disabled="link.active || !link.url"
      @click="callApi(link.url)"></button>
  </div>
</template>


<style lang="scss" scoped>
@use "../../styles/general.scss" as *;

.paginator {
  display: flex;
  justify-content: center;

  /*   .active {
    background-color: ;
  } */

  button {
    margin: 0 3px;


  }
}
</style>