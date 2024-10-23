<script>
import { onMounted, ref, toRefs } from 'vue';

export default {
  name: 'Map',
  props: {
    apartments: {
      type: Array,
      required: true
    },
    coordinates: {
      type: Object,
      required: true
    }
  },
  setup(props) {
    const { apartments, coordinates } = toRefs(props);
    const mapRef = ref(null);

    function addMarker(map, location, popupText) {
      const tt = window.tt;
      const popupOffset = 25;

      const marker = new tt.Marker().setLngLat(location).addTo(map);
      const popup = new tt.Popup({ offset: popupOffset }).setHTML(popupText);
      marker.setPopup(popup).togglePopup();
    }

    onMounted(() => {
      const tt = window.tt;
      const map = tt.map({
        key: 'gBSPk0bCa3RCfPcr4yCwWYQfk59mSmXo', // Sostituisci con la tua chiave API
        container: mapRef.value,
        style: 'tomtom://vector/1/basic-main',
      });

      map.addControl(new tt.FullscreenControl());
      map.addControl(new tt.NavigationControl());

      map.on('load', () => {
        // Aggiungi il marker per la posizione centrale
        const centralLocation = [coordinates.value.lon, coordinates.value.lat];
        addMarker(map, centralLocation, 'Punto centrale: ' + coordinates.value.name);

        // Crea un bounds per centrare la mappa sui marker
        const bounds = new tt.LngLatBounds();
        bounds.extend(centralLocation);

        // Aggiungi i marker per gli appartamenti
        apartments.value.forEach(apartment => {
          // Separiamo le coordinate e le convertiamo in numeri
          const coordinatesArray = apartment.coordinate.split(',').map(coord => parseFloat(coord.trim()));
          const apartmentLocation = [coordinatesArray[0], coordinatesArray[1]]; // [lon, lat]

          addMarker(map, apartmentLocation, apartment.title); // Usa apartment.title come popup
          bounds.extend(apartmentLocation);
        });


        // Centra la mappa sui marker
        map.fitBounds(bounds, { padding: 50 });
      });
    });

    return {
      mapRef
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
