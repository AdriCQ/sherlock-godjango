<template>
  <q-pull-to-refresh @refresh="pullToRefresh">
    <q-page padding>
      <q-card class="no-box-shadow">
        <q-card-section>
          <div class="text-h6 text-center">Administrar Usuarios</div>
          <div class="text-subtitle2">
            <q-btn
              color="primary"
              class="full-width"
              icon="mdi-plus"
              label="Nuevo Usuario"
              @click="dialogUserForm = true"
            />
          </div>
        </q-card-section>
        <q-card-section>
          <div class="row q-col-gutter-sm">
            <div
              class="col-xs-12 col-sm-6 col-md-4"
              v-for="user of users"
              :key="`user-${user.id}`"
            >
              <user-widget
                :user="user"
                @remove="onUserRemoved"
                @request-edit="reqEditUser(user)"
              />
            </div>
          </div>
        </q-card-section>
      </q-card>

      <!-- Form Dialog -->
      <q-dialog v-model="dialogUserForm" maximized class="q-pa-md">
        <user-form
          :user="editUser"
          @form-complete="closeDialog"
          @cancel="closeDialog"
        />
      </q-dialog>
      <!-- /Form Dialog -->
    </q-page>
  </q-pull-to-refresh>
</template>

<script setup lang="ts">
import { notificationHelper, useGuiHelper } from 'src/helpers';
import { injectStrict, _user } from 'src/injectables';
import { IUserProfile } from 'src/types';
import { onBeforeMount, ref } from 'vue';
import UserWidget from 'src/components/widgets/UserWidget.vue';
import UserForm from 'src/components/forms/UserForm.vue';
import { computed } from '@vue/reactivity';
/**
 * -----------------------------------------
 *	Inject
 * -----------------------------------------
 */
const $gui = useGuiHelper();
const $user = injectStrict(_user);
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const dialogUserForm = ref(false);
const users = computed(() => $user.allUsers);
const editUser = ref<IUserProfile | undefined>();
/**
 * -----------------------------------------
 *	methods
 * -----------------------------------------
 */
/**
 * closeDialog
 */
function closeDialog() {
  console.log('Close Dialog');
  dialogUserForm.value = false;
  editUser.value = undefined;
}
/**
 * reqEditUser
 * @param p
 */
function reqEditUser(p: IUserProfile) {
  $gui.deleteDialog({
    title: 'Editar Usuario',
    message: 'Desea editar el usuario?',
    onOk: () => {
      editUser.value = p;
      dialogUserForm.value = true;
    },
  });
}
/**
 * listUsers
 */
async function listUsers() {
  try {
    await $user.list();
  } catch (error) {
    notificationHelper.axiosError(error, 'No se pudo listar los usuarios');
  }
}
/**
 * onUserRemoved
 * @param id
 */
function onUserRemoved(id: number) {
  const index = users.value?.findIndex((u) => u.id === id);
  if (!index) return;
  users.value?.splice(index, 1);
}
/**
 * pullToRefresh
 */
async function pullToRefresh(done: CallableFunction) {
  await listUsers();
  done();
}
/**
 * -----------------------------------------
 *	Lifecycle
 * -----------------------------------------
 */
onBeforeMount(() => {
  void listUsers();
});
</script>
