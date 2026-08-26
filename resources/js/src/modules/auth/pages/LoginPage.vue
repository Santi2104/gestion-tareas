<template>
    <q-page class="flex flex-center">
        <div class="q-pa-md" style="max-width: 400px; width: 100%">
            <q-card class="q-pa-lg">
                <q-card-section class="text-center">
                    <div class="text-h5 text-weight-bold">Iniciar Sesión</div>
                    <p class="text-body2 text-grey-7 q-mt-sm">
                        O
                        <router-link
                            :to="{ name: 'register' }"
                            class="text-primary"
                        >
                            regístrate si no tienes una cuenta
                        </router-link>
                    </p>
                </q-card-section>

                <q-card-section>
                    <q-form @submit="handleLogin" class="q-gutter-md">
                        <q-input
                            v-model="form.email"
                            type="email"
                            label="Correo electrónico"
                            outlined
                            :rules="[(val) => !!val || 'El email es requerido']"
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
                            ]"
                            autocomplete="current-password"
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

                        <div class="row items-center justify-between">
                            <q-checkbox
                                v-model="form.remember"
                                label="Recordarme"
                                color="primary"
                            />
                            <q-btn
                                flat
                                no-caps
                                label="¿Olvidaste tu contraseña?"
                                color="primary"
                                size="sm"
                                @click="$q.notify('Funcionalidad próximamente')"
                            />
                        </div>

                        <q-btn
                            unelevated
                            type="submit"
                            color="primary"
                            label="Iniciar Sesión"
                            :loading="loading"
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
import { ref } from "vue";
import { useQuasar } from "quasar";

const $q = useQuasar();

const form = ref({
    email: "",
    password: "",
    remember: false,
});

const loading = ref(false);
const showPassword = ref(false);

const handleLogin = async () => {
    loading.value = true;

    // TODO: Implementar lógica de login
    console.log("Login attempt:", form.value);

    // Simulamos una llamada async
    setTimeout(() => {
        loading.value = false;
        $q.notify({
            type: "positive",
            message: "Funcionalidad de login próximamente",
        });
    }, 1000);
};
</script>
