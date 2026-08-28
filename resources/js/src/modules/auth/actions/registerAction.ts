import httpClient from "../../../api/httpClient";
import type { RegisterData } from "../../../types/auth";
import { getCsrfTokenAction } from "./getCsrfTokenAction";

export async function registerAction(data: RegisterData): Promise<void> {
    await getCsrfTokenAction();
    await httpClient.post("/register", data);
}
