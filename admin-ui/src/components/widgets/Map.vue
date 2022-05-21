<template>
  <l-map
    ref="map"
    id="map--pageleaflet"
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
      <q-btn
        color="primary"
        :icon="`${readonly ? 'mdi-arrow-left' : 'mdi-check'}`"
        :label="`${readonly ? 'Regresar' : 'Confirmar'}`"
        @click="confirm"
        v-if="markers.length && button"
      />
      <q-btn
        v-if="!readonly"
        color="white"
        :text-color="`${gpsPosition ? 'info' : 'black'}`"
        :icon="`${gpsPosition ? 'mdi-crosshairs-gps' : 'mdi-crosshairs'}`"
        @click="markCurrentGPSPosition"
      />
    </l-control>

    <l-marker
      :key="`marker-${markerKey}`"
      v-for="(marker, markerKey) in markers"
      :lat-lng="marker"
    />
  </l-map>
</template>

<script lang="ts">
import { computed, defineComponent, PropType, onBeforeMount } from 'vue';
import 'leaflet/dist/leaflet.css';
import { LatLng, LocationEvent, Icon } from 'leaflet';
import {
  LControl,
  // LControlZoom,
  LMap,
  LMarker,
  LTileLayer,
} from '@vue-leaflet/vue-leaflet';
import { injectStrict, _map } from 'src/injectables';

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
  emits: ['add-position', 'current-gps', 'confirm'],
  props: {
    initialMarkers: {
      type: Array as PropType<LatLng[]>,
      required: false,
    },
    readonly: {
      type: Boolean,
      default: false,
    },
    button: {
      type: Boolean,
      default: true,
    },
  },
  setup($props, { emit }) {
    const $mapStore = injectStrict(_map);

    onBeforeMount(() => {
      if ($props.initialMarkers && $props.initialMarkers.length) {
        $mapStore.markers = $props.initialMarkers;
        $mapStore.center = $props.initialMarkers[0];
      }
    });
    /**
     * -----------------------------------------
     *	Data
     * -----------------------------------------
     */
    const center = computed(() => $mapStore.center);
    const gpsPosition = computed(() => $mapStore.gpsPosition);
    const markers = computed(() => $mapStore.markers);
    const settings = computed(() => $mapStore.settings);
    const zoom = computed(() => $mapStore.zoom);
    /**
     * -----------------------------------------
     *	Methods
     * -----------------------------------------
     */
    /**
     * addMarker
     */
    function addMarker(event: MouseEvent | PointerEvent | LocationEvent) {
      if ($props.readonly) return;
      if ((event as LocationEvent).latlng) {
        if (markers.value.length && settings.value.multiple)
          $mapStore.markers.push((event as LocationEvent).latlng);
        else {
          $mapStore.markers = [(event as LocationEvent).latlng];
        }
        emit('add-position', (event as LocationEvent).latlng);
      }
    }
    function confirm() {
      emit('confirm', markers.value);
    }
    /**
     * doMoveCenter
     * @param _center
     */
    function doMoveCenter(_center: LatLng) {
      $mapStore.center = _center;
    }
    /**
     * doMoveZoom
     * @param _zoom
     */
    function doMoveZoom(_zoom: number) {
      $mapStore.zoom = _zoom;
    }
    /**
     * getCurrentGPSPosition
     */
    async function markCurrentGPSPosition() {
      await $mapStore.markGpsPosition();
      emit('current-gps', gpsPosition.value);
    }

    return {
      ATTRIBUTION,
      MAP_URL,
      center,
      gpsPosition,
      settings,
      markers,
      zoom,
      // Methods
      addMarker,
      confirm,
      doMoveCenter,
      doMoveZoom,
      markCurrentGPSPosition,
    };
  },
});
</script>
