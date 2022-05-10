<template>
  <q-card class="cursor-pointer">
    <q-card-section>
      <div class="text-body1">{{ $props.group.name }}</div>
      <div class="text-subtitle2">
        <q-icon name="mdi-account-multiple" class="q-mr-sm" />
        <span
          >{{
            $props.group.users?.length ? $props.group.users.length : 0
          }}
          Agentes</span
        >
      </div>
    </q-card-section>
  </q-card>
</template>

<script setup lang="ts">
import { IPersonalGroup } from 'src/types';
const $props = defineProps<{ group: IPersonalGroup }>();
</script>
