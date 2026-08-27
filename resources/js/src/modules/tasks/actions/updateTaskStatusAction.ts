import httpClient from '../../../api/httpClient';
import type { Task, TaskStatus } from '../../../types/task';
import type { ApiSuccessResponse } from '../../../types/api';

export async function updateTaskStatusAction(id: number, status: TaskStatus): Promise<Task> {
    const response = await httpClient.patch<ApiSuccessResponse<Task>>(`/tasks/${id}/status`, { status });
    return response.data.data;
}
