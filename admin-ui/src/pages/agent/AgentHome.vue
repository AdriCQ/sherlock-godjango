<template>
  <q-page padding>
    <q-card class="full-width" style="height: 75vh">
      <q-card-section class="q-pa-xs">
        <div class="text-h6 text-center">Tarea Actual</div>
      </q-card-section>
      <l-map
        ref="map"
        id="map--page-managerleaflet"
        class="full-heigth"
        :zoom="Number(zoom)"
        :center="center"
        :min-zoom="settings.zoom.min"
        :max-zoom="settings.zoom.max"
        @update:center="doMoveCenter"
        @update:zoom="doMoveZoom"
        :key="`map-key-${zoom}-${center.lat}-${center.lng}`"
      >
        <l-tile-layer :url="MAP_URL" :attribution="ATTRIBUTION" />

        <l-marker
          :key="`marker-${markerKey}`"
          v-for="(marker, markerKey) in markers"
          :lat-lng="marker"
          @click="assignmentDetails(marker.assignment_id)"
        />
      </l-map>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { computed, defineComponent, onBeforeMount, ref } from 'vue';
import 'leaflet/dist/leaflet.css';
import { LatLng, Icon, latLng } from 'leaflet';
import {
  // LControl,
  // LControlZoom,
  LMap,
  LMarker,
  LTileLayer,
} from '@vue-leaflet/vue-leaflet';
import { DEFAULT_COORDINATES } from 'src/helpers';
import { injectStrict, _assignmentInjectable } from 'src/injectables';
import { useRouter } from 'vue-router';
import { ROUTE_NAME } from 'src/router';

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
interface ILatLng extends LatLng {
  assignment_id?: number;
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
    // LControl,
    // LControlZoom,
    LMap,
    LMarker,
    LTileLayer,
  },
  setup() {
    const $assignment = injectStrict(_assignmentInjectable);
    const $router = useRouter();
    onBeforeMount(() => {
      void $assignment.filter({ status: 0 });
    });
    /**
     * -----------------------------------------
     *	Data
     * -----------------------------------------
     */
    const assignments = computed(() => $assignment.assignments);
    const center = ref<LatLng>(DEFAULT_COORDINATES);
    const markers = computed<ILatLng[]>(() => {
      const markers: ILatLng[] = [];
      let object: ILatLng;
      assignments.value.forEach((a) => {
        if (a.checkpoints?.length) {
          object = latLng(
            a.checkpoints[0].position.lat,
            a.checkpoints[0].position.lng
          );
          object.assignment_id = a.id;
          markers.push(object);
        }
      });
      return markers;
    });
    const settings = ref<IMaPSettings>({
      multiple: false,
      zoom: {
        max: 18,
        min: 8,
      },
    });
    const zoom = ref(12);
    /**
     * -----------------------------------------
     *	Methods
     * -----------------------------------------
     */
    /**
     * assignmentDetails
     * @param id
     */
    function assignmentDetails(id?: number) {
      if (!id) return;
      void $router.push({
        name: ROUTE_NAME.ADMIN_ASSIGNMENT,
        params: { id: id },
      });
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
      assignmentDetails,
      confirm,
      doMoveCenter,
      doMoveZoom,
    };
  },
});
</script>
