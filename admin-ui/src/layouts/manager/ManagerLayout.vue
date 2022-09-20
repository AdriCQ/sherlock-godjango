<template>
  <q-layout view="lHh LpR fFf">
    <app-header />
    <q-page-container class="text-grey-9 bg-grey-4">
      <q-pull-to-refresh @refresh="pullToRefresh" v-if="enableRefresh">
        <router-view />
      </q-pull-to-refresh>
      <router-view v-else />
    </q-page-container>

    <template v-if="appMode !== 'admin'">
      <!-- leftDrawer -->
      <manager-left-drawer />
      <!-- / leftDrawer -->
      <main-footer v-if="$q.platform.is.mobile" />
    </template>
  </q-layout>
</template>

<script setup lang="ts">
import AppHeader from './ManagerHeader.vue';
import MainFooter from './ManagerFooter.vue';
import ManagerLeftDrawer from './ManagerLeftDrawer.vue';
import { computed, onBeforeMount, onBeforeUnmount, ref } from 'vue';
import { useQuasar } from 'quasar';
import {
  injectStrict,
  _agentInjectable,
  _assignmentInjectable,
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
const $assignment = injectStrict(_assignmentInjectable);
const $event = injectStrict(_eventInjectable);
const $user = injectStrict(_user);
const $q = useQuasar();
const $route = useRoute();

const appMode = computed(() => $user.profile.role.name);

const enableRefresh = computed(
  () =>
    $route.name !== ROUTE_NAME.ADMIN_HOME &&
    $route.name !== ROUTE_NAME.ADMIN_ASSIGNMENT &&
    $route.name !== ROUTE_NAME.ADMIN_AGENTS_MAP
);

const interval = ref();
/**
 * pullToRefresh
 * @param done
 */
async function pullToRefresh(done: CallableFunction) {
  Promise.all([
    $assignment.filter({ status: 0 }),
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

  interval.value = setInterval(() => {
    $agent.list().catch(_e => { console.log('Error al listar agentes', _e) });
  }, 20000)
});

onBeforeUnmount(() => {
  clearInterval(interval.value);
})
</script>
