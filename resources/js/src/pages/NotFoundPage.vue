<template>
    <q-page class="flex flex-center text-center q-pa-md">
        <div style="max-width: 500px">
            <div class="text-h1 text-weight-bolder text-primary q-mb-sm">404</div>
            <div class="text-h5 text-weight-bold text-grey-9 q-mb-md">
                Página No Encontrada
            </div>
            <p class="text-body1 text-grey-7 q-mb-lg">
                La ruta que intentas acceder no existe, ha sido movida o ya no está disponible.
            </p>
            <div class="row justify-center q-gutter-sm">
                <q-btn
                    unelevated
                    color="primary"
                    label="Volver a Mis Tareas"
                    icon="task"
                    no-caps
                    :to="{ name: 'tasks' }"
                />
                <q-btn
                    flat
                    color="primary"
                    label="Ir al Inicio"
                    icon="home"
                    no-caps
                    :to="{ name: 'welcome' }"
                />
            </div>
        </div>
    </q-page>
</template>

<script setup lang="ts">
</script>
