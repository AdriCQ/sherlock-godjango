<template>
  <q-page padding>
    <q-card>
      <q-card-section>
        <div class="text-h6 text-center">Reportes</div>
        <div class="text-subtitle2">
          <q-btn
            color="primary"
            class="full-width"
            icon="mdi-plus"
            label="Nuevo Reporte"
            @click="dialogReport = true"
          />
        </div>
      </q-card-section>
      <q-card-section v-if="events.length">
        <div class="row q-col-gutter-sm">
          <div
            class="col-xs-12 col-sm-6 col-md-4 col-lg-3"
            v-for="(ev, eKey) in events"
            :key="`event-widget-${ev.id}-${eKey}`"
          >
            <event-widget :event="ev" editable />
          </div>
        </div>
      </q-card-section>
    </q-card>

    <q-dialog v-model="dialogReport">
      <event-form
        :agent="agent"
        style="min-width: 20rem"
        @cancel="dialogReport = false"
        @complete="dialogReport = false"
      />
    </q-dialog>
  </q-page>
</template>

<script setup lang="ts">
import { notificationHelper } from 'src/helpers';
import {
  injectStrict,
  _agentInjectable,
  _eventInjectable,
} from 'src/injectables';
import { computed, onBeforeMount, ref } from 'vue';
import EventWidget from 'src/components/widgets/EventWidget.vue';
import EventForm from 'src/components/forms/EventForm.vue';
import { IAgent } from 'src/types';

/**
 * -----------------------------------------
 *	Inject
 * -----------------------------------------
 */
const $agent = injectStrict(_agentInjectable);
const $event = injectStrict(_eventInjectable);
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const agent = computed<IAgent>(() => $agent.agent as IAgent);
const dialogReport = ref(false);
const events = computed(() => $event.events);
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * My Events
 */
async function myEvents() {
  try {
    await $event.mine();
  } catch (error) {
    notificationHelper.axiosError(error);
  }
}
/**
 * On Before Mount
 */
onBeforeMount(async () => {
  await myEvents();
});
</script>
