import httpClient from "../../../api/httpClient";
import type { Tag } from "../../../types/tag";
import type { ApiSuccessResponse } from "../../../types/api";

export async function getTagsAction(): Promise<Tag[]> {
    const response = await httpClient.get<ApiSuccessResponse<Tag[]>>("/tags");
    return response.data.data;
}
