import httpClient from '../../../api/httpClient';

export async function deleteTaskAction(id: number): Promise<void> {
    await httpClient.delete(`/tasks/${id}`);
}
