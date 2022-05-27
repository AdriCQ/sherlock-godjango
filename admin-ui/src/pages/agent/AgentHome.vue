<template>
  <q-page padding>
    <q-card class="full-width" style="height: 80vh">
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

        <!-- Controls -->
        <l-control v-if="markers.length">
          <q-btn
            color="white"
            text-color="dark"
            icon="mdi-eye"
            @click="dialogMarkerSelector = true"
          />
        </l-control>
        <!-- / Controls -->
        <template
          :key="`marker-${markerKey}`"
          v-for="(marker, markerKey) in markers"
        >
          <l-marker
            v-if="marker.visible"
            :lat-lng="marker"
            @click="checkpointDetails(marker.checkpoint?.id)"
          />
        </template>
      </l-map>
    </q-card>

    <!-- Dialog Position Selector -->
    <q-dialog v-model="dialogMarkerSelector">
      <q-card class="no-box-shadow" style="min-width: 20rem">
        <q-card-section>
          <q-list bordered>
            <q-item
              v-for="(marker, mKey) in markers"
              :key="`mlistas-${marker.checkpoint?.id}-key-${mKey}`"
            >
              <q-item-section>
                <q-item-label>{{ marker.checkpoint?.name }}</q-item-label>
                <q-item-label caption lines="2">{{
                  marker.checkpoint?.status === 0 ? 'Pendiente' : 'Completado'
                }}</q-item-label></q-item-section
              >
              <q-item-section avatar @click="toggleMarkerVisible(marker)">
                <q-icon
                  color="primary"
                  :name="marker.visible ? 'mdi-eye' : 'mdi-eye-off'"
                />
              </q-item-section>
            </q-item>
          </q-list>
        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat label="Aceptar" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
    <!-- / Dialog Position Selector -->
  </q-page>
</template>

<script setup lang="ts">
import { computed, onBeforeMount, ref } from 'vue';
import 'leaflet/dist/leaflet.css';
import { LatLng, Icon, latLng } from 'leaflet';
import {
  LControl,
  // LControlZoom,
  LMap,
  LMarker,
  LTileLayer,
} from '@vue-leaflet/vue-leaflet';
import { DEFAULT_COORDINATES } from 'src/helpers';
import { injectStrict, _agentInjectable } from 'src/injectables';
import { useRouter } from 'vue-router';
import { ROUTE_NAME } from 'src/router';
import { IAssignmentCheckpoint } from 'src/types';

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
  checkpoint?: IAssignmentCheckpoint;
  visible?: boolean;
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

const $agent = injectStrict(_agentInjectable);
const $router = useRouter();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const assignments = computed(() => $agent.assignments);
const center = ref<LatLng>(DEFAULT_COORDINATES);
const dialogMarkerSelector = ref(false);
const markers = ref<ILatLng[]>([]);
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
 * checkpointDetails
 * @param id
 */
function checkpointDetails(id?: number) {
  if (!id) return;
  void $router.push({
    name: ROUTE_NAME.AGENT_ASSIGNMENT,
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
/**
 * Toggle Marker Visible
 * @param marker
 */
function toggleMarkerVisible(marker: ILatLng) {
  const index = markers.value.findIndex(
    (m) => m.checkpoint?.id === marker.checkpoint?.id
  );
  if (index >= 0) markers.value[index].visible = !markers.value[index].visible;
}
/**
 * -----------------------------------------
 *	Lifecycle
 * -----------------------------------------
 */

onBeforeMount(async () => {
  await $agent.listAssignments();
  let object: ILatLng;
  assignments.value.forEach((a) => {
    if (a.checkpoints?.length) {
      a.checkpoints.forEach((ch) => {
        object = latLng(ch.position.lat, ch.position.lng);
        object.checkpoint = ch;
        object.visible = true;
        markers.value.push(object);
      });
    }
  });
});
</script>
