<template>
  <q-layout view="lHh Lpr lff">
    <q-page-container class="bg-grey-9">
      <q-page>
        <login-form class="absolute-center" @auth="onAuth" />
      </q-page>
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
  if ($app.mode === 'advanced')
    void $router.push({ name: ROUTE_NAME.ADMIN_HOME });
  else void $router.push({ name: ROUTE_NAME.DELIVER_HOME });
}
</script>
