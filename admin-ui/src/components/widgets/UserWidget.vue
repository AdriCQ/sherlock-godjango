<template>
  <q-card>
    <q-card-section>
      <div class="text-h6">{{ user.name }}</div>
      <div class="text-subtitle2">{{ user.email }}</div>
    </q-card-section>
  </q-card>
</template>

<script setup lang="ts">
import { IUserProfile } from 'src/types';
import { toRefs } from 'vue';

const $props = defineProps<{ user: IUserProfile }>();

const { user } = toRefs($props);
</script>
