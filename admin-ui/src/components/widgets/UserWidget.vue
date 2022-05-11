<template>
  <q-card>
    <q-card-section>
      <div class="absolute-top-right q-pa-xs cursor-pointer">
        <div @click="remove">
          <q-icon name="mdi-delete" color="negative" />
        </div>
        <div @click="$emit('request-edit')">
          <q-icon name="mdi-pencil" color="primary" />
        </div>
      </div>
      <div class="text-body1">{{ user.name }}</div>
      <div class="text-body2">
        <q-icon name="mdi-email-outline" class="q-mr-sm" />{{ user.email }}
      </div>
      <div class="text-body2">
        <q-icon name="mdi-phone" class="q-mr-sm" />{{ user.phone }}
      </div>
      <div class="text-body2">
        <q-icon name="mdi-account-settings" class="q-mr-sm" />{{
          user.role.display_name
        }}
      </div>
    </q-card-section>
  </q-card>
</template>

<script setup lang="ts">
import { notificationHelper, useGuiHelper } from 'src/helpers';
import { $user } from 'src/injectables';
import { IUserProfile } from 'src/types';
import { toRefs } from 'vue';

const $emit = defineEmits<{
  (e: 'remove', id: number): void;
  (e: 'request-edit'): void;
}>();
const $gui = useGuiHelper();
const $props = defineProps<{ user: IUserProfile }>();

const { user } = toRefs($props);
/**
 * remove
 */
async function remove() {
  $gui.deleteDialog({
    title: 'Eliminar usuario',
    message: 'Desea eliminar el usuario?',
    onOk: async () => {
      try {
        await $user.remove(user.value.id);
        $emit('remove', user.value.id);
      } catch (error) {
        notificationHelper.axiosError(error, 'No se pudo eliminar el usuario');
      }
    },
  });
}
</script>
