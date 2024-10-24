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
    const markers = []; // Array per tenere traccia dei marker
    let centralMarker = null; // Variabile per il marker centrale

    /* permette di aggiungere marcatori sulla mappa */
    function addMarker(location, popupText) {
      const tt = window.tt;
      const popupOffset = 25;
      const marker = new tt.Marker().setLngLat(location).addTo(map);
      const popup = new tt.Popup({ offset: popupOffset }).setHTML(popupText);
      marker.setPopup(popup).togglePopup();
      markers.push(marker); // Aggiungi il marker all'array
      return marker; // Restituisci il marker (se necessario)
    }

    function removeMarkers() {
      /* Rimuovi i marker esistenti */
      markers.forEach(marker => marker.remove());
      markers.length = 0; // Pulisci l'array dei marker

      if (centralMarker) {
        centralMarker.remove(); // Rimuovi il marker centrale se esiste
        centralMarker = null; // Reset della variabile del marker centrale
      }
    }

    /* controlla l'aggiornarsi della mappa */
    function updateMap() {
      if (map) {
        removeMarkers(); // Rimuovi tutti i marker esistenti
        const centralLocation = [coordinates.value.lon, coordinates.value.lat];
        const bounds = new tt.LngLatBounds();
        bounds.extend(centralLocation);

        // Aggiungi il nuovo marker centrale
        centralMarker = addMarker(centralLocation, 'Punto centrale: ' + coordinates.value.name);

        /* creazione dei marcatori per ogni appartamento fornito */
        apartments.value.forEach(apartment => {
          const coordinatesArray = apartment.coordinate.split(',').map(coord => parseFloat(coord.trim()));
          const apartmentLocation = [coordinatesArray[0], coordinatesArray[1]];
          addMarker(apartmentLocation, apartment.title); // Aggiungi marker per gli appartamenti
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

      /* controlli mappa */
      map.addControl(new tt.FullscreenControl()); // fullscreen
      map.addControl(new tt.NavigationControl()); // Controllo per la navigazione

      /* aggiorna la mappa */
      map.on('load', updateMap);
    });

    /* osserva le modifiche alle props apartments e coordinates tenendo la mappa aggiornata */
    watch([apartments, coordinates], updateMap);

    return {
      mapRef
    };
  }
}
</script>

<template>
  <div id='map' ref="mapRef"></div> <!-- Contenitore per la mappa -->
</template>

<style></style>
