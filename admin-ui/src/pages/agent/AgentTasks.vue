<template>
  <q-page padding>
    <q-card class="no-box-shadow">
      <q-card-section>
        <div class="text-h6 text-center">Tareas</div>
      </q-card-section>
      <q-card-section>
        <div class="row q-col-gutter-sm">
          <div
            class="col-xs-12 col-sm-6 col-md-4 col-lg-3"
            v-for="(ass, aKey) in assignments"
            :key="`assignment-${ass.id}-${aKey}`"
          >
            <assignment-widget :assignment="ass" as-agent />
          </div>
        </div>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import { injectStrict, _agentInjectable } from 'src/injectables';
import { computed } from 'vue';
import AssignmentWidget from 'src/components/widgets/AssignmentWidget.vue';
/**
 * -----------------------------------------
 *	Injectables
 * -----------------------------------------
 */
const $agent = injectStrict(_agentInjectable);
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const assignments = computed(() => $agent.assignments);
</script>
