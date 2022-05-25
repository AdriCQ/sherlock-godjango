<template>
  <q-page padding>
    <q-card class="no-box-shadow">
      <q-card-section>
        <div class="text-h6 text-center">Asignaciones</div>
      </q-card-section>
      <q-card-section>
        <div class="row q-col-gutter-sm">
          <div
            class="col-xs-12 col-sm-6 col-md-4 col-lg-3"
            v-for="(a, aKey) in assignments"
            :key="`ass-${a.id}-${aKey}`"
          >
            <assignment-widget :assignment="a" />
          </div>
        </div>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import { injectStrict, _assignmentInjectable } from 'src/injectables';
import { computed, onBeforeMount } from 'vue';
import AssignmentWidget from 'src/components/widgets/AssignmentWidget.vue';
/**
 * -----------------------------------------
 *	Inject
 * -----------------------------------------
 */
const $assignment = injectStrict(_assignmentInjectable);
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const assignments = computed(() => $assignment.assignments);
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
onBeforeMount(() => {
  void $assignment.filter({ status: 0 });
});
</script>
