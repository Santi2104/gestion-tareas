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
            v-model="title"
            @blur="handleTitleBlur"
            label="Título *"
            outlined
            dense
            :error="titleMeta.touched && !!errors.title"
            :error-message="errors.title"
          />

          <!-- Description -->
          <q-input
            v-model="description"
            @blur="handleDescriptionBlur"
            label="Descripción"
            type="textarea"
            outlined
            dense
            rows="3"
            :error="descriptionMeta.touched && !!errors.description"
            :error-message="errors.description"
          />

          <!-- Priority -->
          <q-select
            v-model="priority_id"
            @blur="handlePriorityBlur"
            :options="priorityOptions"
            label="Prioridad *"
            outlined
            dense
            emit-value
            map-options
            :loading="isPrioritiesLoading"
            :error="priorityMeta.touched && !!errors.priority_id"
            :error-message="errors.priority_id"
          />

          <!-- Status -->
          <q-select
            v-model="status"
            :options="statusOptions"
            label="Estado"
            outlined
            dense
            emit-value
            map-options
            :error="!!errors.status"
            :error-message="errors.status"
          />

          <!-- Due Date -->
          <q-input
            v-model="due_date"
            @blur="handleDueDateBlur"
            label="Fecha de Vencimiento"
            type="date"
            outlined
            dense
            stack-label
            :error="dueDateMeta.touched && !!errors.due_date"
            :error-message="errors.due_date"
          />

          <!-- Tags (Multiple) -->
          <q-select
            v-model="tag_ids"
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
import { computed, watch } from 'vue';
import { useForm, useField } from 'vee-validate';
import * as yup from 'yup';
import { useTaskStore } from '../stores/useTaskStore';
import { usePrioritiesQuery } from '../composables/usePrioritiesQuery';
import { useTagsQuery } from '../composables/useTagsQuery';
import { useTaskMutations } from '../composables/useTaskMutations';
import type { CreateTaskPayload, TaskStatus, UpdateTaskPayload } from '../../../types/task';
import { formatPriorityLabel, STATUS_OPTIONS } from '../utils/taskFormatters';
import { extractBackendErrors } from '../../../utils/backendErrorMapper';

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

const schema = yup.object({
  title: yup.string().required('El título es obligatorio').max(255, 'Máximo 255 caracteres'),
  description: yup.string().nullable(),
  priority_id: yup.number().required('La prioridad es obligatoria').nullable(),
  status: yup.string().required('El estado es obligatorio'),
  due_date: yup.string().nullable(),
  tag_ids: yup.array().of(yup.number()),
});

const { handleSubmit, errors, setErrors, resetForm } = useForm({
  validationSchema: schema,
  initialValues: {
    title: '',
    description: '',
    priority_id: null as number | null,
    status: 'pending' as TaskStatus,
    due_date: '',
    tag_ids: [] as number[],
  },
});

const { value: title, handleBlur: handleTitleBlur, meta: titleMeta } = useField<string>('title');
const { value: description, handleBlur: handleDescriptionBlur, meta: descriptionMeta } = useField<string>('description');
const { value: priority_id, handleBlur: handlePriorityBlur, meta: priorityMeta } = useField<number | null>('priority_id');
const { value: status } = useField<TaskStatus>('status');
const { value: due_date, handleBlur: handleDueDateBlur, meta: dueDateMeta } = useField<string>('due_date');
const { value: tag_ids } = useField<number[]>('tag_ids');

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
      resetForm({
        values: {
          title: task.title,
          description: task.description || '',
          priority_id: task.priority_id,
          status: task.status,
          due_date: task.due_date || '',
          tag_ids: task.tags ? task.tags.map((t) => t.id) : [],
        },
      });
    } else {
      resetForm({
        values: {
          title: '',
          description: '',
          priority_id: priorities.value && priorities.value.length > 0 ? priorities.value[0].id : null,
          status: 'pending',
          due_date: '',
          tag_ids: [],
        },
      });
    }
  },
  { immediate: true }
);

const onSubmit = handleSubmit(async (values) => {
  const payload: CreateTaskPayload | UpdateTaskPayload = {
    title: values.title,
    description: values.description || null,
    priority_id: values.priority_id!,
    status: values.status as TaskStatus,
    due_date: values.due_date || null,
    tag_ids: values.tag_ids || [],
  };

  try {
    if (isEditMode.value && taskStore.selectedTask) {
      await updateMutation.mutateAsync({ id: taskStore.selectedTask.id, payload });
    } else {
      await createMutation.mutateAsync(payload);
    }
  } catch (error: any) {
    const backendErrors = extractBackendErrors(error);
    if (Object.keys(backendErrors).length > 0) {
      setErrors(backendErrors);
    }
  }
});
</script>
