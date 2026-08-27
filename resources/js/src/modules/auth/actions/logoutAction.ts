import httpClient from "../../../api/httpClient";

export async function logoutAction(): Promise<void> {
    await httpClient.post("/logout", {});
}
