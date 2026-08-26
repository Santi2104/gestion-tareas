<template>
    <q-page class="flex flex-center">
        <div class="q-pa-md" style="max-width: 450px; width: 100%">
            <q-card class="q-pa-lg">
                <q-card-section class="text-center">
                    <div class="text-h5 text-weight-bold">Crear Cuenta</div>
                    <p class="text-body2 text-grey-7 q-mt-sm">
                        O
                        <router-link
                            :to="{ name: 'login' }"
                            class="text-primary"
                        >
                            inicia sesión si ya tienes una cuenta
                        </router-link>
                    </p>
                </q-card-section>

                <q-card-section>
                    <q-form @submit="handleRegister" class="q-gutter-md">
                        <q-input
                            v-model="form.name"
                            type="text"
                            label="Nombre completo"
                            outlined
                            :rules="[
                                (val) => !!val || 'El nombre es requerido',
                            ]"
                            autocomplete="name"
                        >
                            <template v-slot:prepend>
                                <q-icon name="person" />
                            </template>
                        </q-input>

                        <q-input
                            v-model="form.email"
                            type="email"
                            label="Correo electrónico"
                            outlined
                            :rules="[
                                (val) => !!val || 'El email es requerido',
                                (val) =>
                                    /\S+@\S+\.\S+/.test(val) ||
                                    'Email inválido',
                            ]"
                            autocomplete="email"
                        >
                            <template v-slot:prepend>
                                <q-icon name="email" />
                            </template>
                        </q-input>

                        <q-input
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            label="Contraseña"
                            outlined
                            :rules="[
                                (val) => !!val || 'La contraseña es requerida',
                                (val) =>
                                    val.length >= 8 || 'Mínimo 8 caracteres',
                            ]"
                            autocomplete="new-password"
                        >
                            <template v-slot:prepend>
                                <q-icon name="lock" />
                            </template>
                            <template v-slot:append>
                                <q-icon
                                    :name="
                                        showPassword
                                            ? 'visibility'
                                            : 'visibility_off'
                                    "
                                    class="cursor-pointer"
                                    @click="showPassword = !showPassword"
                                />
                            </template>
                        </q-input>

                        <q-input
                            v-model="form.password_confirmation"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            label="Confirmar contraseña"
                            outlined
                            :rules="[
                                (val) => !!val || 'Confirma tu contraseña',
                                (val) =>
                                    val === form.password ||
                                    'Las contraseñas no coinciden',
                            ]"
                            autocomplete="new-password"
                        >
                            <template v-slot:prepend>
                                <q-icon name="lock" />
                            </template>
                            <template v-slot:append>
                                <q-icon
                                    :name="
                                        showConfirmPassword
                                            ? 'visibility'
                                            : 'visibility_off'
                                    "
                                    class="cursor-pointer"
                                    @click="
                                        showConfirmPassword =
                                            !showConfirmPassword
                                    "
                                />
                            </template>
                        </q-input>

                        <q-checkbox
                            v-model="form.terms"
                            label="Acepto los términos y condiciones"
                            color="primary"
                            :rules="[(val: boolean) => !!val || 'Debes aceptar los términos']"
                        />

                        <q-btn
                            unelevated
                            type="submit"
                            color="primary"
                            label="Crear Cuenta"
                            :loading="loading"
                            :disable="!isFormValid"
                            class="full-width"
                            size="lg"
                            no-caps
                        />
                    </q-form>
                </q-card-section>
            </q-card>
        </div>
    </q-page>
</template>

<script lang="ts" setup>
import { ref, computed } from "vue";
import { useQuasar } from "quasar";

const $q = useQuasar();

const form = ref({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const loading = ref(false);
const showPassword = ref(false);
const showConfirmPassword = ref(false);

const isFormValid = computed(() => {
    return (
        form.value.name &&
        form.value.email &&
        /\S+@\S+\.\S+/.test(form.value.email) &&
        form.value.password &&
        form.value.password.length >= 8 &&
        form.value.password_confirmation &&
        form.value.password === form.value.password_confirmation &&
        form.value.terms
    );
});

const handleRegister = async () => {
    if (!isFormValid.value) return;

    loading.value = true;

    // TODO: Implementar lógica de registro
    console.log("Register attempt:", form.value);

    // Simulamos una llamada async
    setTimeout(() => {
        loading.value = false;
        $q.notify({
            type: "positive",
            message: "Funcionalidad de registro próximamente",
        });
    }, 1000);
};
</script>
