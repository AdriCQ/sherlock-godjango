<template>
  <q-card>
    <q-form @submit.prevent="onSubmit">
      <q-card-section class="q-gutter-y-sm">
        <!-- Name -->
        <q-input v-model="form.name" type="text" label="Nombre" />
        <!-- / Name -->
        <!-- contact -->
        <q-input v-model="form.contact" type="text" label="Contacto" />
        <!-- / contact -->
        <!-- Lugar -->
        <map-widget
          style="height: 50vh"
          @add-marker="onMapAddMarker"
          :markers="[form.position]"
          :center="DEFAULT_COORDINATES"
        />
      </q-card-section>
      <q-card-actions>
        <q-btn
          label="Cancelar"
          @click="$emit('cancel')"
          color="primary"
          outline
        />
        <q-btn label="Guardar" type="submit" color="primary" />
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script setup lang="ts">
import { LatLng } from 'leaflet';
import { DEFAULT_COORDINATES, notificationHelper } from 'src/helpers';
import { injectStrict, _assignmentInjectable } from 'src/injectables';
import { IAssignment, IAssignmentCheckpoint } from 'src/types';
import { ref } from 'vue';
import MapWidget from '../widgets/MapWidget.vue';
/**
 * -----------------------------------------
 *	Injectable
 * -----------------------------------------
 */
const $assignment = injectStrict(_assignmentInjectable);
const $emit = defineEmits<{ (e: 'complete'): void; (e: 'cancel'): void }>();
const $props = defineProps<{ assignment: IAssignment }>();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const form = ref<IAssignmentCheckpoint>({
  id: 0,
  created_at: '',
  name: '',
  position: DEFAULT_COORDINATES,
  status: 0,
  contact: '',
  updated_at: '',
});
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * On Map Add Marker
 * @param p
 */
function onMapAddMarker(p: LatLng) {
  form.value.position = p;
}
/**
 * onSubmit
 */
async function onSubmit() {
  notificationHelper.loading();
  try {
    await $assignment.addCheckpoint($props.assignment.id, form.value);
    $emit('complete');
  } catch (error) {
    notificationHelper.axiosError(error);
  }
  notificationHelper.loading(false);
}
</script>
