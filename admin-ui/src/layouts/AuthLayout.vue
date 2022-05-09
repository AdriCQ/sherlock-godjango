<template>
  <q-layout view="lHh Lpr lff">
    <q-page-container class="bg-primary">
      <div class="full-width q-px-sm bg-transparent">
        <login-form class="absolute-center" @auth="onAuth" />
      </div>
    </q-page-container>
  </q-layout>
</template>

<script lang="ts" setup>
import LoginForm from 'src/components/forms/LoginForm.vue';
import { injectStrict, _app } from 'src/injectables';
import { ROUTE_NAME } from 'src/router';
import { useRouter } from 'vue-router';

/**
 * -----------------------------------------
 *	Injectable
 * -----------------------------------------
 */
const $app = injectStrict(_app);
const $router = useRouter();
/**
 * onAuth
 */
function onAuth() {
  if ($app.mode === 'admin') void $router.push({ name: ROUTE_NAME.ADMIN_HOME });
  else void $router.push({ name: ROUTE_NAME.DELIVER_HOME });
}
</script>
