<template>
  <q-layout view="lHh LpR fFf">
    <app-header />
    <q-page-container class="text-grey-9 bg-grey-4">
      <router-view />
    </q-page-container>

    <!-- leftDrawer -->
    <manager-left-drawer />
    <!-- / leftDrawer -->
    <main-footer v-if="$q.platform.is.mobile" />
  </q-layout>
</template>

<script setup lang="ts">
import AppHeader from './Header.vue';
import MainFooter from './MainFooter.vue';
import ManagerLeftDrawer from './ManagerLeftDrawer.vue';
import { onBeforeMount } from 'vue';
import { useMeta, useQuasar } from 'quasar';
import { injectStrict, _app, _eventInjectable } from 'src/injectables';
/**
 * -----------------------------------------
 *	inject
 * -----------------------------------------
 */
const $app = injectStrict(_app);
const $event = injectStrict(_eventInjectable);
const $q = useQuasar();
/**
 * -----------------------------------------
 *	Lifecycle
 * -----------------------------------------
 */

onBeforeMount(() => {
  if ($app.mode === 'manager') {
    useMeta({ title: 'Sherlock Manager' });
    void $event.listOnProgress();
  } else useMeta({ title: 'Sherlock Agente' });
});
</script>
