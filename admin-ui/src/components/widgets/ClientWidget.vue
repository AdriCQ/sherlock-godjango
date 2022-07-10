<template>
  <q-card>
    <q-card-section>
      <div class="text-h6">{{ $props.client.name }}</div>
      <div class="text-subtitle2">{{ $props.client.description }}</div>
    </q-card-section>
  </q-card>
</template>

<script setup lang="ts">
import { IClient } from 'src/types';
/**
 * -----------------------------------------
 *	Inject
 * -----------------------------------------
 */
const $props = defineProps<{ client: IClient }>();
</script>
