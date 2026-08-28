<template>
    <q-layout view="hHh lpR fFf">
        <q-header elevated class="bg-primary text-white">
            <q-toolbar>
                <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

                <q-toolbar-title class="row items-center">
                    <q-icon
                        name="check_circle_outline"
                        size="md"
                        class="q-mr-sm"
                    />
                    <span class="text-weight-bold">Gestión de Tareas</span>
                </q-toolbar-title>

                <q-space />

                <div v-if="authStore.user" class="row items-center q-gutter-sm">
                    <span class="text-subtitle2 q-mr-xs hide-on-xs">
                        {{ authStore.user.name }}
                    </span>

                    <q-btn
                        flat
                        round
                        dense
                        icon="logout"
                        title="Cerrar Sesión"
                        @click="handleLogout"
                    >
                        <q-tooltip>Cerrar Sesión</q-tooltip>
                    </q-btn>
                </div>
            </q-toolbar>
        </q-header>

        <q-drawer v-model="leftDrawerOpen" side="left" bordered>
            <q-list class="q-pt-md">
                <q-item-label header class="text-weight-bold text-uppercase">
                    Navegación
                </q-item-label>

                <q-item
                    clickable
                    v-ripple
                    to="/tasks"
                    active-class="bg-blue-1 text-primary"
                >
                    <q-item-section avatar>
                        <q-icon name="task" />
                    </q-item-section>
                    <q-item-section> Mis Tareas </q-item-section>
                </q-item>

                <q-separator class="q-my-md" />

                <q-item
                    clickable
                    v-ripple
                    class="text-negative"
                    @click="handleLogout"
                >
                    <q-item-section avatar>
                        <q-icon name="logout" color="negative" />
                    </q-item-section>
                    <q-item-section class="text-weight-medium">
                        Cerrar Sesión
                    </q-item-section>
                </q-item>
            </q-list>
        </q-drawer>

        <q-page-container>
            <router-view />
        </q-page-container>
    </q-layout>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";
import { useAuthStore } from "../modules/auth/stores/useAuthStore";

const $q = useQuasar();
const router = useRouter();
const authStore = useAuthStore();
const leftDrawerOpen = ref(false);

function toggleLeftDrawer() {
    leftDrawerOpen.value = !leftDrawerOpen.value;
}

async function handleLogout() {
    try {
        await authStore.logout();
        $q.notify({
            type: "info",
            message: "Sesión cerrada correctamente",
            position: "top-right",
            timeout: 2500,
        });
        await router.push({ name: "login" });
    } catch {
        $q.notify({
            type: "negative",
            message: "Error al cerrar sesión",
            position: "top-right",
        });
    }
}
</script>

<style scoped>
@media (max-width: 599px) {
    .hide-on-xs {
        display: none;
    }
}
</style>
