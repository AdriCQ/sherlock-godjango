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
import { injectStrict, _app, _user } from 'src/injectables';
import { ROUTE_NAME } from 'src/router';
import { onBeforeMount } from 'vue';
import { useRouter } from 'vue-router';

/**
 * -----------------------------------------
 *	Injectable
 * -----------------------------------------
 */
const $app = injectStrict(_app);
const $user = injectStrict(_user);
const $router = useRouter();
/**
 * onAuth
 */
function onAuth() {
  if ($app.mode === 'manager')
    void $router.push({ name: ROUTE_NAME.ADMIN_HOME });
  else void $router.push({ name: ROUTE_NAME.AGENT_HOME });
}
/**
 * -----------------------------------------
 *	Lifecycle
 * -----------------------------------------
 */
onBeforeMount(() => {
  $user.load();
  if ($user.api_token) onAuth();
});
</script>
