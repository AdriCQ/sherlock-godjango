<template>
  <q-card>
    <q-card-section :class="`${type.bg} q-pa-sm`">
      <div class="text-subtitle2 absolute-top-right">
        <q-chip
          class="glossy"
          :color="$props.event.status === 'completed' ? 'positive' : ''"
          :text-color="$props.event.status === 'completed' ? 'white' : ''"
          :icon="
            $props.event.status === 'completed' ? 'mdi-check' : 'mdi-clock'
          "
          :label="
            $props.event.status === 'completed' ? 'Resuelto' : 'Pendiente'
          "
        />
      </div>
      <q-icon color="dark" size="sm" :name="type.icon" />
    </q-card-section>
    <q-card-section>
      <div class="text-subtitle2">
        <q-icon name="mdi-account" class="q-mr-sm" />
        {{ $props.event.agent?.nick }}
      </div>
      <div class="text-subtitle2">{{ $props.event.details }}</div>
    </q-card-section>
    <template v-if="$props.advanced">
      <q-card-section>
        <div class="text-subtitle2">
          <q-icon name="mdi-account" class="q-mr-sm" />
          Agente: {{ $props.event.agent?.nick }}
        </div>
        <div class="text-subtitle2">
          <q-icon name="mdi-clock-in" class="q-mr-sm" />
          Fecha Creación:
          {{ new Date($props.event.created_at).toLocaleDateString() }}
        </div>
        <div class="text-subtitle2">
          <q-icon name="mdi-clock-out" class="q-mr-sm" />
          Fecha Actualización:
          {{ new Date($props.event.updated_at).toLocaleDateString() }}
        </div>
      </q-card-section>

      <q-card-actions v-if="$props.event.status !== 'completed'">
        <q-btn
          color="primary"
          icon="mdi-check"
          label="Completar"
          @click="$emit('request-complete')"
        />
      </q-card-actions>
    </template>
  </q-card>
</template>

<script setup lang="ts">
import { IEvent } from 'src/types';
import { computed } from 'vue';

const $emit = defineEmits<{ (e: 'request-complete'): void }>();
const $props = defineProps<{ event: IEvent; advanced?: boolean }>();
const type = computed<{ bg: string; icon: string }>(() => {
  switch ($props.event.type) {
    case 'danger':
      return { bg: 'bg-negative', icon: 'mdi-alert-outline' };
    case 'warning':
      return { bg: 'bg-warning', icon: 'mdi-alert-box' };
    default:
      return { bg: 'bg-info', icon: 'mdi-information-outline' };
  }
});
</script>
