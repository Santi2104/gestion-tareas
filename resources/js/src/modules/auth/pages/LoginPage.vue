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
                            class="text-primary text-weight-medium"
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
                        </div>

                        <q-btn
                            unelevated
                            type="submit"
                            color="primary"
                            label="Iniciar Sesión"
                            :loading="authStore.loading"
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
import { useRouter, useRoute } from "vue-router";
import { useQuasar } from "quasar";
import { useAuthStore } from "../stores/useAuthStore";
import { getSafeRedirectUrl } from "../utils/redirectSanitizer";

const $q = useQuasar();
const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();

const form = ref({
    email: "",
    password: "",
    remember: false,
});

const showPassword = ref(false);

const handleLogin = async () => {
    try {
        await authStore.login(form.value);
        $q.notify({
            type: "positive",
            message: "¡Sesión iniciada correctamente!",
            position: "top-right",
            timeout: 3000,
        });
        const redirectTarget = getSafeRedirectUrl(route.query.redirect);
        await router.push(redirectTarget);
    } catch (error: any) {
        const serverMessage = error.response?.data?.message;
        const message =
            error.response?.status === 422
                ? "Credenciales incorrectas. Por favor verifica tu correo y contraseña."
                : serverMessage ||
                  "Error al iniciar sesión. Intenta nuevamente.";

        $q.notify({
            type: "warning",
            message: message,
            position: "top-right",
            timeout: 4000,
        });
    }
};
</script>
