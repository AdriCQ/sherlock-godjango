<template>
  <q-page padding>
    <q-card class="no-box-shadow">
      <q-card-section>
        <div class="text-h6 text-center">Grupos</div>
      </q-card-section>
      <q-card-section>
        <div class="row q-col-gutter-sm">
          <div
            class="col-xs-12 col-sm-6 col-md-4 col-lg-3"
            v-for="i in 10"
            :key="i"
          >
            <personal-group-widget />
          </div>
        </div>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import PersonalGroupWidget from 'src/components/widgets/PersonalGroupWidget.vue';
</script>
