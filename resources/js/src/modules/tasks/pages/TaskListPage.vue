<template>
    <q-page class="q-pa-md max-width-container">
        <!-- Filter Bar Component -->
        <TaskFilterBar />

        <!-- Loading State -->
        <div v-if="isLoading" class="row justify-center items-center q-py-xl">
            <q-spinner color="primary" size="3em" />
        </div>

        <!-- Error State -->
        <div v-else-if="isError" class="row justify-center q-py-lg">
            <q-banner rounded class="bg-negative text-white">
                Ocurrió un error al cargar las tareas. Por favor, reintenta.
                <template v-slot:action>
                    <q-btn
                        flat
                        color="white"
                        label="Reintentar"
                        @click="refetchTasks"
                    />
                </template>
            </q-banner>
        </div>

        <!-- Empty State -->
        <div
            v-else-if="!tasks || tasks.length === 0"
            class="column items-center justify-center q-py-xl text-grey-6"
        >
            <q-icon name="assignment_turned_in" size="4em" class="q-mb-md" />
            <div class="text-h6">No hay tareas encontradas</div>
            <div class="text-caption q-mb-md">
                Crea una nueva tarea o ajusta los filtros seleccionados
            </div>
            <q-btn
                color="primary"
                outline
                icon="add"
                label="Crear Tarea"
                @click="taskStore.openCreateDialog"
            />
        </div>

        <!-- Task Cards Grid -->
        <div v-else class="row q-col-gutter-md">
            <div
                v-for="task in tasks"
                :key="task.id"
                class="col-12 col-sm-6 col-md-4"
            >
                <TaskCard
                    :task="task"
                    @edit="taskStore.openEditDialog"
                    @delete="onDeleteTask"
                    @status-change="onStatusChange"
                />
            </div>
        </div>

        <!-- Form Dialog Component -->
        <TaskFormDialog />
    </q-page>
</template>

<script setup lang="ts">
import { useQuasar } from "quasar";
import { useTaskStore } from "../stores/useTaskStore";
import { useTasksQuery } from "../composables/useTasksQuery";
import { useTaskMutations } from "../composables/useTaskMutations";
import type { TaskStatus } from "../../../types/task";
import TaskFilterBar from "../components/TaskFilterBar.vue";
import TaskCard from "../components/TaskCard.vue";
import TaskFormDialog from "../components/TaskFormDialog.vue";

const $q = useQuasar();
const taskStore = useTaskStore();
const { data: tasks, isLoading, isError, refetch } = useTasksQuery();
const { deleteMutation, updateStatusMutation } = useTaskMutations();

function refetchTasks() {
    void refetch();
}

function onDeleteTask(id: number) {
    $q.dialog({
        title: "Confirmar Eliminación",
        message: "¿Estás seguro de que deseas eliminar esta tarea?",
        cancel: true,
        persistent: true,
    }).onOk(() => {
        deleteMutation.mutate(id);
    });
}

function onStatusChange(payload: { id: number; status: TaskStatus }) {
    updateStatusMutation.mutate(payload);
}
</script>

<style scoped>
.max-width-container {
    max-width: 1200px;
    margin: 0 auto;
}
</style>
