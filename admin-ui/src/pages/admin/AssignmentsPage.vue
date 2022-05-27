<template>
  <q-page padding>
    <q-card class="no-box-shadow">
      <q-card-section>
        <div class="text-h6 text-center">Asignaciones</div>
        <div class="text-subtitle2">
          <q-btn
            color="primary"
            icon="mdi-plus"
            label="Nueva"
            @click="addAssignment"
            class="full-width"
          />
        </div>
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

    <q-dialog v-model="dialogAssignment">
      <assignment-form
        style="min-width: 20rem"
        @cancel="closeDialog"
        @complete="closeDialog"
      />
    </q-dialog>
  </q-page>
</template>

<script setup lang="ts">
import { injectStrict, _assignmentInjectable } from 'src/injectables';
import { computed, onBeforeMount, ref } from 'vue';
import AssignmentWidget from 'src/components/widgets/AssignmentWidget.vue';
import AssignmentForm from 'src/components/forms/AssignmentForm.vue';
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
const dialogAssignment = ref(false);
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * Add Assignment
 */
function addAssignment() {
  dialogAssignment.value = true;
}
function closeDialog() {
  dialogAssignment.value = false;
}
/**
 * On Before Mount
 */
onBeforeMount(() => {
  void $assignment.filter({ status: 0 });
});
</script>
