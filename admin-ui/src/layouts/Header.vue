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
          icon="mdi-bell-outline"
          :to="{ name: ROUTE_NAME.ADMIN_EVENTS }"
        >
          <q-badge
            color="warning"
            text-color="dark"
            floating
            v-if="eventCounter > 0"
          >
            {{ eventCounter }}
          </q-badge>
        </q-btn>
      </template>
    </q-toolbar>
  </q-header>
</template>

<script setup lang="ts">
import { injectStrict, _app, _eventInjectable } from 'src/injectables';
import { computed } from 'vue';
import { useQuasar } from 'quasar';
import { ROUTE_NAME } from 'src/router';

const $app = injectStrict(_app);
const $event = injectStrict(_eventInjectable);
const $q = useQuasar();

const eventCounter = computed(() => $event.events.length);
const title = computed(() =>
  $app.mode === 'manager' ? 'Sherlock Manager' : 'Sherlock Agente'
);
function toggleDrawer() {
  $app.toggleLeftDrawer();
}
</script>
