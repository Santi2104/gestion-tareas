import httpClient from '../../../api/httpClient';
import type { Task, CreateTaskPayload } from '../../../types/task';
import type { ApiSuccessResponse } from '../../../types/api';

export async function createTaskAction(payload: CreateTaskPayload): Promise<Task> {
    const response = await httpClient.post<ApiSuccessResponse<Task>>('/tasks', payload);
    return response.data.data;
}
