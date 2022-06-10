<template>
  <l-map
    ref="map"
    id="map--pageleaflet"
    class="full-heigth"
    :zoom="Number(zoom)"
    :center="center"
    :min-zoom="settings.zoom.min"
    :max-zoom="settings.zoom.max"
    @click="eventOnClick"
    @update:center="(center) => $emit('update-center', center)"
    @update:zoom="(zoom) => $emit('update-zoom', zoom)"
    :key="`map-key-${zoom}-${center.lat}-${center.lng}`"
  >
    <l-tile-layer :url="MAP_URL" :attribution="ATTRIBUTION" />

    <l-marker
      :key="`marker-${markerKey}`"
      v-for="(marker, markerKey) in markers"
      :lat-lng="marker"
      @click="eventOnMarkerClick(marker, markerKey)"
    />
  </l-map>
</template>

<script setup lang="ts">
import 'leaflet/dist/leaflet.css';
import { LatLng, LocationEvent, Icon, latLng } from 'leaflet';
import {
  // LControl,
  // LControlZoom,
  LMap,
  LMarker,
  LTileLayer,
} from '@vue-leaflet/vue-leaflet';
import { IMaPSettings } from 'src/types';
import { toRefs } from 'vue';

/* Fix leaflet icons */
type D = Icon.Default & {
  _getIconUrl: string;
};
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
 * -----------------------------------------
 *	Injectables
 * -----------------------------------------
 */
const $props = withDefaults(
  defineProps<{
    markers?: LatLng[];
    settings?: IMaPSettings;
    mapClickFn?: (payload: MouseEvent | LocationEvent) => void;
    readonly?: boolean;
    center?: LatLng;
    zoom?: number;
    markerClickFn?: (marker: LatLng, key: number) => void;
  }>(),
  {
    markers: () => [],
    settings: () => ({
      multiple: false,
      zoom: {
        max: 18,
        min: 10,
      },
    }),
    center: () => latLng(0, 0),
    readonly: false,
    zoom: 16,
  }
);

const $emit = defineEmits<{
  (e: 'add-marker', p: LatLng): void;
  (e: 'update-center', p: LatLng): void;
  (e: 'update-zoom', p: number): void;
}>();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const { markers, settings } = toRefs($props);
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */

/**
 * eventOnClick
 * @param event
 */
function eventOnClick(event: MouseEvent | LocationEvent) {
  if ($props.mapClickFn) $props.mapClickFn(event);
  else {
    if ($props.readonly) return;
    if ((event as LocationEvent).latlng) {
      $emit('add-marker', (event as LocationEvent).latlng);
    }
  }
}
/**
 * eventOnMarkerClick
 * @param marker
 */
function eventOnMarkerClick(marker: LatLng, key: number) {
  if ($props.markerClickFn) $props.markerClickFn(marker, key);
}
</script>
