<template>
  <q-footer elevated class="bg-primary">
    <q-tabs
      align="justify"
      indicator-color="transparent"
      active-color="secondary"
      id="tab-buttons"
      no-caps
    >
      <q-route-tab exact :to="{ name: ROUTE_NAME.ADMIN_EVENTS }">
        <q-icon name="mdi-bell-outline" size="1.6rem" />
        <q-badge
          color="warning"
          text-color="dark"
          floating
          v-if="eventCounter > 0"
        >
          {{ eventCounter }}
        </q-badge>
      </q-route-tab>
      <q-route-tab exact :to="{ name: ROUTE_NAME.ADMIN_HOME }">
        <q-icon name="mdi-home" size="1.6rem" />
      </q-route-tab>
      <q-route-tab exact>
        <q-icon name="mdi-map-marker" size="1.6rem" />
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
import { injectStrict, _app, _eventInjectable } from 'src/injectables';
import { ROUTE_NAME } from 'src/router';
import { computed } from 'vue';
/**
 * -----------------------------------------
 *	Setup
 * -----------------------------------------
 */
const $app = injectStrict(_app);
const $event = injectStrict(_eventInjectable);
/**
 * -----------------------------------------
 *	data
 * -----------------------------------------
 */
const eventCounter = computed(() => $event.events.length);
</script>

<style>
.footer-tabs .q-tab__icon {
  font-size: 5rem;
}
</style>
