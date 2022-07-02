<template>
  <q-page padding>
    <q-card class="no-box-shadow" style="max-width: 25rem">
      <q-card-section>
        <div class="text-h6">Perfil de Agente</div>
      </q-card-section>
      <q-card-section class="q-gutter-y-sm">
        <q-input
          v-model="form.name"
          type="text"
          label="Nombre"
          @change="onUserChange('name')"
        />
        <q-input
          v-model="form.nick"
          type="text"
          label="Nick"
          @change="onAgentChange"
        />
        <q-input
          v-model="form.email"
          type="email"
          label="Email"
          @change="onUserChange('email')"
        />
        <q-input
          v-model="form.phone"
          type="tel"
          label="Telefono"
          @change="onUserChange('phone')"
        />
        <q-input
          v-model="form.address"
          type="text"
          label="Direccion"
          @change="onAgentChange"
        />
        <q-input
          v-model="form.password"
          type="password"
          label="Contraseña"
          @change="onUserChange('password')"
        />
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import { useQuasar } from 'quasar';
import { notificationHelper } from 'src/helpers';
import { injectStrict, _agentInjectable, _user } from 'src/injectables';
import { computed, onBeforeMount, ref } from 'vue';

/**
 * -----------------------------------------
 *	Inject
 * -----------------------------------------
 */
const $agent = injectStrict(_agentInjectable);
const $q = useQuasar();
const $user = injectStrict(_user);

/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const agent = computed(() => $agent.agent);

const form = ref({
  email: '',
  name: '',
  address: '',
  nick: '',
  phone: '',
  password: '',
});

const profile = computed(() => $user.profile);
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * onAgentChange
 */
async function onAgentChange() {
  try {
    if (agent.value) {
      await $agent.update(agent.value.id, {
        nick: form.value.nick,
        address: form.value.address,
      });
      $agent.save();
      notificationHelper.success(['Perfil Actualizado']);
    }
  } catch (error) {
    notificationHelper.axiosError(error);
  }
}
/**
 * onUserChange
 * @param type
 */
async function onUserChange(type: 'email' | 'name' | 'phone' | 'password') {
  try {
    switch (type) {
      case 'email':
        $user.profile = await $user.updateEmail(
          profile.value.id,
          form.value.email
        );
        break;

      case 'name':
        $user.profile = await $user.update(profile.value.id, {
          name: form.value.name,
        });
        break;

      case 'phone':
        $user.profile = await $user.update(profile.value.id, {
          phone: form.value.phone,
        });
        break;

      case 'password':
        $q.dialog({
          title: 'Cambiar Password',
          message: '¿Desea modificar la contraseña?',
          ok: 'si',
          cancel: 'no',
        }).onOk(async () => {
          $user.profile = await $user.update(profile.value.id, {
            password: form.value.password,
            password_confirmation: form.value.password,
          });
          $user.save();
          $user.logout();
        });
        break;

      default:
        break;
    }
    $user.save();
    notificationHelper.success(['Perfil Actualizado']);
  } catch (error) {
    notificationHelper.axiosError(error);
  }
}
/**
 * onBeforeMount
 */
onBeforeMount(() => {
  if (agent.value) {
    form.value = {
      email: profile.value.email,
      name: profile.value.name,
      phone: profile.value.phone,
      nick: agent.value.nick,
      password: '',
      address: agent.value.address,
    };
  }
});
</script>
