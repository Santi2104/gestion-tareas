import type { Priority } from "./priority";
import type { Tag } from "./tag";

export type TaskStatus = "pending" | "in_progress" | "completed";

export interface Task {
    id: number;
    title: string;
    description: string | null;
    status: TaskStatus;
    due_date: string | null;
    priority_id: number;
    priority?: Priority;
    tags?: Tag[];
    created_at: string;
    updated_at: string;
}

export interface CreateTaskPayload {
    title: string;
    priority_id: number;
    description?: string | null;
    status?: TaskStatus;
    due_date?: string | null;
    tag_ids?: number[];
}

export interface UpdateTaskPayload {
    title?: string;
    priority_id?: number;
    description?: string | null;
    status?: TaskStatus;
    due_date?: string | null;
    tag_ids?: number[];
}

export interface TaskFilters {
    status?: TaskStatus | null;
    due_date?: string | null;
    priority_id?: number | null;
}
