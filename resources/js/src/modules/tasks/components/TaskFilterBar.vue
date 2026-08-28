<template>
  <q-card flat bordered class="q-pa-md q-mb-md">
    <div class="row items-center justify-between q-col-gutter-md">
      <!-- Title / Header -->
      <div class="col-12 col-md-3">
        <div class="text-h6 text-weight-bold text-primary">
          Gestión de Tareas
        </div>
        <div class="text-caption text-grey-6">
          Filtra y organiza tus tareas
        </div>
      </div>

      <!-- Filters Section -->
      <div class="col-12 col-md-6 col-lg-6">
        <div class="row q-col-gutter-sm items-center">
          <!-- Status Filter -->
          <div class="col-12 col-sm-4">
            <q-select
              v-model="selectedStatus"
              :options="statusOptions"
              label="Estado"
              dense
              outlined
              emit-value
              map-options
              clearable
              options-dense
            />
          </div>

          <!-- Priority Filter -->
          <div class="col-12 col-sm-4">
            <q-select
              v-model="selectedPriority"
              :options="priorityOptions"
              label="Prioridad"
              dense
              outlined
              emit-value
              map-options
              clearable
              options-dense
              :loading="isPrioritiesLoading"
            />
          </div>

          <!-- Due Date Filter -->
          <div class="col-12 col-sm-4">
            <q-input
              v-model="selectedDueDate"
              type="date"
              label="Vencimiento"
              dense
              outlined
              clearable
            />
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="col-12 col-md-3 col-lg-3 row items-center justify-end no-wrap q-gutter-xs">
        <q-btn
          v-if="hasActiveFilters"
          flat
          dense
          color="grey-7"
          icon="filter_alt_off"
          @click="taskStore.resetFilters"
        >
          <q-tooltip>Limpiar filtros</q-tooltip>
        </q-btn>

        <q-btn
          color="primary"
          icon="add"
          label="Nueva Tarea"
          unelevated
          @click="taskStore.openCreateDialog"
        />
      </div>
    </div>
  </q-card>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useTaskStore } from '../stores/useTaskStore';
import { usePrioritiesQuery } from '../composables/usePrioritiesQuery';
import type { TaskStatus } from '../../../types/task';
import { formatPriorityLabel, STATUS_OPTIONS } from '../utils/taskFormatters';

const taskStore = useTaskStore();
const { data: priorities, isLoading: isPrioritiesLoading } = usePrioritiesQuery();

const statusOptions = STATUS_OPTIONS;

const priorityOptions = computed(() => {
  if (!priorities.value) return [];
  return priorities.value.map((p) => ({
    label: formatPriorityLabel(p.name),
    value: p.id,
  }));
});

const selectedStatus = computed({
  get: () => taskStore.filters.status,
  set: (val: TaskStatus | null) => taskStore.setStatusFilter(val),
});

const selectedPriority = computed({
  get: () => taskStore.filters.priority_id,
  set: (val: number | null) => taskStore.setPriorityFilter(val),
});

const selectedDueDate = computed({
  get: () => taskStore.filters.due_date,
  set: (val: string | null) => taskStore.setDueDateFilter(val),
});

const hasActiveFilters = computed(() => {
  return (
    taskStore.filters.status !== null ||
    taskStore.filters.due_date !== null ||
    taskStore.filters.priority_id !== null
  );
});
</script>
