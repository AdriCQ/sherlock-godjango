<template>
  <q-page padding>
    <q-card class="full-width" style="height: 85vh">
      <l-map
        ref="map"
        id="map--page-managerleaflet"
        class="full-heigth"
        :zoom="Number(zoom)"
        :center="center"
        :min-zoom="settings.zoom.min"
        :max-zoom="settings.zoom.max"
        @click="addMarker"
        @update:center="doMoveCenter"
        @update:zoom="doMoveZoom"
        :key="`map-key-${zoom}-${center.lat}-${center.lng}`"
      >
        <l-tile-layer :url="MAP_URL" :attribution="ATTRIBUTION" />
        <l-control>
          <q-btn icon="mdi-magnify" color="white" text-color="dark" />
        </l-control>

        <l-marker
          :key="`marker-${markerKey}`"
          v-for="(marker, markerKey) in markers"
          :lat-lng="marker"
        />
      </l-map>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import 'leaflet/dist/leaflet.css';
import { LatLng, LocationEvent, Icon } from 'leaflet';
import {
  LControl,
  // LControlZoom,
  LMap,
  LMarker,
  LTileLayer,
} from '@vue-leaflet/vue-leaflet';
import { DEFAULT_COORDINATES } from 'src/helpers';

/* Fix leaflet icons */
type D = Icon.Default & {
  _getIconUrl: string;
};
interface IMaPSettings {
  multiple: boolean;
  zoom: {
    min: number;
    max: number;
  };
}
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
delete (Icon.Default.prototype as D)._getIconUrl;
Icon.Default.mergeOptions({
  // eslint-disable-next-line @typescript-eslint/no-unsafe-assignment
  iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
  // eslint-disable-next-line @typescript-eslint/no-unsafe-assignment
  iconUrl: require('leaflet/dist/images/marker-icon.png'),
  // eslint-disable-next-line @typescript-eslint/no-unsafe-assignment
  shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});
/**
 * ATTRIBUTION
 */
const ATTRIBUTION =
  '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a> contributors';
/**
 * MAP_URL
 */
const MAP_URL = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
/**
 * COMPONENT
 */
export default defineComponent({
  name: 'MapLayout',
  components: {
    LControl,
    // LControlZoom,
    LMap,
    LMarker,
    LTileLayer,
  },
  setup() {
    /**
     * -----------------------------------------
     *	Data
     * -----------------------------------------
     */
    const center = ref<LatLng>(DEFAULT_COORDINATES);
    const markers = ref<LatLng[]>([]);
    const settings = ref<IMaPSettings>({
      multiple: false,
      zoom: {
        max: 18,
        min: 8,
      },
    });
    const zoom = ref(14);
    /**
     * -----------------------------------------
     *	Methods
     * -----------------------------------------
     */
    /**
     * addMarker
     */
    function addMarker(event: MouseEvent | PointerEvent | LocationEvent) {
      if ((event as LocationEvent).latlng) {
        if (markers.value.length && settings.value.multiple)
          markers.value.push((event as LocationEvent).latlng);
        else {
          markers.value = [(event as LocationEvent).latlng];
        }
      }
    }
    /**
     * doMoveCenter
     * @param _center
     */
    function doMoveCenter(_center: LatLng) {
      center.value = _center;
    }
    /**
     * doMoveZoom
     * @param _zoom
     */
    function doMoveZoom(_zoom: number) {
      zoom.value = _zoom;
    }

    return {
      ATTRIBUTION,
      MAP_URL,
      center,
      settings,
      markers,
      zoom,
      // Methods
      addMarker,
      confirm,
      doMoveCenter,
      doMoveZoom,
    };
  },
});
</script>
