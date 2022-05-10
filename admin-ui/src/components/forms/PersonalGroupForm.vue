<template>
  <q-card>
    <q-form @submit.prevent="onSubmit">
      <q-card-section class="q-gutter-y-sm">
        <q-input v-model="form.name" type="text" label="Nombre del Grupo" />
        <q-input
          v-model="form.description"
          type="textarea"
          label="Descripción del Grupo"
        />
      </q-card-section>

      <q-card-actions>
        <q-btn
          oulined
          color="primary"
          icon="mdi-cancel"
          label="Cancelar"
          @click="$emit('cancel')"
        />
        <q-btn color="primary" icon="mdi-check" label="Guardar" type="submit" />
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script setup lang="ts">
import { notificationHelper } from 'src/helpers';
import { injectStrict, _personalGroup } from 'src/injectables';
import { IPersonalGroup } from 'src/types';
import { ref } from 'vue';

const $emit = defineEmits<{
  (e: 'complete'): void;
  (e: 'cancel'): void;
}>();
const $pGroup = injectStrict(_personalGroup);

const form = ref<Omit<IPersonalGroup, 'id' | 'users'>>({
  name: '',
  description: '',
});
/**
 * onSubmit
 */
async function onSubmit() {
  try {
    await $pGroup.create(form.value);
    $emit('complete');
  } catch (error) {
    notificationHelper.axiosError(error, 'No se pudo guardar');
  }
}
</script>
