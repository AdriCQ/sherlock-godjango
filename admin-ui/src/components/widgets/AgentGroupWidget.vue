<template>
  <q-card class="cursor-pointer">
    <q-card-section>
      <div class="text-body1">{{ $props.group.name }}</div>
      <div class="text-subtitle2">
        <q-icon name="mdi-account-multiple" class="q-mr-sm" />
        <span
          >{{
            $props.group.agents?.length ? $props.group.agents.length : 0
          }}
          Agentes</span
        >
      </div>
    </q-card-section>
  </q-card>
</template>

<script setup lang="ts">
import { IAgentGroup } from 'src/types';
const $props = defineProps<{ group: IAgentGroup }>();
</script>
