<template>
  <q-header elevated class="bg-primary" height-hint="98">
    <q-toolbar>
      <q-btn
        dense
        flat
        round
        :icon="$app.mode === 'admin' ? 'mdi-logout' : 'mdi-menu'"
        @click="toggleDrawer"
      />

      <q-toolbar-title> {{ title }} </q-toolbar-title>
      <template v-if="!$q.platform.is.mobile">
        <q-btn
          flat
          round
          dense
          icon="mdi-format-list-checks"
          :to="{ name: ROUTE_NAME.ADMIN_HOME }"
        >
          <q-badge
            color="warning"
            text-color="dark"
            floating
            v-if="assignmentCounter > 0"
          >
            {{ assignmentCounter }}
          </q-badge>
        </q-btn>

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
import {
  $user,
  injectStrict,
  _app,
  _assignmentInjectable,
  _eventInjectable,
} from 'src/injectables';
import { computed } from 'vue';
import { useQuasar } from 'quasar';
import { ROUTE_NAME } from 'src/router';
import { $router } from 'src/boot/router';

const $app = injectStrict(_app);
const $ass = injectStrict(_assignmentInjectable);
const $event = injectStrict(_eventInjectable);
const $q = useQuasar();
/**
 * -----------------------------------------
 *	data
 * -----------------------------------------
 */
const assignmentCounter = computed(() => $ass.assignments.length);
const eventCounter = computed(() => $event.events.length);
const title = computed(() =>
  $app.mode === 'manager' ? 'Sherlock Manager' : 'Sherlock Agente'
);
/**
 * -----------------------------------------
 *	methods
 * -----------------------------------------
 */

function toggleDrawer() {
  if ($app.mode === 'admin') {
    $user.logout();
    void $router.push({ name: ROUTE_NAME.LOGIN });
  } else $app.toggleLeftDrawer();
}
</script>
