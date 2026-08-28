import httpClient from '../../../api/httpClient';
import type { Task, TaskFilters } from '../../../types/task';
import type { ApiSuccessResponse } from '../../../types/api';

export async function getTasksAction(filters?: TaskFilters): Promise<Task[]> {
    const params: Record<string, any> = {};

    if (filters?.status) {
        params.status = filters.status;
    }
    if (filters?.due_date) {
        params.due_date = filters.due_date;
    }
    if (filters?.priority_id) {
        params.priority_id = filters.priority_id;
    }

    const response = await httpClient.get<ApiSuccessResponse<Task[]>>('/tasks', { params });
    return response.data.data;
}
