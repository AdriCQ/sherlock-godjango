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
        <q-item v-if="group.id !== 1">
          <q-item-section>
            <q-select
              v-model="selectedAgent"
              :options="agents"
              emit-value
              map-options
              option-value="id"
              option-label="nick"
              label="Añadir Agente"
              dense
            />
          </q-item-section>
          <q-item-section
            avatar
            class="cursor-pointer"
            v-if="group.id !== 1"
            @click="addAgent"
          >
            <q-icon color="positive" name="mdi-plus" />
          </q-item-section>
        </q-item>

        <q-item
          v-for="(agent, uKey) in group.agents"
          :key="`agent-list-${uKey}-${agent.id}`"
        >
          <q-item-section>{{ agent.nick }}</q-item-section>
          <q-item-section
            avatar
            class="cursor-pointer"
            v-if="group.id !== 1"
            @click="removeAgent(agent.id)"
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
import { injectStrict, _agentInjectable } from 'src/injectables';
import { computed, ref, toRefs } from 'vue';
import { IAgentGroup } from 'src/types';
/**
 * -----------------------------------------
 *	Injection
 * -----------------------------------------
 */
const $agent = injectStrict(_agentInjectable);
const $emit = defineEmits<{
  (e: 'add-agent'): void;
  (e: 'remove-agent'): void;
  (e: 'update'): void;
  (e: 'cancel'): void;
}>();
const $gui = useGuiHelper();
const $props = defineProps<{ group: IAgentGroup }>();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const agents = computed(() => $agent.agents);
const { group } = toRefs($props);
const selectedAgent = ref();
/**
 * Add Agent
 */
async function addAgent() {
  $gui.deleteDialog({
    title: 'Añadir Agente',
    message: 'Va a agregar un nuevo Agente al grupo',
    onOk: async () => {
      notificationHelper.loading();
      try {
        await $agent.addAgentToGroup(selectedAgent.value, group.value.id);
        $emit('add-agent');
      } catch (error) {
        notificationHelper.axiosError(error, 'No se pudo Agente el usuario');
      }
      notificationHelper.loading(false);
    },
  });
}
/**
 * Remove Agent
 */
async function removeAgent(id: number) {
  $gui.deleteDialog({
    title: 'Eliminar Agente',
    message: 'Va a eliminar un nuevo Agente del grupo',
    onOk: async () => {
      notificationHelper.loading();
      try {
        await $agent.removeAgentFromGroup(id, group.value.id);
        $emit('remove-agent');
      } catch (error) {
        notificationHelper.axiosError(error, 'No se pudo eliminar el Agente');
      }
      notificationHelper.loading(false);
    },
  });
}
</script>
