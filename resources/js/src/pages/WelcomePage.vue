<template>
    <q-page class="flex column">
        <!-- Hero Section -->
        <div class="q-pa-xl text-center bg-grey-1">
            <div class="q-mb-lg">
                <h1 class="text-h2 text-weight-bold q-mb-md">
                    Bienvenido a
                    <span class="text-primary">Laravel Vue</span>
                </h1>
                <p
                    class="text-h6 text-grey-7 q-mb-xl"
                    style="max-width: 600px; margin: 0 auto"
                >
                    Una plantilla base que combina Laravel como backend y Vue.js
                    como frontend
                </p>
            </div>
        </div>
        <!-- Additional Features -->
        <div class="bg-grey-1 q-pa-sm">
            <div class="text-center q-mb-xl">
                <h2 class="text-h4 text-weight-bold q-mb-md">
                    Tecnologías Incluidas
                </h2>
                <p class="text-body1 text-grey-7">
                    Un stack completo y moderno para el desarrollo web
                </p>
            </div>

            <div class="row q-col-gutter-md justify-center">
                <div
                    class="col-auto"
                    v-for="tech in technologies"
                    :key="tech.name"
                >
                    <q-chip
                        :color="tech.color"
                        text-color="white"
                        :icon="tech.icon"
                        size="lg"
                    >
                        {{ tech.name }}
                    </q-chip>
                </div>
            </div>
        </div>
    </q-page>
</template>

<script lang="ts" setup>
const technologies = [
    { name: "Laravel", icon: "code", color: "red" },
    { name: "Vue.js 3", icon: "javascript", color: "green" },
    { name: "TypeScript", icon: "terminal", color: "blue" },
    { name: "Quasar", icon: "widgets", color: "cyan" },
    { name: "Vite", icon: "flash_on", color: "orange" },
    { name: "Fortify", icon: "security", color: "purple" },
];
</script>
