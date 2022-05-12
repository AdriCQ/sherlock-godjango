<template>
  <q-card>
    <q-form @submit.prevent="onSubmit">
      <q-card-section>
        <q-toggle
          v-model="form.mode"
          true-value="user"
          false-value="nick"
          color="green"
          :label="
            form.mode === 'user' ? 'Buscar por Usuario' : 'Buscar por Nick'
          "
        />
        <q-input
          v-if="form.mode === 'user'"
          v-model="form.search"
          type="search"
          placeholder="Nombre/Email"
          bg-color="white"
          outlined
          required
          dense
        >
          <template v-slot:after>
            <q-btn
              icon="mdi-magnify"
              color="primary"
              dense
              aria-label="Search"
              type="submit"
              @click="onSubmit"
            />
          </template>
        </q-input>

        <q-input
          v-else
          v-model="form.search"
          type="search"
          placeholder="Nick de Agente"
          bg-color="white"
          outlined
          dense
          required
        >
          <template v-slot:after>
            <q-btn
              icon="mdi-magnify"
              color="primary"
              dense
              aria-label="Search"
              type="submit"
              @click="onSubmit"
            />
          </template>
        </q-input>
      </q-card-section>
    </q-form>
  </q-card>
</template>

<script setup lang="ts">
import { notificationHelper } from 'src/helpers';
import { injectStrict, _agentInjectable } from 'src/injectables';
import { IAgent, IAgentSearchRequest } from 'src/types';
import { ref } from 'vue';

const $agent = injectStrict(_agentInjectable);
const $emit = defineEmits<{ (e: 'search', p: IAgent[]): void }>();

const form = ref<IAgentSearchRequest>({
  mode: 'user',
  search: '',
});
/**
 * onSubmit
 */
async function onSubmit() {
  try {
    $emit('search', (await $agent.search(form.value)).data.data);
  } catch (error) {
    notificationHelper.axiosError(error, 'Error en la busqueda');
  }
}
</script>
