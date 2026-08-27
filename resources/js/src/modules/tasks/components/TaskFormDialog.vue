<template>
  <q-dialog v-model="isOpen" persistent>
    <q-card style="min-width: 350px; max-width: 500px; width: 100%;">
      <q-card-section class="row items-center justify-between bg-primary text-white">
        <div class="text-h6 text-weight-bold">
          {{ isEditMode ? 'Editar Tarea' : 'Nueva Tarea' }}
        </div>
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="q-pt-md">
        <q-form @submit.prevent="onSubmit" class="q-gutter-md">
          <!-- Title -->
          <q-input
            v-model="form.title"
            label="Título *"
            outlined
            dense
            :rules="[val => !!val || 'El título es obligatorio']"
          />

          <!-- Description -->
          <q-input
            v-model="form.description"
            label="Descripción"
            type="textarea"
            outlined
            dense
            rows="3"
          />

          <!-- Priority -->
          <q-select
            v-model="form.priority_id"
            :options="priorityOptions"
            label="Prioridad *"
            outlined
            dense
            emit-value
            map-options
            :loading="isPrioritiesLoading"
            :rules="[val => !!val || 'La prioridad es obligatoria']"
          />

          <!-- Status -->
          <q-select
            v-model="form.status"
            :options="statusOptions"
            label="Estado"
            outlined
            dense
            emit-value
            map-options
          />

          <!-- Due Date -->
          <q-input
            v-model="form.due_date"
            label="Fecha de Vencimiento"
            type="date"
            outlined
            dense
            stack-label
          />

          <!-- Tags (Multiple) -->
          <q-select
            v-model="form.tag_ids"
            :options="tagOptions"
            label="Etiquetas"
            multiple
            outlined
            dense
            emit-value
            map-options
            use-chips
            :loading="isTagsLoading"
          />

          <!-- Form Actions -->
          <div class="row justify-end q-gutter-sm q-pt-sm">
            <q-btn
              label="Cancelar"
              flat
              color="grey"
              v-close-popup
              :disable="isSubmitting"
            />
            <q-btn
              :label="isEditMode ? 'Guardar Cambios' : 'Crear Tarea'"
              type="submit"
              color="primary"
              unelevated
              :loading="isSubmitting"
            />
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { useTaskStore } from '../stores/useTaskStore';
import { usePrioritiesQuery } from '../composables/usePrioritiesQuery';
import { useTagsQuery } from '../composables/useTagsQuery';
import { useTaskMutations } from '../composables/useTaskMutations';
import type { CreateTaskPayload, TaskStatus, UpdateTaskPayload } from '../../../types/task';
import { formatPriorityLabel, STATUS_OPTIONS } from '../utils/taskFormatters';

const taskStore = useTaskStore();
const { data: priorities, isLoading: isPrioritiesLoading } = usePrioritiesQuery();
const { data: tags, isLoading: isTagsLoading } = useTagsQuery();
const { createMutation, updateMutation } = useTaskMutations();

const isOpen = computed({
  get: () => taskStore.isFormDialogOpen,
  set: (val) => {
    if (!val) taskStore.closeFormDialog();
  },
});

const isEditMode = computed(() => !!taskStore.selectedTask);

const form = ref<{
  title: string;
  description: string;
  priority_id: number | null;
  status: TaskStatus;
  due_date: string;
  tag_ids: number[];
}>({
  title: '',
  description: '',
  priority_id: null,
  status: 'pending',
  due_date: '',
  tag_ids: [],
});

const priorityOptions = computed(() => {
  if (!priorities.value) return [];
  return priorities.value.map((p) => ({
    label: formatPriorityLabel(p.name),
    value: p.id,
  }));
});

const tagOptions = computed(() => {
  if (!tags.value) return [];
  return tags.value.map((t) => ({
    label: t.name,
    value: t.id,
  }));
});

const statusOptions = STATUS_OPTIONS;

const isSubmitting = computed(() => createMutation.isPending.value || updateMutation.isPending.value);

watch(
  () => taskStore.selectedTask,
  (task) => {
    if (task) {
      form.value = {
        title: task.title,
        description: task.description || '',
        priority_id: task.priority_id,
        status: task.status,
        due_date: task.due_date || '',
        tag_ids: task.tags ? task.tags.map((t) => t.id) : [],
      };
    } else {
      form.value = {
        title: '',
        description: '',
        priority_id: priorities.value && priorities.value.length > 0 ? priorities.value[0].id : null,
        status: 'pending',
        due_date: '',
        tag_ids: [],
      };
    }
  },
  { immediate: true }
);

function onSubmit() {
  if (!form.value.title || !form.value.priority_id) return;

  if (isEditMode.value && taskStore.selectedTask) {
    const payload: UpdateTaskPayload = {
      title: form.value.title,
      description: form.value.description || null,
      priority_id: form.value.priority_id,
      status: form.value.status,
      due_date: form.value.due_date || null,
      tag_ids: form.value.tag_ids,
    };
    updateMutation.mutate({ id: taskStore.selectedTask.id, payload });
  } else {
    const payload: CreateTaskPayload = {
      title: form.value.title,
      description: form.value.description || null,
      priority_id: form.value.priority_id,
      status: form.value.status,
      due_date: form.value.due_date || null,
      tag_ids: form.value.tag_ids,
    };
    createMutation.mutate(payload);
  }
}
</script>
