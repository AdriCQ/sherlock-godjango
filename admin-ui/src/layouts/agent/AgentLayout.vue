<template>
  <q-layout view="lHh LpR fFf">
    <!-- Agent Header -->
    <agent-header />
    <!-- / Agent Header -->

    <q-page-container class="text-grey-9 bg-grey-4">
      <q-pull-to-refresh @refresh="pullToRefresh" v-if="enableRefresh">
        <router-view />
      </q-pull-to-refresh>
      <router-view v-else />
    </q-page-container>

    <!-- Left Drawer -->
    <agent-left-drawer />
    <!-- / Left Drawer -->

    <!-- Agent Footer -->
    <agent-footer v-if="$q.platform.is.mobile" />
    <!-- / Agent Footer -->
  </q-layout>
</template>

<script setup lang="ts">
import AgentFooter from './AgentFooter.vue';
import AgentHeader from './AgentHeader.vue';
import AgentLeftDrawer from './AgentLeftDrawer.vue';
import { useMeta, useQuasar } from 'quasar';
import { computed, onBeforeMount } from 'vue';
import { $app, injectStrict, _agentInjectable } from 'src/injectables';
import { notificationHelper } from 'src/helpers';
import { useRoute } from 'vue-router';
import { ROUTE_NAME } from 'src/router';
/**
 * -----------------------------------------
 *	Injectable
 * -----------------------------------------
 */
const $agent = injectStrict(_agentInjectable);
const $q = useQuasar();
const $route = useRoute();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const agent = computed(() => $agent.agent);
const currentGpsPosition = computed(() => $app.currentPosition);
const enableRefresh = computed(
  () =>
    $route.name !== ROUTE_NAME.AGENT_HOME &&
    $route.name !== ROUTE_NAME.AGENT_CHECKPOINT
);

/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * Emit Position
 */
async function emitPosition() {
  if (agent.value && currentGpsPosition.value) {
    const resp = await $agent.update(agent.value.id, {
      position: currentGpsPosition.value,
    });
    $agent.agent = resp;
  }
}
/**
 * pullToRefresh
 * @param done
 */
async function pullToRefresh(done: CallableFunction) {
  await loadData();
  done();
}
/**
 * Load Data
 */
async function loadData() {
  try {
    await $app.getGpsPosition();
    await $agent.whoami();
    void $agent.listAssignments();
    void emitPosition();
  } catch (error) {
    notificationHelper.axiosError(error);
  }
}
/**
 * -----------------------------------------
 *	Lifecycle
 * -----------------------------------------
 */
onBeforeMount(() => {
  useMeta({
    title: 'Sherlock Agente',
  });
  loadData();
});
</script>
