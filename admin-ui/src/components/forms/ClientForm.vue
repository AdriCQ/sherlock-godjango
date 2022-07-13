<template>
  <q-card>
    <q-form @submit.prevent="onSubmit">
      <q-card-section class="q-gutter-y-sm">
        <div class="text-body1">Datos del Cliente</div>
        <q-input v-model="form.name" required type="text" label="Nombre" />
        <q-input
          v-model="form.description"
          required
          type="textarea"
          label="Detalles"
        />
      </q-card-section>
      <q-card-section class="q-gutter-y-sm" v-if="user">
        <div class="text-body1">Datos del Manager</div>

        <q-input v-model="user.name" type="text" label="Nombre" />
        <q-input v-model="user.email" type="email" label="Email" />
        <q-input v-model="user.phone" type="tel" label="Telefono" />
        <q-input v-model="user.password" type="password" label="Password" />
        <q-input
          v-model="user.password_confirmation"
          type="password"
          label="Repita Password"
        />
      </q-card-section>
      <q-card-actions>
        <q-btn
          color="primary"
          outlined
          label="Cancelar"
          @click="$emit('cancel')"
        />
        <q-btn color="primary" icon="mdi-check" label="Guardar" type="submit" />
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script setup lang="ts">
import { $api } from 'src/boot/axios';
import { notificationHelper } from 'src/helpers';
import {
  IApiResponse,
  IClient,
  IClientCreateRequest,
  IClientUpdateRequest,
  IUserCreateRequest,
} from 'src/types';
import { onBeforeMount, ref } from 'vue';
/**
 * -----------------------------------------
 *	Injext
 * -----------------------------------------
 */
const $emit = defineEmits<{
  (e: 'completed', p: IClient): void;
  (e: 'cancel'): void;
}>();
const $props = defineProps<{ client?: IClient }>();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const form = ref<IClientUpdateRequest | IClientCreateRequest>({
  description: '',
  name: '',
});

const user = ref<IUserCreateRequest | undefined>({
  email: '',
  name: '',
  phone: '',
  role_id: 0,
  password: '',
  password_confirmation: '',
});
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * on Submit
 */
async function onSubmit() {
  notificationHelper.loading();
  try {
    let resp: IApiResponse<IClient>;
    if ($props.client) {
      resp = (
        await $api.patch<IApiResponse<IClient>>(
          `clients/${$props.client.id}`,
          form.value
        )
      ).data;
    } else {
      if (user.value) (form.value as IClientCreateRequest).user = user.value;
      resp = (await $api.post<IApiResponse<IClient>>('clients', form.value))
        .data;
    }
    $emit('completed', resp.data);
  } catch (error) {
    notificationHelper.axiosError(error);
  }
  notificationHelper.loading(false);
}
/**
 * On Before Mount
 */
onBeforeMount(() => {
  if ($props.client) {
    form.value = {
      description: $props.client.description,
      name: $props.client.name,
    };
    user.value = undefined;
  }
});
</script>
