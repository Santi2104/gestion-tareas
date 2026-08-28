import httpClient from '../../../api/httpClient';
import type { Priority } from '../../../types/priority';
import type { ApiSuccessResponse } from '../../../types/api';

export async function getPrioritiesAction(): Promise<Priority[]> {
    const response = await httpClient.get<ApiSuccessResponse<Priority[]>>('/priorities');
    return response.data.data;
}
