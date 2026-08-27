<template>
  <q-chip
    :color="chipColor"
    text-color="white"
    size="sm"
    dense
    class="q-ma-xs text-weight-medium"
  >
    {{ name }}
  </q-chip>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { getTagColor } from '../utils/taskFormatters';

const props = defineProps<{
  name: string;
}>();

const chipColor = computed(() => getTagColor(props.name));
</script>
