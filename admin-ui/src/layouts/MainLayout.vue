<template>
  <q-layout view="lHh LpR fFf">
    <app-header />
    <q-page-container class="text-grey-9 bg-grey-2">
      <router-view />
    </q-page-container>

    <!-- leftDrawer -->
    <admin-left-drawer />
    <!-- / leftDrawer -->
  </q-layout>
</template>

<script setup lang="ts">
import AppHeader from './Header.vue';
import AdminLeftDrawer from './AdminLeftDrawer.vue';
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
  if ($app.mode === 'admin') useMeta({ title: 'Sherlock Admin' });
  else useMeta({ title: 'Sherlock Deliver' });
});
</script>
