import { useMutation, useQueryClient } from "@tanstack/vue-query";
import { Notify } from "quasar";
import { createTaskAction } from "../actions/createTaskAction";
import { updateTaskAction } from "../actions/updateTaskAction";
import { updateTaskStatusAction } from "../actions/updateTaskStatusAction";
import { deleteTaskAction } from "../actions/deleteTaskAction";
import { useTaskStore } from "../stores/useTaskStore";
import type {
    CreateTaskPayload,
    TaskStatus,
    UpdateTaskPayload,
} from "../../../types/task";

export function useTaskMutations() {
    const queryClient = useQueryClient();
    const taskStore = useTaskStore();

    const createMutation = useMutation({
        mutationFn: (payload: CreateTaskPayload) => createTaskAction(payload),
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ["tasks"] });
            Notify.create({
                type: "positive",
                message: "Task created successfully!",
                position: "top-right",
                timeout: 3000,
            });
            taskStore.closeFormDialog();
        },
    });

    const updateMutation = useMutation({
        mutationFn: ({
            id,
            payload,
        }: {
            id: number;
            payload: UpdateTaskPayload;
        }) => updateTaskAction(id, payload),
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ["tasks"] });
            Notify.create({
                type: "positive",
                message: "Task updated successfully!",
                position: "top-right",
                timeout: 3000,
            });
            taskStore.closeFormDialog();
        },
    });

    const updateStatusMutation = useMutation({
        mutationFn: ({ id, status }: { id: number; status: TaskStatus }) =>
            updateTaskStatusAction(id, status),
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ["tasks"] });
            Notify.create({
                type: "positive",
                message: "Task status updated!",
                position: "top-right",
                timeout: 2500,
            });
        },
    });

    const deleteMutation = useMutation({
        mutationFn: (id: number) => deleteTaskAction(id),
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ["tasks"] });
            Notify.create({
                type: "positive",
                message: "Task deleted successfully!",
                position: "top-right",
                timeout: 3000,
            });
        },
    });

    return {
        createMutation,
        updateMutation,
        updateStatusMutation,
        deleteMutation,
    };
}
