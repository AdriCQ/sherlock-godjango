<template>
  <q-card>
    <q-form @submit.prevent="onSubmit">
      <!-- Type -->
      <q-card-section class="q-gutter-y-sm">
        <q-select
          v-model="form.type"
          :options="[
            { label: 'Informativo', value: 'info' },
            { label: 'Problema Medio', value: 'warning' },
            { label: 'Problema Grave', value: 'danger' },
          ]"
          label="Tipo de Reporte"
          emit-value
          map-options
        />
        <!-- / Type -->

        <!-- Details -->
        <q-input
          v-model="form.details"
          style="min-height: 10rem"
          type="textarea"
          label="Detalles"
          required
        />
        <!-- /Details -->
      </q-card-section>
      <q-card-actions>
        <q-btn
          color="primary"
          outline
          icon="mdi-cancel"
          label="Cancelar"
          @click="$emit('cancel')"
        />
        <q-btn color="primary" icon="mdi-check" label="Guardar" type="submit" />
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script setup lang="ts">
import { notificationHelper } from 'src/helpers';
import { injectStrict, _eventInjectable } from 'src/injectables';
import { IAgent, IEventCreateRequest } from 'src/types';
import { onBeforeMount, ref } from 'vue';

/**
 * -----------------------------------------
 *	Inject
 * -----------------------------------------
 */
const $emit = defineEmits<{ (e: 'complete'): void; (e: 'cancel'): void }>();
const $event = injectStrict(_eventInjectable);
const $props = defineProps<{ agent: IAgent }>();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const form = ref<IEventCreateRequest>({
  agent_id: 0,
  details: '',
  status: 'onprogress',
  type: 'info',
});
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * onSubmit
 */
async function onSubmit() {
  notificationHelper.loading();
  try {
    await $event.create(form.value);
    $emit('complete');
  } catch (error) {
    notificationHelper.axiosError(error);
  }
  notificationHelper.loading(false);
}

onBeforeMount(() => {
  form.value.agent_id = $props.agent.id;
});
</script>
