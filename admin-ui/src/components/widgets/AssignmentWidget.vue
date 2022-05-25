<template>
  <q-card class="cursor-pointer" @click="goToAssignment($props.assignment.id)">
    <q-card-section>
      <div class="text-body1">{{ $props.assignment.name }}</div>
      <div class="text-subtitle2">
        <q-icon name="mdi-account" class="q-mr-sm" />{{
          $props.assignment.agent?.nick
        }}
      </div>
      <div class="text-subtitle2">
        <q-chip
          class="glossy"
          :icon="!$props.assignment.status ? 'mdi-clock' : 'mdi-check'"
          :label="!$props.assignment.status ? 'En Progreso' : 'Completado'"
        />
      </div>
    </q-card-section>
  </q-card>
</template>

<script setup lang="ts">
import { ROUTE_NAME } from 'src/router';
import { IAssignment } from 'src/types';
import { useRouter } from 'vue-router';
/**
 * -----------------------------------------
 *	Inject
 * -----------------------------------------
 */
const $props = defineProps<{ assignment: IAssignment }>();
const $router = useRouter();
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * Go To Assignment
 * @param id
 */
function goToAssignment(id: number) {
  void $router.push({
    name: ROUTE_NAME.ADMIN_ASSIGNMENT,
    params: { id },
  });
}
</script>
