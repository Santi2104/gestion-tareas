<template>
  <q-badge
    :color="badgeColor"
    :label="badgeLabel"
    outline
    class="text-weight-bold q-px-sm q-py-xs"
  />
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { formatPriorityLabel, getPriorityColor } from '../utils/taskFormatters';

const props = defineProps<{
  level?: string;
}>();

const badgeColor = computed(() => getPriorityColor(props.level));
const badgeLabel = computed(() => formatPriorityLabel(props.level));
</script>
