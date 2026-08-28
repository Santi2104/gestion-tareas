<script lang="ts" setup>
import { computed } from "vue";
import { useAuthStore } from "../modules/auth/stores/useAuthStore";

const authStore = useAuthStore();
const currentYear = computed(() => new Date().getFullYear());
</script>

<template>
    <q-layout view="lHh Lpr lFf">
        <!-- Header -->
        <q-header elevated class="bg-white text-primary">
            <q-toolbar>
                <q-toolbar-title class="text-h6 text-weight-bold">
                    <router-link
                        :to="{ name: 'welcome' }"
                        class="text-decoration-none text-primary"
                    >
                        Gestión de Tareas
                    </router-link>
                </q-toolbar-title>

                <q-space />

                <div v-if="authStore.isAuthenticated" class="q-gutter-sm">
                    <q-btn
                        unelevated
                        no-caps
                        label="Mis Tareas"
                        :to="{ name: 'tasks' }"
                        color="primary"
                        icon="task"
                    />
                </div>
                <div v-else class="q-gutter-sm">
                    <q-btn
                        flat
                        no-caps
                        label="Iniciar Sesión"
                        :to="{ name: 'login' }"
                        class="text-primary"
                    />
                    <q-btn
                        unelevated
                        no-caps
                        label="Registrarse"
                        :to="{ name: 'register' }"
                        color="primary"
                    />
                </div>
            </q-toolbar>
        </q-header>

        <!-- Page Container -->
        <q-page-container>
            <router-view />
        </q-page-container>

        <!-- Footer -->
        <q-footer elevated class="bg-dark text-white">
            <q-toolbar class="justify-center">
                <div class="text-center">
                    <div class="text-body2">
                        © {{ currentYear }} Gestión de Tareas - Laravel + Vue
                    </div>
                </div>
            </q-toolbar>
        </q-footer>
    </q-layout>
</template>
