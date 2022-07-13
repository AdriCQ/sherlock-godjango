<template>
  <q-page padding>
    <q-card class="no-box-shadow">
      <q-card-section>
        <div class="text-h6">Administración de Clientes</div>
        <div class="text-subtitle2">
          <q-btn
            color="primary"
            icon="mdi-plus"
            label="Nuevo"
            @click="addClient"
          />
        </div>
      </q-card-section>
      <q-card-section>
        <div class="row q-col-gutter-sm">
          <div
            class="col-xs-12 col-sm-6 col-md-4 col-lg-3"
            v-for="client in clients.slice(1, clients.length)"
            :key="`client-w-${client.id}`"
          >
            <client-widget
              class="cursor-pointer"
              :client="client"
              @click="edit(client)"
            />
          </div>
        </div>
      </q-card-section>
    </q-card>

    <q-dialog v-model="dialog">
      <client-form
        :client="client"
        style="width: 25rem"
        @cancel="closeDialog"
        @completed="onComplete"
      />
    </q-dialog>
  </q-page>
</template>

<script setup lang="ts">
import { $api } from 'src/boot/axios';
import { IApiResponse, IClient } from 'src/types';
import { onBeforeMount, ref } from 'vue';
import ClientWidget from 'src/components/widgets/ClientWidget.vue';
import ClientForm from 'src/components/forms/ClientForm.vue';

const client = ref<IClient>();
const clients = ref<IClient[]>([]);
const dialog = ref(false);

function addClient() {
  closeDialog();
  dialog.value = true;
}

function closeDialog() {
  client.value = undefined;
  dialog.value = false;
}

function edit(c: IClient) {
  client.value = c;
  dialog.value = true;
}
function onComplete(p: IClient) {
  const index = clients.value.findIndex((c) => c.id === p.id);
  if (index >= 0) {
    clients.value[index] = p;
  } else {
    clients.value.unshift(p);
  }
  closeDialog();
}

onBeforeMount(async () => {
  try {
    const resp = await $api.get<IApiResponse<IClient[]>>('clients');
    clients.value = resp.data.data;
  } catch (error) {}
});
</script>
