<template>
  <router-view />
</template>

<script setup lang="ts">
import {
  _app,
  $app,
  _user,
  $user,
  _map,
  $mapInjectable,
  _agentInjectable,
  $agentInjectable,
  _eventInjectable,
  $event,
} from './injectables';
import { provide } from 'vue';

provide(_agentInjectable, $agentInjectable);
provide(_app, $app);
provide(_eventInjectable, $event);
provide(_map, $mapInjectable);
provide(_user, $user);
</script>
