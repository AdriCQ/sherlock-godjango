<template>
  <q-header elevated class="bg-primary" height-hint="98">
    <q-toolbar>
      <q-btn dense flat round icon="mdi-menu" @click="toggleDrawer" />

      <q-toolbar-title> AppTitle </q-toolbar-title>
    </q-toolbar>

    <!-- <q-tabs align="left" v-if="!$q.platform.is.mobile">
      <q-route-tab :to="{ name: ROUTE_NAME.DISH_LIST }" label="Menu" />
      <q-route-tab :to="{ name: ROUTE_NAME.EVENT_LIST }" label="Eventos" />
      <q-route-tab :to="{ name: ROUTE_NAME.CONFIG }" label="Configuración" />
    </q-tabs> -->
  </q-header>
</template>

<script setup lang="ts">
import { injectStrict, _app } from 'src/injectables';
// import { ROUTE_NAME } from 'src/router';

const $app = injectStrict(_app);

function toggleDrawer() {
  $app.toggleLeftDrawer();
}
</script>
