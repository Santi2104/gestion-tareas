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
            </q-list>
        </q-drawer>

        <q-page-container>
            <router-view />
        </q-page-container>
    </q-layout>
</template>

<script setup lang="ts">
import { ref } from "vue";

const leftDrawerOpen = ref(false);

function toggleLeftDrawer() {
    leftDrawerOpen.value = !leftDrawerOpen.value;
}
</script>
