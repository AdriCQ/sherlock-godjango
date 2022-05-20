<template>
  <q-card class="login-card">
    <q-card-section class="text-center text-grey-9">
      <div class="text-body1">Bienvenido a Sherlock</div>
    </q-card-section>
    <q-form @submit.prevent="login">
      <q-card-section class="q-gutter-y-md">
        <q-input
          name="email"
          v-model="loginForm.email"
          type="email"
          label="Email"
          :error="$v.email.$error"
          bottom-slots
        >
          <template v-slot:error>
            <div v-for="e of $v.email.$errors" :key="e.$uid">
              {{ e.$message }}
            </div>
          </template>
        </q-input>
        <q-input
          name="password"
          v-model="loginForm.password"
          type="password"
          label="Contraseña"
          :error="$v.password.$error"
          bottom-slots
        >
          <template v-slot:error>
            <div v-for="e of $v.password.$errors" :key="e.$uid">
              {{ e.$message }}
            </div>
          </template>
        </q-input>
      </q-card-section>
      <!-- <q-card-section
        class="text-primary cursor-pointer"
        @click="$emit('toggle')"
      >
        No tengo cuenta
      </q-card-section> -->
      <q-card-actions>
        <q-btn
          class="full-width"
          color="primary"
          label="Iniciar"
          type="submit"
        />
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { notificationHelper } from 'src/helpers';
import { injectStrict, _user } from 'src/injectables';
import useVuelidate from '@vuelidate/core';
import { required, email, helpers } from '@vuelidate/validators';
import { IAuthRequest } from 'src/types';
/**
 * -----------------------------------------
 *	Init
 * -----------------------------------------
 */
const $emit = defineEmits<{ (e: 'toggle'): void; (e: 'auth'): void }>();
const $user = injectStrict(_user);
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const loginForm = ref<IAuthRequest>({
  email: '',
  password: '',
});
/**
 * -----------------------------------------
 *	methods
 * -----------------------------------------
 */
// validator
const $v = useVuelidate(
  {
    email: {
      required: helpers.withMessage('El email es necesario', required),
      email: helpers.withMessage('El email no es válido', email),
    },
    password: {
      required: helpers.withMessage('La contraseña es necesaria', required),
    },
  },
  loginForm
);

/**
 * login
 */
async function login() {
  // Validate
  if (await $v.value.$validate()) {
    notificationHelper.loading();
    try {
      await $user.login(loginForm.value);
      notificationHelper.success([`Bienvenido ${$user.profile?.name}`]);
      $emit('auth');
    } catch (error) {
      notificationHelper.axiosError(error, 'Credenciales incorrectas');
    }
    notificationHelper.loading(false);
  }
}
</script>

<style scoped>
.login-card {
  max-width: 25rem;
  min-width: 20rem;
}
</style>
