<template>
  <router-view />
</template>

<script setup lang="ts">
import { _app, $app, _user, $user, _map, $mapInjectable } from './injectables';
import { provide } from 'vue';

provide(_app, $app);
provide(_map, $mapInjectable);
provide(_user, $user);
</script>
