<template>
  <q-page padding>
    <q-card class="no-box-shadow">
      <q-card-section>
        <div class="text-h6 text-center">Grupos</div>
        <div class="text-subtitle2">
          <q-btn
            color="primary"
            class="full-width"
            icon="mdi-plus"
            label="Nuevo Grupo"
            @click="dialogCreate = true"
          />
        </div>
      </q-card-section>
      <q-card-section v-if="groups">
        <div class="row q-col-gutter-sm">
          <div
            class="col-xs-12 col-sm-6 col-md-4 col-lg-3"
            v-for="(group, gKey) in groups"
            :key="`group-${group.id}-${gKey}`"
          >
            <personal-group-widget
              :group="group"
              @click="onGroupClick(group)"
            />
          </div>
        </div>
      </q-card-section>
    </q-card>

    <!-- Dialog Form -->
    <q-dialog v-model="dialogCreate">
      <personal-group-form
        class="full-width"
        @cancel="closeDialogs"
        @complete="closeDialogs"
      />
    </q-dialog>
    <!-- / Dialog Form -->

    <!-- Dialog users -->
    <q-dialog v-model="dialogUsers">
      <personal-group-advanced-widget
        style="min-width: 20rem"
        :key="`d-key-${dialogUsersKey}`"
        :group="selectedGroup"
        v-if="selectedGroup"
        @add-user="updateDialogUsers"
        @remove-user="updateDialogUsers"
        @cancel="closeDialogs"
      />
    </q-dialog>
    <!-- / Dialog users -->
  </q-page>
</template>

<script setup lang="ts">
import PersonalGroupWidget from 'src/components/widgets/PersonalGroupWidget.vue';
import PersonalGroupAdvancedWidget from 'src/components/widgets/PersonalGroupAdvancedWidget.vue';
import PersonalGroupForm from 'src/components/forms/PersonalGroupForm.vue';
import { notificationHelper } from 'src/helpers';
import { injectStrict, _personalGroup, _user } from 'src/injectables';
import { computed, onBeforeMount, ref } from 'vue';
import { IPersonalGroup } from 'src/types';
/**
 * -----------------------------------------
 *	Injext
 * -----------------------------------------
 */
const $pGroup = injectStrict(_personalGroup);
const $user = injectStrict(_user);
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const dialogCreate = ref(false);
const dialogUsers = ref(false);
const dialogUsersKey = ref('a');
const groups = computed(() => $pGroup.allGroups.value);
const selectedGroup = ref<IPersonalGroup>();

/**
 * -----------------------------------------
 *	Methids
 * -----------------------------------------
 */
/**
 * closeDialogs
 */
function closeDialogs() {
  dialogCreate.value = false;
  dialogUsers.value = false;
  selectedGroup.value = undefined;
}
/**
 * onGroupClick
 * @param g
 */
function onGroupClick(g: IPersonalGroup) {
  closeDialogs();
  selectedGroup.value = g;
  dialogUsers.value = true;
}
/**
 * updateDialogUsers
 */
async function updateDialogUsers() {
  await $pGroup.list();
  const index = groups.value.findIndex((g) => g.id === selectedGroup.value?.id);
  selectedGroup.value = groups.value[index];
  dialogUsersKey.value = btoa(Date());
}

onBeforeMount(async () => {
  try {
    await $pGroup.list();
    await $user.list();
  } catch (error) {
    notificationHelper.axiosError(error, 'Error');
  }
});
</script>
