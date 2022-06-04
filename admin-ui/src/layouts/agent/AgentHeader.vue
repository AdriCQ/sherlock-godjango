<template>
  <q-header elevated class="bg-primary" height-hint="98">
    <q-toolbar>
      <q-btn dense flat round icon="mdi-menu" @click="toggleDrawer" />

      <q-toolbar-title> {{ title }} </q-toolbar-title>
      <template v-if="!$q.platform.is.mobile">
        <q-btn
          flat
          round
          dense
          icon="mdi-format-list-checks"
          :to="{ name: ROUTE_NAME.AGENT_HOME }"
        >
          <q-badge
            color="warning"
            text-color="dark"
            floating
            v-if="checkpointCounter > 0"
          >
            {{ checkpointCounter }}
          </q-badge>
        </q-btn>

        <q-btn
          flat
          round
          dense
          icon="mdi-bell-outline"
          :to="{ name: ROUTE_NAME.AGENT_REPORTS }"
        />
      </template>
    </q-toolbar>
  </q-header>
</template>

<script setup lang="ts">
import { injectStrict, _app, _agentInjectable } from 'src/injectables';
import { computed } from 'vue';
import { useQuasar } from 'quasar';
import { ROUTE_NAME } from 'src/router';

const $agent = injectStrict(_agentInjectable);
const $app = injectStrict(_app);
const $q = useQuasar();
/**
 * -----------------------------------------
 *	data
 * -----------------------------------------
 */
const checkpointCounter = computed(() => {
  let counter = 0;
  $agent.assignments.forEach((as) => {
    if (as.checkpoints) counter += as.checkpoints.length;
  });
  return counter;
});
const title = computed(() =>
  $app.mode === 'manager' ? 'Sherlock Manager' : 'Sherlock Agente'
);
/**
 * -----------------------------------------
 *	methods
 * -----------------------------------------
 */

function toggleDrawer() {
  $app.toggleLeftDrawer();
}
</script>
