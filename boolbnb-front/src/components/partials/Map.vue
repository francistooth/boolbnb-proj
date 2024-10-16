<script>
import { onMounted, ref } from 'vue';
export default {
  name: 'Map',
  setup() {
    const mapRef = ref(null);
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
      map.on('load', function() {
        const markers = [
        { location: [12.47805, 41.90694], popupText: "Appartamento a Pigneto" },
        { location: [12.49755, 41.89775], popupText: "Attico vicino al Colosseo" },
        { location: [12.47511, 41.90249], popupText: "Bilocale a San Giovanni" },
        { location: [12.60393, 41.86183], popupText: "Monolocale a Tiburtina" },
        { location: [12.47935, 41.88018], popupText: "Trilocale a Prati" },
        { location: [12.48154, 41.90618], popupText: "Quadrilocale a Testaccio" },
        { location: [12.48733, 41.90253], popupText: "Appartamento nel quartiere Monti" },
        { location: [12.50614, 41.90218], popupText: "Loft moderno a Termini" },
        { location: [12.47457, 41.86863], popupText: "Bilocale a Ostiense" },
        { location: [12.47543, 41.88333], popupText: "Appartamento a Flaminio" },
        { location: [12.47611, 41.90837], popupText: "Attico di lusso" },
        { location: [12.47153, 41.89087], popupText: "Appartamento a Salario" },
        { location: [12.49056, 41.89517], popupText: "Bilocale a Casal Bruciato" },
        { location: [12.47423, 41.89626], popupText: "Trilocale a San Lorenzo" },
        { location: [12.48139, 41.85491], popupText: "Appartamento a Cinecittà" },
        { location: [12.4944, 41.89007], popupText: "Appartamento al Gianicolo" },
        { location: [12.47744, 41.90189], popupText: "Monolocale a Campo Marzio" },
        { location: [12.45761, 41.89515], popupText: "Attico a Garbatella" },
        { location: [12.48109, 41.90373], popupText: "Appartamento a Trastevere" },
        { location: [12.47627, 41.89516], popupText: "Monolocale vicino al Colosseo" },
        { location: [12.50492, 41.91525], popupText: "Appartamento nel Quartiere Coppedè" },
        { location: [12.47956, 42.0091], popupText: "Monolocale a San Giovanni" },
        { location: [12.51388, 41.89169], popupText: "Bilocale a Porta Maggiore" },
        { location: [12.457, 41.87668], popupText: "Attico a Monteverde" },
        { location: [12.47922, 41.8715], popupText: "Appartamento a Ostiense" },
        { location: [12.55404, 41.91262], popupText: "Trilocale a Tiburtina" },
        { location: [12.56694, 41.88279], popupText: "Monolocale a Quarticciolo" },
        { location: [12.36681, 41.95751], popupText: "Appartamento a Casalotti" },
        { location: [12.51881, 41.89165], popupText: "Bilocale a Centocelle" },
        { location: [12.51635, 41.94382], popupText: "Attico a Prati Fiscali" }

        ];

        let bounds = new tt.LngLatBounds();
        markers.forEach(marker => {
          addMarker(map, marker.location, marker.popupText);
          bounds.extend(marker.location);
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
#map {
  height: 100vh;
}
</style>
