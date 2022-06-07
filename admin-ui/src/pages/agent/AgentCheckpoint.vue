<template>
  <q-page padding>
    <q-card class="no-box-shadow" v-if="checkpoint">
      <q-card-section>
        <div class="text-h6">{{ checkpoint.name }}</div>
        <div class="text-subtitle2">Contacto: {{ checkpoint.contact }}</div>
        <div class="text-body2">
          Estado:
          <q-chip
            class="glossy"
            clickable
            :color="checkpoint.status ? 'positive' : ''"
            :icon="checkpoint.status ? 'mdi-check' : 'mdi-clock'"
            :label="checkpoint.status ? 'Completado' : 'Pendiente'"
            @click="toggleStatus"
          />
        </div>
      </q-card-section>
      <q-card-section>
        <map-widget
          class="full-width"
          style="height: 60vh"
          :center="checkpoint.position"
          readonly
          :markers="[checkpoint.position]"
        />
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import { injectStrict, _agentInjectable } from 'src/injectables';
import { IAssignmentCheckpoint } from 'src/types';
import { onBeforeMount, ref } from 'vue';
import { useRoute } from 'vue-router';
import MapWidget from 'src/components/widgets/MapWidget.vue';
import { notificationHelper } from 'src/helpers';
import { Dialog } from 'quasar';

/**
 * -----------------------------------------
 *	Injectable
 * -----------------------------------------
 */
const $agent = injectStrict(_agentInjectable);
const $route = useRoute();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const checkpoint = ref<IAssignmentCheckpoint>();
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
async function toggleStatus() {
  if (checkpoint.value?.status === 0) {
    Dialog.create({
      title: 'Cambiar estado',
      message: 'Va a cambiar el estado del Checkpoint a COMPLETADO',
      ok: 'Si',
      cancel: 'no',
    }).onOk(async () => {
      try {
        if (checkpoint.value) {
          notificationHelper.loading();
          await $agent.updateAssignmentCheckpoint(checkpoint.value.id, {
            status: 1,
          });
          checkpoint.value.status = 1;
        }
      } catch (error) {
        notificationHelper.axiosError(error);
      }
      notificationHelper.loading(false);
    });
  }
}
/**
 * On Before Mount
 */
onBeforeMount(async () => {
  if ($route.params && $route.params.id) {
    checkpoint.value = $agent.findCheckpointById(Number($route.params.id));
    if (!checkpoint.value) {
      notificationHelper.loading();
      try {
        const assignment = await $agent.getAssignmentByCheckpoint(
          Number($route.params.id)
        );
        checkpoint.value = assignment.checkpoints?.find(
          (ch) => ch.id === Number($route.params.id)
        );
      } catch (error) {
        notificationHelper.axiosError(error);
      }
      notificationHelper.loading(false);
    }
  }
});
</script>
