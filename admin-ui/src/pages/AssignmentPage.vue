<template>
  <q-page padding>
    <q-card class="no-box-shadow" v-if="assignment">
      <div class="row q-col-gutter-sm">
        <div class="col-xs-12 col-sm-6">
          <q-card-section>
            <div class="text-h6">{{ assignment.name }}</div>
            <div class="text-subtitle1">
              <q-chip
                class="glossy"
                :icon="assignment.status === 0 ? 'mdi-clock' : 'mdi-check'"
                :label="assignment.status === 0 ? 'En Progreso' : 'Completado'"
                :color="assignment.status === 0 ? '' : 'positive'"
              />
            </div>
          </q-card-section>
          <q-card-section>
            <!-- Agent -->
            <p class="text-subtitle2" v-if="assignment.agent">
              <q-icon name="mdi-account" class="q-mr-sm" />
              {{ assignment.agent?.nick }}
            </p>
            <!-- / Agent -->

            <!-- description -->
            <p class="text-subtitle2">{{ assignment.description }}</p>
            <!-- / description -->

            <!-- observations -->
            <p v-if="assignment.observations">
              Observaciones: {{ assignment.observations }}
            </p>
            <!-- / observations -->
          </q-card-section>
          <q-card-section v-if="assignment.checkpoints?.length">
            <div class="text-body1 text-center">Checkpoints</div>
            <q-list bordered class="q-mt-sm">
              <q-item clickable @click="displayCheckpoint = undefined">
                <q-item-section avatar>
                  <q-icon name="mdi-map-marker" />
                </q-item-section>
                <q-item-section>Todos</q-item-section>
              </q-item>
              <q-item
                clickable
                v-for="(cp, cpIndex) in assignment.checkpoints"
                :key="`checkpoint-${cp.id}-${cpIndex}`"
                @click="displayCheckpoint = cp"
              >
                <q-item-section avatar>
                  <q-icon name="mdi-map-marker" />
                </q-item-section>
                <q-item-section>{{ cp.name }}</q-item-section>
              </q-item>
            </q-list>
          </q-card-section>
        </div>

        <!-- Map Column -->
        <div class="col-sm-6">
          <map-widget
            readonly
            :markers="checkpointMarkers"
            :center="checkpointMarkers[0]"
            :zoom="mapZoom"
            @update-zoom="(z) => (mapZoom = z)"
          />
        </div>
        <!-- / Map Column -->
      </div>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import { injectStrict, _assignmentInjectable } from 'src/injectables';
import { computed, onBeforeMount, ref } from 'vue';
import { useRoute } from 'vue-router';
import MapWidget from 'src/components/widgets/MapWidget.vue';
import { latLng, LatLng } from 'leaflet';
import { IAssignmentCheckpoint } from 'src/types';
/**
 * -----------------------------------------
 *	Injectable
 * -----------------------------------------
 */
const $assignment = injectStrict(_assignmentInjectable);
const $route = useRoute();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const assignmentId = ref(0);
const assignment = computed(() => $assignment.getById(assignmentId.value));
const displayCheckpoint = ref<IAssignmentCheckpoint>();
const checkpointMarkers = computed<LatLng[]>(() => {
  const markers: LatLng[] = [];
  if (displayCheckpoint.value) {
    return [
      latLng(
        displayCheckpoint.value.position.lat,
        displayCheckpoint.value.position.lng
      ),
    ];
  }
  assignment.value?.checkpoints?.forEach((cp) => {
    markers.push(latLng(cp.position.lat, cp.position.lng));
  });
  return markers;
});

const mapZoom = ref(15);
/**
 * -----------------------------------------
 *	Lifecycle
 * -----------------------------------------
 */
onBeforeMount(() => {
  if ($route.params && $route.params.id) {
    assignmentId.value = Number($route.params.id);
  }
});
</script>
