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
                message: "¡Tarea creada exitosamente!",
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
                message: "¡Tarea actualizada exitosamente!",
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
                message: "¡Estado de la tarea actualizado!",
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
                message: "¡Tarea eliminada exitosamente!",
                position: "top-right",
                timeout: 3000,
            });
        },
        onError: () => {
            Notify.create({
                type: "negative",
                message: "No se pudo eliminar la tarea. Intenta nuevamente.",
                position: "top-right",
                timeout: 4000,
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
