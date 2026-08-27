import httpClient from '../../../api/httpClient';
import type { Task, UpdateTaskPayload } from '../../../types/task';
import type { ApiSuccessResponse } from '../../../types/api';

export async function updateTaskAction(id: number, payload: UpdateTaskPayload): Promise<Task> {
    const response = await httpClient.put<ApiSuccessResponse<Task>>(`/tasks/${id}`, payload);
    return response.data.data;
}
