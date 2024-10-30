<script>

import HeaderView from './components/HeaderView.vue'
import FooterView from './components/FooterView.vue'


export default {
  components: {
    HeaderView,
    FooterView,

  }
}

</script>

<template>
  <header>
    <div class="d-flex justify-content-between  align-items-center ">

      <HeaderView />

    </div>
  </header>
  <main>
    <RouterView />
  </main>
  <FooterView />

</template>

<style lang="scss" scoped>
header {
  margin: 0;
}

header,
main,
footer {
  min-width: 300px;
}
</style>
