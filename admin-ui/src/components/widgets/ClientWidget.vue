<template>
  <q-card>
    <q-card-section>
      <div class="text-h6">{{ $props.client.name }}</div>
      <div class="text-subtitle2">{{ $props.client.description }}</div>
      <template v-if="$props.client.users?.length">
        <div class="text-subtitle2">
          <q-icon name="mdi-account" class="q-mr-sm" />{{
            $props.client.users[0].name
          }}
        </div>
        <div class="text-subtitle2">
          <q-icon name="mdi-email" class="q-mr-sm" />{{
            $props.client.users[0].email
          }}
        </div>
        <div class="text-subtitle2">
          <q-icon name="mdi-phone" class="q-mr-sm" />{{
            $props.client.users[0].phone
          }}
        </div>
      </template>
    </q-card-section>
    <q-card-actions>
      <q-btn
        @click="$emits('edit', $props.client.id)"
        outline
        icon="mdi-pencil"
        color="primary"
        label="Editar"
        dense />
      <q-btn
        @click="$emits('remove', $props.client.id)"
        outline
        icon="mdi-delete"
        color="negative"
        label="Eliminar"
        dense />
    </q-card-actions>
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
const $emits = defineEmits<{
  (e: 'remove', id: number):void,
  (e: 'edit', id: number):void,
}>();
</script>
