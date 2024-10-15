<script>
import { onMounted, ref } from 'vue';
export default {
  name: 'Map',
  setup() {
    const mapRef = ref(null);
    function addMarker(map) {
      const tt = window.tt;
      var location = [10.9200867, 44.6488366];
      var popupOffset = 25;

      var marker = new tt.Marker().setLngLat(location).addTo(map);
      var popup = new tt.Popup({ offset: popupOffset }).setHTML("Your address!");
      marker.setPopup(popup).togglePopup();
    }
    function addMarker2(map) {
      const tt = window.tt;
      var location = [11.3426163, 44.494887];
      var popupOffset = 25;

      var marker = new tt.Marker().setLngLat(location).addTo(map);
      var popup = new tt.Popup({ offset: popupOffset }).setHTML("Bologna");
      marker.setPopup(popup).togglePopup();
    }
    onMounted(() => {
      const tt = window.tt;
      var map = tt.map({
        key: 'gBSPk0bCa3RCfPcr4yCwWYQfk59mSmXo',
        container: mapRef.value,
        style: 'tomtom://vector/1/basic-main',
      });
      map.addControl(new tt.FullscreenControl());
      map.addControl(new tt.NavigationControl());
      addMarker(map);
      addMarker2(map);
    })
    return {
      mapRef,
    };
  }
}

</script>




<template>
  
  <div id='map' ref="mapRef"></div>
</template>

<style>
#map {
  height: 50vh;
  width: 50vw;
}
</style>