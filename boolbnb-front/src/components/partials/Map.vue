<script>
import { onMounted, ref, toRefs, watch } from 'vue';

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
    /* Converte le props in dati dinamici */
    const { apartments, coordinates } = toRefs(props);
    const mapRef = ref(null);
    let map = null;
    const markers = [];

    /* permette di aggiungere marcatori sulla mappa  */
    function addMarker(location, popupText) {
      const tt = window.tt;
      const popupOffset = 25;
      const marker = new tt.Marker().setLngLat(location).addTo(map);
      const popup = new tt.Popup({ offset: popupOffset }).setHTML(popupText);
      marker.setPopup(popup).togglePopup();
      markers.push(marker);
    }

    function removeMarkers() {
      /*  Rimuovi i marker esistenti */
      markers.forEach(marker => marker.remove());
      markers.length = 0;
    }

    /* controlla l'aggiornarsi della mappa */
    function updateMap() {
      if (map) {
        removeMarkers();
        const centralLocation = [coordinates.value.lon, coordinates.value.lat];
        const bounds = new tt.LngLatBounds();
        bounds.extend(centralLocation);

        addMarker(centralLocation, 'Punto centrale: ' + coordinates.value.name);

        /* creazione dei marcatori per ogni appartamento fornito */
        apartments.value.forEach(apartment => {
          const coordinatesArray = apartment.coordinate.split(',').map(coord => parseFloat(coord.trim()));
          const apartmentLocation = [coordinatesArray[0], coordinatesArray[1]];
          addMarker(apartmentLocation, apartment.title);
          bounds.extend(apartmentLocation);
        });

        /* centra la mappa con tutti i marcatori */
        map.fitBounds(bounds, { padding: 50 });
      }
    }

    onMounted(() => {
      const tt = window.tt;
      map = tt.map({
        key: 'gBSPk0bCa3RCfPcr4yCwWYQfk59mSmXo',
        container: mapRef.value,
        style: 'tomtom://vector/1/basic-main',
      });


      map.addControl(new tt.FullscreenControl()); /*  fullscreen */
      map.addControl(new tt.NavigationControl()); /*  Controllo per la navigazione */

      /* aggiorna la mappa */
      map.on('load', updateMap);
    });

    /*  osserva le modifiche alle props apartments e coordinates tenendo la mappa aggiornata */
    watch([apartments, coordinates], updateMap);

    return {
      mapRef
    };
  }
}
</script>

<template>
  <div id='map' ref="mapRef"></div>
</template>

<style></style>
