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

  <header>
    <div class="d-flex justify-content-between mx-3 align-items-center">
      <RouterLink to="/"><img src="./assets/logo_boolbn.png" width="75" height="75" /></RouterLink>
      
      <HeaderView />
    </div>
    

    
      
      
      
    
  </header>
  <RouterView />
  
  <FooterView />
</template>

<style lang="scss" scoped>
 
</style>
