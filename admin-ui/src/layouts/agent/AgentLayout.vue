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
const enableRefresh = true;
/**
 * pullToRefresh
 * @param done
 */
async function pullToRefresh(done: CallableFunction) {
  done();
}
</script>
