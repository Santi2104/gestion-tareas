<template>
  <q-card flat bordered class="column justify-between full-height bg-surface shadow-1 hoverable-card">
    <q-card-section class="q-pb-xs">
      <div class="row items-center justify-between no-wrap q-mb-sm">
        <PriorityBadge :level="task.priority?.name" />
        <q-btn-dropdown
          dense
          flat
          rounded
          :color="statusColor"
          :label="statusLabel"
          size="sm"
        >
          <q-list dense>
            <q-item
              v-for="option in statusOptions"
              :key="option.value"
              clickable
              v-close-popup
              @click="onStatusChange(option.value)"
            >
              <q-item-section>
                <q-item-label>{{ option.label }}</q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-btn-dropdown>
      </div>

      <div class="text-h6 text-weight-bold q-mb-xs title-ellipsis">
        {{ task.title }}
        <q-tooltip v-if="task.title.length > 25" anchor="top middle" self="bottom middle">
          {{ task.title }}
        </q-tooltip>
      </div>

      <p class="text-body2 text-grey-7 q-mb-sm description-clamp">
        {{ task.description || 'Sin descripción' }}
      </p>
    </q-card-section>

    <q-card-section class="q-pt-none">
      <div v-if="task.tags && task.tags.length > 0" class="row wrap items-center q-mb-sm">
        <TagChip v-for="tag in task.tags" :key="tag.id" :name="tag.name" />
      </div>

      <div class="row items-center justify-between q-mt-sm text-caption text-grey-6">
        <div class="row items-center no-wrap">
          <q-icon name="event" size="xs" class="q-mr-xs" />
          <span>{{ task.due_date ? task.due_date : 'Sin vencimiento' }}</span>
        </div>

        <div class="row items-center q-gutter-xs">
          <q-btn
            flat
            round
            dense
            color="primary"
            icon="edit"
            size="sm"
            @click="$emit('edit', task)"
          >
            <q-tooltip>Editar tarea</q-tooltip>
          </q-btn>
          <q-btn
            flat
            round
            dense
            color="negative"
            icon="delete"
            size="sm"
            @click="$emit('delete', task.id)"
          >
            <q-tooltip>Eliminar tarea</q-tooltip>
          </q-btn>
        </div>
      </div>
    </q-card-section>
  </q-card>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import type { Task, TaskStatus } from '../../../types/task';
import PriorityBadge from './PriorityBadge.vue';
import TagChip from './TagChip.vue';
import { formatStatusLabel, getStatusColor, STATUS_OPTIONS } from '../utils/taskFormatters';

const props = defineProps<{
  task: Task;
}>();

const emit = defineEmits<{
  (e: 'edit', task: Task): void;
  (e: 'delete', id: number): void;
  (e: 'status-change', payload: { id: number; status: TaskStatus }): void;
}>();

const statusOptions = STATUS_OPTIONS;

const statusColor = computed(() => getStatusColor(props.task.status));
const statusLabel = computed(() => formatStatusLabel(props.task.status));

function onStatusChange(newStatus: TaskStatus) {
  if (newStatus !== props.task.status) {
    emit('status-change', { id: props.task.id, status: newStatus });
  }
}
</script>

<style scoped>
.title-ellipsis {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  word-break: break-word;
  overflow-wrap: anywhere;
  max-width: 100%;
}

.description-clamp {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  min-height: 2.4em;
}

.hoverable-card {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.hoverable-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
</style>
