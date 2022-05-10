<template>
  <q-layout view="lHh LpR fFf">
    <app-header />
    <q-page-container class="text-grey-9 bg-grey-4">
      <router-view />
    </q-page-container>

    <!-- leftDrawer -->
    <left-drawer />
    <!-- / leftDrawer -->
  </q-layout>
</template>

<script setup lang="ts">
import AppHeader from './Header.vue';
import LeftDrawer from './LeftDrawer.vue';
import { onBeforeMount } from 'vue';
import { useMeta } from 'quasar';
import { injectStrict, _app } from 'src/injectables';
/**
 * -----------------------------------------
 *	inject
 * -----------------------------------------
 */
const $app = injectStrict(_app);
/**
 * -----------------------------------------
 *	Lifecycle
 * -----------------------------------------
 */

onBeforeMount(() => {
  if ($app.mode === 'manager') useMeta({ title: 'Sherlock Manager' });
  else useMeta({ title: 'Sherlock Agente' });
});
</script>
