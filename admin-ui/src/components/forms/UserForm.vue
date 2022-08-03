<template>
  <q-card>
    <q-form @submit.prevent="onSubmit">
      <q-card-section class="q-gutter-y-md">
        <q-input
          v-model="form.name"
          type="text"
          label="Nombre"
          name="name"
          :error="$v.name.$error"
          bottom-slots
        >
          <template v-slot:error>
            <div v-for="e of $v.name.$errors" :key="e.$uid">
              {{ e.$message }}
            </div>
          </template>
        </q-input>

        <q-input
          name="email"
          v-model="form.email"
          type="email"
          label="Email"
          :error="$v.email.$error"
          bottom-slots
          :readonly="isUpdate"
        >
          <template v-slot:error>
            <div v-for="e of $v.email.$errors" :key="e.$uid">
              {{ e.$message }}
            </div>
          </template>
        </q-input>

        <q-input
          name="phone"
          v-model="form.phone"
          type="tel"
          label="Teléfono"
          bottom-slots
          :error="$v.phone.$error"
        >
          <template v-slot:error>
            <div v-for="e of $v.phone.$errors" :key="e.$uid">
              {{ e.$message }}
            </div>
          </template>
        </q-input>

        <q-select
          v-model="form.role_id"
          :options="roles"
          emit-value
          map-options
          option-label="display_name"
          option-value="id"
          label="Permisos"
        />

        <q-input
          name="password"
          v-model="form.password"
          type="password"
          label="Contraseña"
          :required="!isUpdate"
        />

        <q-input
          name="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          label="Repita Contraseña"
          :required="!isUpdate"
        />
      </q-card-section>
      <q-card-actions>
        <q-btn
          color="primary"
          outline
          label="Cerrar"
          icon="mdi-close"
          @click="$emit('cancel')"
        />
        <q-btn color="primary" icon="mdi-check" label="Guardar" type="submit" />
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script setup lang="ts">
import { ref, computed, onBeforeMount } from 'vue';
import { injectStrict, _user } from 'src/injectables';
import { notificationHelper } from 'src/helpers';
import useVuelidate from '@vuelidate/core';
import { email, helpers, required } from '@vuelidate/validators';
import { IUserCreateRequest, IUserProfile } from 'src/types';
/**
 * -----------------------------------------
 *	Setup
 * -----------------------------------------
 */
const $emit = defineEmits<{
  (e: 'form-complete', p?: IUserProfile): void;
  (e: 'cancel'): void;
}>();
const $props = defineProps<{ user?: IUserProfile }>();
const $user = injectStrict(_user);
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const form = ref<IUserCreateRequest>({
  email: '',
  name: '',
  phone: '',
  password: '',
  password_confirmation: '',
  role_id: 2,
});
const isUpdate = computed(() => ($props.user ? true : false));
const roles = computed(() => $user.roles.filter((r) => r.name !== 'admin'));
/**
 * validator
 */
const $v = useVuelidate(
  {
    email: {
      required: helpers.withMessage('El email es necesario', required),
      email: helpers.withMessage('El email no es válido', email),
    },
    phone: {
      required: helpers.withMessage('El telefono es necesario', required),
    },
    name: {
      required: helpers.withMessage('Necesitamos su nombre', required),
    },
    // password: {
    //   required: helpers.withMessage('La contraseña es necesaria', required),
    // },
    // password_confirmation: {
    //   // required: helpers.withMessage('La contraseña es necesaria', required),
    //   sameAsPassword: helpers.withMessage(
    //     'La contraseña no coincide',
    //     sameAs(computed(() => form.value.password))
    //   ),
    // },
  },
  form
);
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * onSubmit
 */
async function onSubmit() {
  if (await $v.value.$validate()) {
    try {
      if ($props.user) {
        await $user.update($props.user?.id, form.value);
      } else {
        await $user.create(form.value);
      }
      $emit('form-complete');
      notificationHelper.success(['Usuario Guardado']);
    } catch (error) {
      notificationHelper.axiosError(error, 'No se pudo guardar el usuario');
    }
  }
}

onBeforeMount(async () => {
  if (!roles.value.length) {
    await $user.listRoles();
  }
  if ($props.user) {
    form.value = {
      email: $props.user.email,
      name: $props.user.name,
      password: undefined,
      password_confirmation: undefined,
      phone: $props.user.phone,
      role_id: $props.user.role.id,
    };
  } else {
    form.value = {
      email: '',
      name: '',
      password: '',
      password_confirmation: '',
      phone: '',
      role_id: 2,
    };
  }
});
</script>
