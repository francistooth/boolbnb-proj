<script>
import { onMounted, ref } from 'vue';
export default {
  name: 'Map',
  props: {
    array: Array,
    cordinate: Object
  },
  setup() {

    /*  console.log(this.props); */

    const mapRef = ref(null);

    // Log the props value


    function addMarker(map, location, popupText) {
      const tt = window.tt;
      var popupOffset = 25;

      var marker = new tt.Marker().setLngLat(location).addTo(map);
      var popup = new tt.Popup({ offset: popupOffset }).setHTML(popupText);
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

      // Centra i marker solo dopo che la mappa è completamente caricata
      map.on('load', function () {
        const centralLocation = [props.cordinate.lon, props.cordinate.lat];

        // Aggiungi il marker per l'indirizzo centrale
        addMarker(map, centralLocation, 'Punto centrale: ' + props.cordinate.title);

        let bounds = new tt.LngLatBounds();
        bounds.extend(centralLocation);

        // Aggiungi marker per ogni appartamento
        props.apartments.forEach(apartment => {
          const apartmentLocation = JSON.parse(apartment.coordinates);
          addMarker(map, apartmentLocation, apartment.title);
          bounds.extend(apartmentLocation);
        });

        // Centra la mappa sui marker
        map.fitBounds(bounds, { padding: 50 });
      });
    });

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
/* #map {
  height: 100vh;
} */
</style>
