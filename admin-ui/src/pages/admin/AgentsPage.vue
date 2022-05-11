<template>
  <q-page padding>
    <q-card class="no-box-shadow">
      <q-card-section>
        <div class="text-h6 text-center">Administrar Agentes</div>
        <div class="text-subtitle2">
          <q-btn
            color="primary"
            class="full-width"
            icon="mdi-plus"
            label="Nuevo Agente"
            @click="dialogForm = true"
          />
        </div>
      </q-card-section>
      <q-card-section>
        <div class="row q-col-gutter-sm">
          <div
            class="col-xs-12 col-sm-6 col-md-4 col-lg-3"
            v-for="(agent, aKey) in agents"
            :key="`agent-${agent.id}-k${aKey}`"
          >
            <agent-widget :agent="agent" @request-edit="requestEdit(aKey)" />
          </div>
        </div>
      </q-card-section>
    </q-card>

    <!-- Dialog Form -->
    <q-dialog v-model="dialogForm">
      <agent-form
        :agent="selectedAgent"
        @cancel="closeDialog"
        @complete="closeDialog"
        style="min-width: 20rem"
      />
    </q-dialog>
    <!-- / Dialog Form -->
  </q-page>
</template>

<script setup lang="ts">
import { notificationHelper } from 'src/helpers';
import { injectStrict, _agentInjectable, _user } from 'src/injectables';
import { computed, onBeforeMount, ref } from 'vue';
import AgentForm from 'src/components/forms/AgentForm.vue';
import AgentWidget from 'src/components/widgets/AgentWidget.vue';
import { IAgent } from 'src/types';

/**
 * -----------------------------------------
 *	Inject
 * -----------------------------------------
 */
const $agent = injectStrict(_agentInjectable);
const $user = injectStrict(_user);
/**
 * -----------------------------------------
 *	data
 * -----------------------------------------
 */
const agents = computed(() => $agent.agents);
const dialogForm = ref(false);
const selectedAgent = ref<IAgent>();
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * closeDialog
 */
function closeDialog() {
  selectedAgent.value = undefined;
  dialogForm.value = false;
}
/**
 * requestEdit
 * @param index
 */
function requestEdit(index: number) {
  selectedAgent.value = agents.value[index];
  dialogForm.value = true;
}
/**
 * -----------------------------------------
 *	Lifecycle
 * -----------------------------------------
 */
onBeforeMount(() => {
  Promise.all([$agent.list(), $agent.listGroup(), $user.list()]).catch((e) => {
    notificationHelper.axiosError(e, 'Error cargando datos');
  });
});
</script>
