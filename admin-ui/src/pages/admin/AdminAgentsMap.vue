<template>
    <q-page padding>
        <q-card class="no-box-shadow" style="height: 90vh">
            <map-widget :center="centerInit" :markers="markers" readonly :zoom="12" :settings="{
                zoom: {
                    max: 18,
                    min: 6,
                },
                multiple: false,
            }" :marker-click-fn="onMarkerClick" />
        </q-card>
    </q-page>
</template>

<script setup lang="ts">
import { latLng, LatLng } from 'leaflet';
import { Dialog } from 'quasar';
import MapWidget from 'src/components/widgets/MapWidget.vue';
import { injectStrict, _agentInjectable } from 'src/injectables';
import { computed } from 'vue';
/**
 * -----------------------------------------
 *	Injectable
 * -----------------------------------------
 */
const $agent = injectStrict(_agentInjectable);
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const markers = computed(() => {
    const ret: LatLng[] = [];
    $agent.agents.forEach((a) => {
        if (a.position) ret.push(latLng(a.position.lat, a.position.lng));
    });
    return ret;
});

const centerInit = computed(() => markers.value.length ? markers.value[0] : undefined)
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * On Marker Click
 * @param marker
 * @param key
 */
function onMarkerClick(marker: LatLng, key: number) {
    const clickedAgent = $agent.agents[key];
    if (clickedAgent) {
        Dialog.create({
            title: clickedAgent.nick,
            // message: `Estado: ${clickedAgent.bussy ? 'Ocupado' : 'Libre'}`,
        });
    }
}
</script>
