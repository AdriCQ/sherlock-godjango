<template>
    <q-page padding>
        <q-card class="no-box-shadow" v-if="assignment">
            <div class="row q-col-gutter-sm">
                <div class="col-xs-12 col-sm-6 col-lg-4">
                    <q-card-section class="q-gutter-y-sm">
                        <div class="text-h6">{{ assignment.name }}</div>
                        <div class="text-body1" v-if="isManager">
                            <q-btn color="primary" icon="mdi-pencil" label="Administrar" class="full-width"
                                @click="dialogForm = true" />
                        </div>
                        <div class="text-subtitle1">
                            <q-chip class="glossy" :icon="assignment.status === 0 ? 'mdi-clock' : 'mdi-check'"
                                :label="assignment.status === 0 ? 'En Progreso' : 'Completado'"
                                :color="assignment.status === 0 ? '' : 'positive'" />
                        </div>
                    </q-card-section>
                    <q-card-section>
                        <!-- Agent -->
                        <p class="text-subtitle2" v-if="assignment.agent">
                            <q-icon name="mdi-account" class="q-mr-sm" />
                            {{ assignment.agent?.nick }}
                        </p>
                        <!-- / Agent -->

                        <!-- description -->
                        <p class="text-subtitle2">
                            Descripción: {{ assignment.description }}
                        </p>
                        <!-- / description -->

                        <!-- observations -->
                        <p v-if="assignment.observations">
                            Observaciones: {{ assignment.observations }}
                        </p>
                        <!-- / observations -->
                    </q-card-section>
                    <q-card-section>
                        <div class="text-body1 text-center">Checkpoints</div>
                        <q-list bordered class="q-mt-sm">
                            <q-item clickable @click="displayCheckpoint = undefined">
                                <q-item-section avatar>
                                    <q-icon name="mdi-map-marker" />
                                </q-item-section>
                                <q-item-section>Todos</q-item-section>
                            </q-item>

                            <q-item clickable v-if="!isManager" @click="myPosition">
                                <q-item-section avatar>
                                    <q-icon name="mdi-map-marker" />
                                </q-item-section>
                                <q-item-section>Mi Posición</q-item-section>
                            </q-item>

                            <q-item v-for="(cp, cpIndex) in assignment.checkpoints"
                                :key="`checkpoint-${cp.id}-index-${cpIndex}`">
                                <q-item-section class="cursor-pointer" avatar @click="goToCheckpoint(cp.id)"
                                    v-if="isMobile">
                                    <q-icon name="mdi-eye" />
                                </q-item-section>
                                <q-item-section class="cursor-pointer" avatar @click="displayCheckpoint = cp" v-else>
                                    <q-icon name="mdi-map-marker" />
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label>
                                        {{ cp.name }}
                                    </q-item-label>
                                    <q-item-label caption lines="2">
                                        <q-chip class="glossy" size="sm" icon="mdi-clock" label="Pendiente"
                                            v-if="cp.status === 0" />
                                        <q-chip class="glossy" size="sm" icon="mdi-check" label="Completado" v-else />
                                    </q-item-label>
                                </q-item-section>

                                <q-item-section avatar class="cursor-pointer" v-if="isManager"
                                    @click="removeCheckpoint(cp)">
                                    <q-icon name="mdi-delete" color="negative" />
                                </q-item-section>
                            </q-item>

                            <!-- Add Checkpoint -->
                            <q-item v-if="isManager" clickable @click="dialogCheckpoint = true">
                                <q-item-section top avatar>
                                    <q-avatar color="positive" text-color="white" icon="mdi-plus" size="sm" />
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label>Nuevo Checkpoint</q-item-label>
                                </q-item-section>
                            </q-item>
                            <!-- / Add Checkpoint -->
                        </q-list>
                    </q-card-section>
                </div>

                <!-- Map Column -->
                <div class="col-sm-6 col-lg-8" v-if="!isMobile">
                    <map-widget readonly :markers="checkpointMarkers" :center="checkpointMarkers[0]" :zoom="mapZoom"
                        @update-zoom="(z) => (mapZoom = z)" />
                </div>
                <!-- / Map Column -->
            </div>
        </q-card>

        <!-- Form Dialog -->
        <q-dialog v-model="dialogForm">
            <assignment-form style="min-width: 20rem" :assignment="assignment" @cancel="closeDialogs"
                @complete="closeDialogs" />
        </q-dialog>
        <!-- / Form Dialog -->

        <!-- Checkpoint Dialog -->
        <q-dialog v-model="dialogCheckpoint">
            <checkpoint-form style="min-width: 20rem" v-if="assignment" :assignment="assignment" @cancel="closeDialogs"
                @complete="closeDialogs" />
        </q-dialog>
        <!-- / Checkpoint Dialog -->

        <!-- Currento Position Dialog -->
        <q-dialog v-model="dialogCurrentPos" v-if="currentGpsPosition">
            <q-card style="min-width: 20rem;">
                <map-widget :markers="[currentGpsPosition]" readonly />
            </q-card>
        </q-dialog>
        <!-- / Currento Position Dialog -->
    </q-page>
</template>

<script setup lang="ts">
import {
    injectStrict,
    _agentInjectable,
    _assignmentInjectable,
    _map,
} from 'src/injectables';
import { computed, onBeforeMount, ref } from 'vue';
import { useRoute } from 'vue-router';
import MapWidget from 'src/components/widgets/MapWidget.vue';
import AssignmentForm from 'src/components/forms/AssignmentForm.vue';
import CheckpointForm from 'src/components/forms/CheckpointForm.vue';
import { latLng, LatLng } from 'leaflet';
import { IAssignmentCheckpoint } from 'src/types';
import { ROUTE_NAME } from 'src/router';
import { Platform } from 'quasar';
import { notificationHelper, useGuiHelper } from 'src/helpers';
import { $router } from 'src/boot/router';
/**
 * -----------------------------------------
 *	Injectable
 * -----------------------------------------
 */
const $map = injectStrict(_map);
const $assignment = injectStrict(_assignmentInjectable);
const $agent = injectStrict(_agentInjectable);
const $gui = useGuiHelper();
const $route = useRoute();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const assignmentId = ref(0);
const assignment = computed(() => {
    if (isManager.value) return $assignment.getById(assignmentId.value);
    const index = $agent.assignments.findIndex(
        (as) => as.id === assignmentId.value
    );
    return $agent.assignments[index];
});
const currentGpsPosition = computed(() => $map.gpsPosition);
const displayCheckpoint = ref<IAssignmentCheckpoint>();
const checkpointMarkers = computed<LatLng[]>(() => {
    const markers: LatLng[] = [];
    if (displayCheckpoint.value) {
        return [
            latLng(
                displayCheckpoint.value.position.lat,
                displayCheckpoint.value.position.lng
            ),
        ];
    }
    assignment.value?.checkpoints?.forEach((cp) => {
        markers.push(latLng(cp.position.lat, cp.position.lng));
    });
    return markers;
});
const dialogCheckpoint = ref(false);
const dialogCurrentPos = ref(false);
const dialogForm = ref(false);
const isManager = computed(() => $route.name === ROUTE_NAME.ADMIN_ASSIGNMENT);
const isMobile = computed(() => Platform.is.mobile);
const mapZoom = ref(15);
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * Close Dialogs
 */
function closeDialogs() {
    dialogCheckpoint.value = false;
    dialogForm.value = false;
}
/**
 * Go To Checkpoint
 * @param id
 */
function goToCheckpoint(id: number) {
    if (!isManager.value) {
        $router.push({
            name: ROUTE_NAME.AGENT_CHECKPOINT,
            params: { id },
        });
    }
}
/**
 * myPosition
 */
async function myPosition() {
    if (!currentGpsPosition.value) {
        await $map.getGpsPosition();
        if ($agent.agent && currentGpsPosition.value)
            $agent.agent.position = currentGpsPosition.value;
    }
    dialogCurrentPos.value = true;
}
/**
 * Remove Checkpoint
 */
function removeCheckpoint(cp: IAssignmentCheckpoint) {
    $gui.deleteDialog({
        message: 'Desea eliminar el checkpoint?',
        onOk: async () => {
            notificationHelper.loading();
            try {
                await $assignment.removeCheckpoint(cp.assignment_id, cp.id);
            } catch (error) {
                notificationHelper.axiosError(error, 'No se pudo eliminar');
            }
            notificationHelper.loading(false);
        },
        title: 'Eliminar Checkpoint',
    });
}
/**
 * -----------------------------------------
 *	Lifecycle
 * -----------------------------------------
 */
onBeforeMount(() => {
    if ($route.params && $route.params.id) {
        assignmentId.value = Number($route.params.id);
    }
});
</script>
