<template>
  <q-footer elevated class="bg-primary">
    <q-tabs
      align="justify"
      indicator-color="transparent"
      active-color="secondary"
      id="tab-buttons"
      no-caps
    >
      <q-route-tab exact :to="{ name: ROUTE_NAME.AGENT_HOME }">
        <q-icon name="mdi-checkbox-marked-circle-outline" size="1.6rem" />
      </q-route-tab>
      <q-route-tab exact :to="{ name: ROUTE_NAME.AGENT_ASSIGNMENTS }">
        <q-icon name="mdi-format-list-checks" size="1.6rem" />
        <q-badge
          color="warning"
          text-color="dark"
          floating
          v-if="checkpointCounter > 0"
        >
          {{ checkpointCounter }}
        </q-badge>
      </q-route-tab>

      <q-route-tab exact :to="{ name: ROUTE_NAME.AGENT_REPORTS }">
        <q-icon name="mdi-bell-outline" size="1.6rem" />
      </q-route-tab>

      <!-- <q-route-tab exact icon="mdi-magnify" :to="{name: 'main.home'}">
        <span class="text-body2 text-weight-bolder">Buscar</span>
      </q-route-tab>-->
      <q-tab>
        <q-icon
          size="1.6rem"
          name="mdi-apps"
          @click="$app.toggleLeftDrawer()"
        />
      </q-tab>
    </q-tabs>
  </q-footer>
</template>
<script lang="ts" setup>
import { injectStrict, _agentInjectable, _app } from 'src/injectables';
import { ROUTE_NAME } from 'src/router';
import { computed } from 'vue';
/**
 * -----------------------------------------
 *	Setup
 * -----------------------------------------
 */
const $app = injectStrict(_app);
const $agent = injectStrict(_agentInjectable);
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
</script>

<style>
.footer-tabs .q-tab__icon {
  font-size: 5rem;
}
</style>
