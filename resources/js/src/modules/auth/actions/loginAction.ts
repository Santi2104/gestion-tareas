import httpClient from "../../../api/httpClient";
import type { LoginCredentials } from "../../../types/auth";
import { getCsrfTokenAction } from "./getCsrfTokenAction";

export async function loginAction(credentials: LoginCredentials): Promise<void> {
    await getCsrfTokenAction();
    await httpClient.post("/login", credentials);
}
