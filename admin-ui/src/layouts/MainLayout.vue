<template>
  <q-layout view="lHh LpR fFf">
    <app-header />
    <q-page-container class="text-grey-9 bg-grey-4">
      <q-pull-to-refresh @refresh="pullToRefresh" v-if="enableRefresh">
        <router-view />
      </q-pull-to-refresh>
      <router-view v-else />
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
import { computed, onBeforeMount } from 'vue';
import { useQuasar } from 'quasar';
import {
  injectStrict,
  _agentInjectable,
  _eventInjectable,
  _user,
} from 'src/injectables';
import { notificationHelper } from 'src/helpers';
import { useRoute } from 'vue-router';
import { ROUTE_NAME } from 'src/router';
/**
 * -----------------------------------------
 *	inject
 * -----------------------------------------
 */
const $agent = injectStrict(_agentInjectable);
const $event = injectStrict(_eventInjectable);
const $user = injectStrict(_user);
const $q = useQuasar();
const $route = useRoute();

const enableRefresh = computed(() => $route.name !== ROUTE_NAME.ADMIN_HOME);

async function pullToRefresh(done: CallableFunction) {
  Promise.all([
    $user.list(),
    $agent.list(),
    $agent.listGroup(),
    $event.listOnProgress(),
  ])
    .catch((e) => {
      notificationHelper.axiosError(e, 'Error de conexión');
    })
    .finally(() => {
      done();
    });
}
/**
 * -----------------------------------------
 *	Lifecycle
 * -----------------------------------------
 */

onBeforeMount(() => {
  void pullToRefresh(() => {
    console.log('Main');
  });
});
</script>
