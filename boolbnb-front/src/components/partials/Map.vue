<script>
import { onMounted, ref, toRefs, watch } from 'vue';

export default {
  name: 'Map',
  props: {
    apartments: {
      type: Array,
      required: true,
      default: () => []
    },
    coordinates: {
      type: Object,
      required: true
    }
  },
  setup(props) {
    const { apartments, coordinates } = toRefs(props);
    const mapRef = ref(null);
    let map = null;
    const markers = [];
    let centralMarker = null;

    function addMarker(location, popupText) {
      const tt = window.tt;
      const popupOffset = 25;
      const marker = new tt.Marker().setLngLat(location).addTo(map);
      const popup = new tt.Popup({ offset: popupOffset }).setHTML(popupText);
      marker.setPopup(popup).togglePopup();
      markers.push(marker);
      return marker;
    }

    function removeMarkers() {
      markers.forEach(marker => marker.remove());
      markers.length = 0;

      if (centralMarker) {
        centralMarker.remove();
        centralMarker = null;
      }
    }

    function updateMap() {
      if (map) {
        removeMarkers();
        const centralLocation = [coordinates.value.lon, coordinates.value.lat];
        const bounds = new tt.LngLatBounds();


        // Aggiungi il nuovo marker centrale
        centralMarker = addMarker(centralLocation, 'Punto centrale: ' + coordinates.value.name);
        bounds.extend(centralLocation);

        if (apartments.value) {
          apartments.value.forEach(apartment => {
            const coordinatesArray = apartment.coordinate.split(',').map(coord => parseFloat(coord.trim()));
            const apartmentLocation = [coordinatesArray[0], coordinatesArray[1]];
            /* console.log('Adding apartment marker at:', apartmentLocation); */
            addMarker(apartmentLocation, apartment.title);
            bounds.extend(apartmentLocation);
          })
        };
        map.fitBounds(bounds, { padding: 100 });
        if (apartments.value.length == 0) {
          map.setCenter(centralLocation);
          map.setZoom(15);
        }
      }
    }
    onMounted(() => {
      const tt = window.tt;
      map = tt.map({
        key: 'gBSPk0bCa3RCfPcr4yCwWYQfk59mSmXo',
        container: mapRef.value,
        style: 'tomtom://vector/1/basic-main',
      });

      map.addControl(new tt.FullscreenControl());
      map.addControl(new tt.NavigationControl());

      map.on('load', updateMap);
    });

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
