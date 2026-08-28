import { defineStore } from 'pinia';
import { ref, reactive } from 'vue';
import type { Task, TaskFilters, TaskStatus } from '../../../types/task';

export const useTaskStore = defineStore('tasks', () => {
    const filters = reactive<TaskFilters>({
        status: null,
        due_date: null,
        priority_id: null,
    });

    const isFormDialogOpen = ref(false);
    const selectedTask = ref<Task | null>(null);

    function setStatusFilter(status: TaskStatus | null) {
        filters.status = status;
    }

    function setDueDateFilter(date: string | null) {
        filters.due_date = date;
    }

    function setPriorityFilter(priorityId: number | null) {
        filters.priority_id = priorityId;
    }

    function resetFilters() {
        filters.status = null;
        filters.due_date = null;
        filters.priority_id = null;
    }

    function openCreateDialog() {
        selectedTask.value = null;
        isFormDialogOpen.value = true;
    }

    function openEditDialog(task: Task) {
        selectedTask.value = task;
        isFormDialogOpen.value = true;
    }

    function closeFormDialog() {
        isFormDialogOpen.value = false;
        selectedTask.value = null;
    }

    return {
        filters,
        isFormDialogOpen,
        selectedTask,
        setStatusFilter,
        setDueDateFilter,
        setPriorityFilter,
        resetFilters,
        openCreateDialog,
        openEditDialog,
        closeFormDialog,
    };
});
