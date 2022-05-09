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
      <div class="text-grey-9 text-body1">Hola, Usuario</div>
    </div>
    <!-- / profile -->

    <!-- list -->
    <div class="q-gutter-sm q-mt-md">
      <q-list class="rounded-borders" style="max-width: 350px">
        <!-- Mis Pedidos -->
        <q-item clickable :to="{ name: ROUTE_NAME.ADMIN_USERS }">
          <q-item-section avatar top>
            <q-avatar size="md" icon="mdi-account-group" />
          </q-item-section>

          <q-item-section class="text-grey-9">
            <q-item-label lines="1">Usuarios</q-item-label>
          </q-item-section>
        </q-item>
        <!-- / Mis Pedidos -->

        <q-item clickable>
          <q-item-section avatar top>
            <q-avatar size="md" icon="mdi-wrench" />
          </q-item-section>

          <q-item-section class="text-grey-9">
            <q-item-label lines="1">Configuracion</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </div>
    <!-- / list -->
  </q-drawer>
</template>

<script setup lang="ts">
import { computed } from '@vue/reactivity';
import { injectStrict, _app } from 'src/injectables';
import { ROUTE_NAME } from 'src/router';
/**
 * -----------------------------------------
 *	Inject
 * -----------------------------------------
 */

const $app = injectStrict(_app);

const sidebarOpen = computed(() => $app.leftDrawer);

function updateSidebarOpen(open: boolean) {
  $app.leftDrawer = open;
}
</script>
