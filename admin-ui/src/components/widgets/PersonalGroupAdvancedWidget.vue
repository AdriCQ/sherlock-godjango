<template>
  <q-card class="text-grey-9">
    <q-card-section>
      <div class="text-body1 text-center">{{ group.name }}</div>
      <p>{{ group.description }}</p>

      <div
        class="absolute-top-right q-pa-sm cursor-pointer"
        @click="$emit('cancel')"
      >
        <q-icon name="mdi-close" />
      </div>
    </q-card-section>
    <q-card-section class="q-pa-sm">
      <q-list bordered separator>
        <q-item>
          <q-item-section>
            <q-select
              v-model="selectedUser"
              :options="allUsers"
              emit-value
              map-options
              option-value="id"
              option-label="name"
              label="Añadir Agente"
              dense
            />
          </q-item-section>
          <q-item-section avatar class="cursor-pointer" @click="addUser">
            <q-icon color="positive" name="mdi-plus" />
          </q-item-section>
        </q-item>

        <q-item
          v-for="(user, uKey) in group.users"
          :key="`user-list-${uKey}-${user.id}`"
        >
          <q-item-section>{{ user.name }}</q-item-section>
          <q-item-section
            avatar
            class="cursor-pointer"
            @click="removeUser(user.id)"
          >
            <q-icon color="negative" name="mdi-delete" />
          </q-item-section>
        </q-item>
      </q-list>
    </q-card-section>
  </q-card>
</template>

<script setup lang="ts">
import { notificationHelper, useGuiHelper } from 'src/helpers';
import { injectStrict, _personalGroup, _user } from 'src/injectables';
import { IPersonalGroup } from 'src/types';
import { computed, ref, toRefs } from 'vue';

const $emit = defineEmits<{
  (e: 'add-user'): void;
  (e: 'remove-user'): void;
  (e: 'update'): void;
  (e: 'cancel'): void;
}>();
const $gui = useGuiHelper();
const $pGroup = injectStrict(_personalGroup);
const $props = defineProps<{ group: IPersonalGroup }>();
const $user = injectStrict(_user);
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const allUsers = computed(() => $user.allUsers);
const { group } = toRefs($props);
const selectedUser = ref();
/**
 * addUser
 */
async function addUser() {
  $gui.deleteDialog({
    title: 'Añadir Agente',
    message: 'Va a agregar un nuevo Agente al grupo',
    onOk: async () => {
      notificationHelper.loading();
      try {
        await $pGroup.addUser(group.value.id, selectedUser.value);
        notificationHelper.success(['Agente agragado']);
        $emit('add-user');
      } catch (error) {
        notificationHelper.axiosError(error, 'No se pudo Agente el usuario');
      }
      notificationHelper.loading(false);
    },
  });
}
/**
 * removeUser
 */
async function removeUser(id: number) {
  $gui.deleteDialog({
    title: 'Eliminar Agente',
    message: 'Va a eliminar un nuevo Agente del grupo',
    onOk: async () => {
      notificationHelper.loading();
      try {
        await $pGroup.removeUser(group.value.id, id);
        notificationHelper.success(['Agente Eliminado']);
        $emit('add-user');
      } catch (error) {
        notificationHelper.axiosError(error, 'No se pudo eliminar el Agente');
      }
      notificationHelper.loading(false);
    },
  });
}
</script>
