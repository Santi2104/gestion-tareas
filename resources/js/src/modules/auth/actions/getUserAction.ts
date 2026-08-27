import httpClient from "../../../api/httpClient";
import type { User } from "../../../types/auth";

export async function getUserAction(): Promise<User> {
    const response = await httpClient.get<User>("/user");
    return response.data;
}
