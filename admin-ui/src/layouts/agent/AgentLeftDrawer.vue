<template>
  <q-drawer
    :model-value="sidebarOpen"
    @update:model-value="updateSidebarOpen"
    show-if-above
    side="left"
    :width="280"
  >
    <!-- profile -->
    <div class="text-center q-mt-md">
      <div class="text-grey-9 text-body1">Hola, {{ userName }}</div>
      <div class="text-grey-9 text-caption">
        {{ agentBussy ? 'Ocupado' : 'Disponible' }}
      </div>
    </div>
    <!-- / profile -->

    <!-- list -->
    <div class="q-gutter-sm q-mt-md">
      <q-list class="rounded-borders" style="max-width: 350px">
        <!-- Home -->
        <q-item clickable exact :to="{ name: ROUTE_NAME.ADMIN_HOME }">
          <q-item-section avatar top>
            <q-avatar size="md" icon="mdi-home" />
          </q-item-section>

          <q-item-section class="text-grey-9">
            <q-item-label lines="1">Inicio</q-item-label>
          </q-item-section>
        </q-item>
        <!-- /Home -->

        <!-- Tasks -->
        <q-item clickable exact :to="{ name: ROUTE_NAME.ADMIN_HOME }">
          <q-item-section avatar top>
            <q-avatar size="md" icon="mdi-format-list-checks" />
          </q-item-section>

          <q-item-section class="text-grey-9">
            <q-item-label lines="1">Tareas</q-item-label>
          </q-item-section>
        </q-item>
        <!-- /Tasks -->

        <!-- Report -->
        <q-item clickable exact :to="{ name: ROUTE_NAME.ADMIN_HOME }">
          <q-item-section avatar top>
            <q-avatar size="md" icon="mdi-alert-circle-outline" />
          </q-item-section>

          <q-item-section class="text-grey-9">
            <q-item-label lines="1">Reportes</q-item-label>
          </q-item-section>
        </q-item>
        <!-- /Report -->

        <q-item clickable @click="logout">
          <q-item-section avatar top>
            <q-avatar size="md" icon="mdi-exit-to-app" />
          </q-item-section>

          <q-item-section class="text-grey-9">
            <q-item-label lines="1">Salir</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </div>
    <!-- / list -->
  </q-drawer>
</template>

<script setup lang="ts">
import { computed } from '@vue/reactivity';
import { useGuiHelper } from 'src/helpers';
import { injectStrict, _agentInjectable, _app, _user } from 'src/injectables';
import { ROUTE_NAME } from 'src/router';
import { useRouter } from 'vue-router';
/**
 * -----------------------------------------
 *	Inject
 * -----------------------------------------
 */
const $agent = injectStrict(_agentInjectable);
const $app = injectStrict(_app);
const $gui = useGuiHelper();
const $router = useRouter();
const $user = injectStrict(_user);

const userName = computed(() => $agent.agent?.nick);
const agentBussy = computed(() => $agent.agent?.bussy);
const sidebarOpen = computed(() => $app.leftDrawer);

/**
 * logout
 */
function logout() {
  $gui.deleteDialog({
    title: 'Salir',
    message: '¿Está seguro que desea salir?',
    onOk: () => {
      $user.logout();
      $router.push({ name: ROUTE_NAME.LOGIN });
    },
  });
}
/**
 * updateSidebarOpen
 * @param open
 */
function updateSidebarOpen(open: boolean) {
  $app.leftDrawer = open;
}
</script>
