<script>

import HeaderView from './components/HeaderView.vue'
import FooterView from './components/FooterView.vue'

export default {
  components: {
    HeaderView,
    FooterView
  }
}

</script>

<template>

  <div class="container-fluid">
    <header>
      <div class="d-flex justify-content-between mx-3 align-items-center mt-3">
        <HeaderView />
      </div>
    </header>
    <main>
      <RouterView />
    </main>
    <FooterView />
  </div>
</template>

<style lang="scss" scoped>
main {
  margin-top: 170px;
}
</style>
