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
                            class="text-primary text-weight-medium"
                        >
                            inicia sesión si ya tienes una cuenta
                        </router-link>
                    </p>
                </q-card-section>

                <q-card-section>
                    <q-form
                        @submit.prevent="handleRegister"
                        class="q-gutter-md"
                    >
                        <q-input
                            v-model="name"
                            @blur="handleNameBlur"
                            type="text"
                            label="Nombre completo"
                            outlined
                            :error="nameMeta.touched && !!errors.name"
                            :error-message="errors.name"
                            autocomplete="name"
                        >
                            <template v-slot:prepend>
                                <q-icon name="person" />
                            </template>
                        </q-input>

                        <q-input
                            v-model="email"
                            @blur="handleEmailBlur"
                            type="email"
                            label="Correo electrónico"
                            outlined
                            :error="emailMeta.touched && !!errors.email"
                            :error-message="errors.email"
                            autocomplete="email"
                        >
                            <template v-slot:prepend>
                                <q-icon name="email" />
                            </template>
                        </q-input>

                        <q-input
                            v-model="password"
                            @blur="handlePasswordBlur"
                            :type="showPassword ? 'text' : 'password'"
                            label="Contraseña"
                            outlined
                            :error="passwordMeta.touched && !!errors.password"
                            :error-message="errors.password"
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
                            v-model="password_confirmation"
                            @blur="handleConfirmBlur"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            label="Confirmar contraseña"
                            outlined
                            :error="
                                confirmMeta.touched &&
                                !!errors.password_confirmation
                            "
                            :error-message="errors.password_confirmation"
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

                        <q-btn
                            unelevated
                            type="submit"
                            color="primary"
                            label="Crear Cuenta"
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
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
import { useForm, useField } from "vee-validate";
import * as yup from "yup";
import { useAuthStore } from "../stores/useAuthStore";
import { extractBackendErrors } from "../../../utils/backendErrorMapper";

const $q = useQuasar();
const router = useRouter();
const authStore = useAuthStore();

const schema = yup.object({
    name: yup.string().required("El nombre es requerido"),
    email: yup
        .string()
        .required("El correo electrónico es requerido")
        .email("Formato de correo electrónico inválido"),
    password: yup
        .string()
        .required("La contraseña es requerida")
        .min(8, "La contraseña debe tener al menos 8 caracteres"),
    password_confirmation: yup
        .string()
        .required("Confirma tu contraseña")
        .oneOf([yup.ref("password")], "Las contraseñas no coinciden"),
});

const { handleSubmit, errors, setErrors } = useForm({
    validationSchema: schema,
    initialValues: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    },
});

const {
    value: name,
    handleBlur: handleNameBlur,
    meta: nameMeta,
} = useField<string>("name");
const {
    value: email,
    handleBlur: handleEmailBlur,
    meta: emailMeta,
} = useField<string>("email");
const {
    value: password,
    handleBlur: handlePasswordBlur,
    meta: passwordMeta,
} = useField<string>("password");
const {
    value: password_confirmation,
    handleBlur: handleConfirmBlur,
    meta: confirmMeta,
} = useField<string>("password_confirmation");

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const handleRegister = handleSubmit(async (values) => {
    try {
        await authStore.register(values);
        $q.notify({
            type: "positive",
            message: "¡Cuenta registrada exitosamente!",
            position: "top-right",
            timeout: 3000,
        });
        await router.push({ name: "tasks" });
    } catch (error: any) {
        const backendErrors = extractBackendErrors(error);
        if (Object.keys(backendErrors).length > 0) {
            setErrors(backendErrors);
        } else {
            const message =
                error.response?.data?.message ||
                "Error al registrar la cuenta. Verifica los datos ingresados.";
            $q.notify({
                type: "negative",
                message: message,
                position: "top-right",
                timeout: 4000,
            });
        }
    }
});
</script>
