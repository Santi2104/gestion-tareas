<script lang="ts" setup>
import { computed } from "vue";

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
                        Laravel Vue
                    </router-link>
                </q-toolbar-title>

                <q-space />

                <div class="q-gutter-sm">
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
                        © {{ currentYear }} Plantilla Laravel Vue
                    </div>
                    <div class="text-caption text-grey-5">
                        Plantilla base para proyectos web
                    </div>
                </div>
            </q-toolbar>
        </q-footer>
    </q-layout>
</template>
