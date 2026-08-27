import axios from "axios";

export async function getCsrfTokenAction(): Promise<void> {
    await axios.get("/sanctum/csrf-cookie", { withCredentials: true });
}
