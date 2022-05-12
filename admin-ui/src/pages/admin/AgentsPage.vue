<template>
  <!-- <q-pull-to-refresh @refresh="pullToRefresh"> -->
  <q-page padding>
    <q-card class="no-box-shadow">
      <q-card-section class="q-gutter-y-sm">
        <div class="text-h6 text-center">Administrar Agentes</div>
        <div class="text-subtitle2">
          <q-btn
            color="primary"
            class="full-width"
            icon="mdi-magnify"
            label="Buscar Agente"
            @click="startSearch"
          />
        </div>
      </q-card-section>
      <q-card-section>
        <div class="row q-col-gutter-sm">
          <template v-if="search && search.length">
            <div
              class="col-xs-12 col-sm-6 col-md-4 col-lg-3"
              v-for="(agent, aKey) in search"
              :key="`agent-${agent.id}-k${aKey}`"
            >
              <agent-widget
                :agent="agent"
                @request-edit="requestEdit(agent.id)"
              />
            </div>
          </template>
          <template v-else>
            <div
              class="col-xs-12 col-sm-6 col-md-4 col-lg-3"
              v-for="(agent, aKey) in agents"
              :key="`agent-${agent.id}-k${aKey}`"
            >
              <agent-widget
                :agent="agent"
                @request-edit="requestEdit(agent.id)"
              />
            </div>
          </template>
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

    <!-- Dialog Search -->
    <q-dialog v-model="dialogSearch">
      <agent-search-form style="min-width: 20rem" @search="onSearch" />
    </q-dialog>
    <!-- / Dialog Search -->
  </q-page>
  <!-- </q-pull-to-refresh> -->
</template>

<script setup lang="ts">
import { notificationHelper } from 'src/helpers';
import { injectStrict, _agentInjectable, _user } from 'src/injectables';
import { computed, onBeforeMount, ref } from 'vue';
import AgentForm from 'src/components/forms/AgentForm.vue';
import AgentWidget from 'src/components/widgets/AgentWidget.vue';
import AgentSearchForm from 'src/components/forms/AgentSearchForm.vue';
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
const dialogSearch = ref(false);
const search = ref<IAgent[]>();
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
  search.value = undefined;
  dialogForm.value = false;
  dialogSearch.value = false;
}
/**
 * onSearch
 * @param res
 */
function onSearch(res: IAgent[]) {
  search.value = res;
}
/**
 * pullToRefresh
 */
async function pullToRefresh(done: CallableFunction) {
  Promise.all([$agent.list(), $agent.listGroup(), $user.list()])
    .catch((e) => {
      notificationHelper.axiosError(e, 'Error cargando datos');
    })
    .finally(() => {
      done();
    });
}
/**
 * requestEdit
 * @param id
 */
function requestEdit(id: number) {
  const index = agents.value.findIndex((a) => a.id === id);
  if (index >= 0) selectedAgent.value = agents.value[index];
  dialogForm.value = true;
}
/**
 * startSearch
 */
function startSearch() {
  closeDialog();
  dialogSearch.value = true;
}
/**
 * -----------------------------------------
 *	Lifecycle
 * -----------------------------------------
 */
onBeforeMount(() => {
  void pullToRefresh(() => {
    console.log('Agent Page');
  });
});
</script>
