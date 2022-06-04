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
            :color="checkpoint.status ? 'positive' : ''"
            :icon="checkpoint.status ? 'mdi-check' : 'mdi-clock'"
            :label="checkpoint.status ? 'Completado' : 'Pendiente'"
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
onBeforeMount(() => {
  if ($route.params && $route.params.id) {
    console.log($route.params.id);
    checkpoint.value = $agent.findCheckpointById(Number($route.params.id));
  }
});
</script>
