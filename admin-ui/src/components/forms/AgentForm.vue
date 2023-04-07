<template>
  <q-card>
    <q-form @submit.prevent="onSubmit" v-if="form">
      <q-card-section class="q-gutter-y-sm">
        <!-- User -->
        <q-select v-model="selectedUserId" :options="users" label="Usuario" emit-value map-options option-label="name"
          option-value="id" :readonly="$props.agent ? true : false" />
        <!-- / User -->
        <!-- NIck -->
        <q-input v-model="form.nick" required type="text" label="Nick" />
        <!-- / NIck -->
        <!-- Address -->
        <q-input v-model="form.address" required type="text" label="Dirección" />
        <!-- / Address -->

        <!-- Agent Group -->
        <q-select required v-model="form.agent_group_id" :options="agentGroups" label="Grupo" map-options emit-value
          option-label="name" option-value="id" />
        <!-- / Agent Group -->

        <!-- Others -->
        <q-input v-model="form.others" type="textarea" label="Observaciones" />
        <!-- / Others -->
      </q-card-section>

      <q-card-actions>
        <q-btn color="primary" icon="mdi-close" label="Cerrar" outline @click="$emit('cancel')" />
        <q-btn color="primary" :disable="loading" icon="mdi-check" label="Guardar" type="submit" />
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script setup lang="ts">
import { notificationHelper } from 'src/helpers';
import { injectStrict, _agentInjectable, _user, _app } from 'src/injectables';
import { IAgent, IAgentCreateRequest, IAgentUpdateRequest } from 'src/types';
import { ref, computed, onBeforeMount } from 'vue';
/**
 * -----------------------------------------
 *	Inject
 * -----------------------------------------
 */
const $agent = injectStrict(_agentInjectable);
const $user = injectStrict(_user);
const $app = injectStrict(_app);
const $emit = defineEmits<{ (e: 'cancel'): void; (e: 'complete'): void }>();
const $props = defineProps<{ agent?: IAgent }>();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const agentGroups = computed(() => $agent.groups);
const form = ref<IAgentCreateRequest | IAgentUpdateRequest>();
const selectedUserId = ref();
const users = computed(() => $user.allUsers);
const loading = computed(() => $app.loading)
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
  if (!form.value) return;
  try {
    if ($props.agent) {
      await $agent.update($props.agent.id, form.value);
    } else {
      (form.value as IAgentCreateRequest).user_id = selectedUserId.value;
      await $agent.create(form.value as IAgentCreateRequest);
    }
    $emit('complete');
  } catch (error) {
    notificationHelper.axiosError(error, 'No se guardo el agente');
  }
  notificationHelper.loading(false);
}
/**
 * -----------------------------------------
 *	LifeCycle
 * -----------------------------------------
 */
onBeforeMount(() => {
  if ($props.agent) {
    form.value = {
      address: $props.agent.address,
      agent_group_id: $props.agent.agent_group_id,
      bussy: $props.agent.bussy,
      nick: $props.agent.nick,
      others: $props.agent.others,
      user_id: $props.agent.user_id,
    };
    selectedUserId.value = $props.agent.user_id;
  } else {
    form.value = {
      address: '',
      agent_group_id: 1,
      user_id: 0,
      bussy: false,
      nick: '',
      others: '',
    };
  }
});
</script>
