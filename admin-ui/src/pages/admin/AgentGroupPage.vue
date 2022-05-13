<template>
  <q-page padding>
    <q-card class="no-box-shadow">
      <q-card-section>
        <div class="text-h6 text-center">Administrar Grupos</div>
        <div class="text-subtitle2">
          <q-btn
            color="primary"
            class="full-width"
            icon="mdi-plus"
            label="Nuevo Grupo"
            @click="dialogCreate = true"
          />
        </div>
      </q-card-section>
      <q-card-section v-if="groups">
        <div class="row q-col-gutter-sm">
          <div
            class="col-xs-12 col-sm-6 col-md-4 col-lg-3"
            v-for="(group, gKey) in groups"
            :key="`group-${group.id}-${gKey}`"
          >
            <agent-group-widget :group="group" @click="onGroupClick(group)" />
          </div>
        </div>
      </q-card-section>
    </q-card>

    <!-- Dialog Form -->
    <q-dialog v-model="dialogCreate">
      <agent-group-form
        class="full-width"
        @cancel="closeDialogs"
        @complete="closeDialogs"
      />
    </q-dialog>
    <!-- / Dialog Form -->

    <!-- Dialog users -->
    <q-dialog v-model="dialogAgents">
      <agent-group-advanced-widget
        style="min-width: 20rem"
        :key="`d-key-${dialogAgentsKey}`"
        :group="selectedGroup"
        v-if="selectedGroup"
        @add-agent="updateDialogAgents"
        @remove-agent="updateDialogAgents"
        @remove-group="closeDialogs"
        @cancel="closeDialogs"
      />
    </q-dialog>
    <!-- / Dialog users -->
  </q-page>
</template>

<script setup lang="ts">
import AgentGroupWidget from 'src/components/widgets/AgentGroupWidget.vue';
import AgentGroupAdvancedWidget from 'src/components/widgets/AgentGroupAdvancedWidget.vue';
import AgentGroupForm from 'src/components/forms/AgentGroupForm.vue';
import { notificationHelper } from 'src/helpers';
import { injectStrict, _agentInjectable } from 'src/injectables';
import { computed, onBeforeMount, ref } from 'vue';
import { IAgentGroup } from 'src/types';
/**
 * -----------------------------------------
 *	Injext
 * -----------------------------------------
 */
const $agent = injectStrict(_agentInjectable);
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const dialogCreate = ref(false);
const dialogAgents = ref(false);
const dialogAgentsKey = ref('a');
const groups = computed(() => $agent.groups);
const selectedGroup = ref<IAgentGroup>();

/**
 * -----------------------------------------
 *	Methids
 * -----------------------------------------
 */
/**
 * closeDialogs
 */
function closeDialogs() {
  dialogCreate.value = false;
  dialogAgents.value = false;
  selectedGroup.value = undefined;
}
/**
 * onGroupClick
 * @param g
 */
function onGroupClick(g: IAgentGroup) {
  closeDialogs();
  selectedGroup.value = g;
  dialogAgents.value = true;
}
/**
 * Update Dialog Agents
 */
async function updateDialogAgents() {
  await $agent.list();
  const index = groups.value.findIndex((g) => g.id === selectedGroup.value?.id);
  selectedGroup.value = groups.value[index];
  dialogAgentsKey.value = btoa(Date());
}

onBeforeMount(() => {
  Promise.all([void $agent.list(), void $agent.listGroup()]).catch((e) => {
    notificationHelper.axiosError(e, 'Error de red');
  });
});
</script>
