<template>
  <q-card>
    <q-card-section>
      <div class="absolute-top-right q-pa-xs cursor-pointer">
        <!-- <div @click="onRemove">
          <q-icon name="mdi-delete" color="negative" />
        </div> -->
        <div @click="$emit('request-edit')">
          <q-icon name="mdi-pencil" color="primary" />
        </div>
      </div>
      <div class="text-body2">{{ $props.agent.nick }}</div>
    </q-card-section>
    <q-card-actions>
      <q-chip
        size="sm"
        class="glossy"
        :color="$props.agent.bussy ? '' : 'info'"
        :icon="$props.agent.bussy ? 'mdi-cancel' : 'mdi-check'"
        :label="$props.agent.bussy ? 'Ocupado' : 'Disponible'"
      />
      <q-chip
        size="sm"
        clickable
        class="glossy"
        icon="mdi-map-marker"
        label="Mapa"
      />
    </q-card-actions>
  </q-card>
</template>

<script setup lang="ts">
// import { notificationHelper } from 'src/helpers';
// import { injectStrict, _agentInjectable } from 'src/injectables';
import { IAgent } from 'src/types';

// const $agent = injectStrict(_agentInjectable);
const $emit = defineEmits<{ (e: 'request-edit'): void }>();
// const $gui = useGuiHelper();
const $props = defineProps<{ agent: IAgent }>();
/**
 * onRemove
 */
// async function onRemove() {
//   $gui.deleteDialog({
//     title: 'Eliminar Agente',
//     message: '¿Desea eliminar el Agente?',
//     onOk: async () => {
//       try {
//         await $agent.remove($props.agent.id);
//       } catch (error) {
//         notificationHelper.axiosError(error, 'No se pudo eliminar el agente');
//       }
//     },
//   });
// }
</script>
