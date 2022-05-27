<template>
  <q-card>
    <q-form @submit.prevent="onSubmit" v-if="form">
      <q-card-section class="q-gutter-y-sm">
        <!-- Name -->
        <q-input v-model="form.name" type="text" label="Nombre" />
        <!-- / Name -->
        <!-- Event -->
        <q-input v-model="form.event" type="text" label="Evento" />
        <!-- / Event -->
        <!-- Descripción -->
        <q-input
          v-model="form.description"
          type="textarea"
          label="Descripción"
        />
        <!-- / Descripción -->
        <!-- Observations -->
        <q-input
          v-model="form.observations"
          type="textarea"
          label="Observación"
        />
        <!-- / Observations -->
        <!-- Agente -->
        <q-select
          v-model="form.agent_id"
          :options="availableAgents"
          label="Agente"
          map-options
          emit-value
          option-label="nick"
          option-value="id"
        />
        <!-- / Agente -->
      </q-card-section>
      <q-card-actions>
        <q-btn
          class="full-width"
          type="submit"
          color="primary"
          label="Guardar"
        />
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script setup lang="ts">
import { computed } from '@vue/reactivity';
import { notificationHelper } from 'src/helpers';
import {
  injectStrict,
  _agentInjectable,
  _assignmentInjectable,
} from 'src/injectables';
import {
  IAssignment,
  IAssignmentCreateRequest,
  IAssignmentUpdateRequest,
} from 'src/types';
import { onBeforeMount, ref } from 'vue';
/**
 * -----------------------------------------
 *	Injection
 * -----------------------------------------
 */
const $agent = injectStrict(_agentInjectable);
const $assignment = injectStrict(_assignmentInjectable);
const $emit = defineEmits<{ (e: 'complete'): void; (e: 'cancel'): void }>();
const $props = defineProps<{ assignment?: IAssignment }>();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const availableAgents = computed(() => $agent.availableAgents);
const form = ref<IAssignmentCreateRequest | IAssignmentUpdateRequest>();
/**
 * onSubmit
 */
async function onSubmit() {
  notificationHelper.loading();
  try {
    if ($props.assignment) {
      // Update
      await $assignment.update(
        $props.assignment.id,
        form.value as IAssignmentUpdateRequest
      );
    } else {
      await $assignment.create(form.value as IAssignmentCreateRequest);
    }
    $emit('complete');
  } catch (error) {
    notificationHelper.axiosError(error, 'No se pudo guardar');
  }
  notificationHelper.loading(false);
}
/**
 * -----------------------------------------
 *	Lifecycle
 * -----------------------------------------
 */
onBeforeMount(() => {
  if ($props.assignment) {
    form.value = {
      agent_id: $props.assignment.agent_id,
      description: $props.assignment.description,
      event: $props.assignment.event,
      name: $props.assignment.name,
      observations: $props.assignment.observations,
      status: $props.assignment.status,
    } as IAssignmentUpdateRequest;
  } else {
    form.value = {
      agent_id: 0,
      description: '',
      event: '',
      name: '',
      observations: '',
      status: 0,
      checkpoints: [],
    } as IAssignmentCreateRequest;
  }
  console.log(availableAgents.value);
});
</script>
