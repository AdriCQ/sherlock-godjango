<template>
  <q-page padding>
    <q-card class="no-box-shadow">
      <q-card-section>
        <div class="text-h6 text-center">
          Eventos {{ active ? 'Pendientes' : 'Resueltos' }}
        </div>
        <div class="text-subtitle text-center">
          <q-chip
            :class="{ glossy: active }"
            clickable
            icon="mdi-check"
            label="Resueltos"
            @click="active = false"
          />
          <q-chip
            :class="{ glossy: !active }"
            clickable
            icon="mdi-clock"
            label="Pendientes"
            @click="active = true"
          />
        </div>
      </q-card-section>
      <q-card-section>
        <div class="row q-col-gutter-sm">
          <div
            class="col-xs-12 col-sm-6 col-md-4"
            v-for="(event, eKey) in events"
            :key="`event-solved-${event.id}-${eKey}`"
          >
            <event-widget
              class="cursor-pointer"
              :event="event"
              @click="showDetails(event)"
            />
          </div>
        </div>
      </q-card-section>
    </q-card>

    <!-- Dialog Details -->
    <q-dialog v-model="dialogDetails">
      <event-widget
        style="min-width: 20rem; max-width: 30rem"
        :event="eventDetails"
        v-if="eventDetails"
        advanced
        @request-complete="onRequestComplete"
      />
    </q-dialog>
    <!-- / Dialog Details -->
  </q-page>
</template>

<script setup lang="ts">
import EventWidget from 'src/components/widgets/EventWidget.vue';
import { notificationHelper } from 'src/helpers';
import { injectStrict, _eventInjectable } from 'src/injectables';
import { IEvent } from 'src/types';
import { computed, onBeforeMount, ref } from 'vue';

const $event = injectStrict(_eventInjectable);
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const active = ref(true);
const dialogDetails = ref(false);
const eventDetails = ref<IEvent>();
const solved = ref<IEvent[]>([]);
const events = computed(() => (active.value ? $event.events : solved.value));

/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * onPullToRefresh
 * @param done
 */
async function onPullToRefresh(done: CallableFunction) {
  try {
    void $event.listOnProgress();
    const r = await $event.listCompleted();
    solved.value = r;
  } catch (error) {
    notificationHelper.axiosError(error);
  }
  done();
}
/**
 * onRequestComplete
 */
async function onRequestComplete() {
  if (eventDetails.value) {
    try {
      await $event.update(eventDetails.value.id, {
        status: 'completed',
      });
    } catch (error) {
      notificationHelper.axiosError(error, 'No se pudo guardar');
    }
  }
  dialogDetails.value = false;
  eventDetails.value = undefined;
  void onPullToRefresh(() => {
    console.log('Evento actualizado');
  });
}

/**
 * showDetails
 * @param e
 */
function showDetails(e: IEvent) {
  eventDetails.value = e;
  dialogDetails.value = true;
}
/**
 * -----------------------------------------
 *	Lifecycle
 * -----------------------------------------
 */
onBeforeMount(() => {
  onPullToRefresh(() => {
    console.log('Events Page');
  });
});
</script>
