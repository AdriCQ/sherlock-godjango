<template>
  <q-layout view="lHh LpR fFf">
    <app-header />
    <q-page-container>
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
</script>
