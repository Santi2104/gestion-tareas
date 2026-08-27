import axios from "axios";
import { Notify } from "quasar";
import type { ApiErrorResponse } from "../types/api";

const httpClient = axios.create({
    baseURL: "/api",
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
    withCredentials: true,
});

httpClient.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response) {
            const status = error.response.status;
            const requestUrl = error.config?.url || "";

            // Silence global error toasts for auth endpoints managed directly by form pages
            if (
                requestUrl.endsWith("/user") ||
                requestUrl.endsWith("/api/user") ||
                requestUrl.endsWith("/login") ||
                requestUrl.endsWith("/api/login") ||
                requestUrl.endsWith("/register") ||
                requestUrl.endsWith("/api/register")
            ) {
                return Promise.reject(error);
            }

            // Handle active 401 errors (session expiration on protected resources)
            if (status === 401) {
                Notify.create({
                    type: "warning",
                    message: "Tu sesión ha expirado o no estás autenticado.",
                    caption: "Por favor, inicia sesión para continuar.",
                    position: "top-right",
                    timeout: 4000,
                });
                return Promise.reject(error);
            }

            const data = error.response.data as ApiErrorResponse;
            const message = data.message || "Ha ocurrido un error inesperado.";

            Notify.create({
                type: "negative",
                message: message,
                caption: data.error_code
                    ? `Código: ${data.error_code}`
                    : undefined,
                position: "top-right",
                timeout: 4000,
            });
        } else if (error.request) {
            Notify.create({
                type: "negative",
                message:
                    "No se pudo conectar con el servidor. Verifica tu conexión a internet.",
                position: "top-right",
                timeout: 4000,
            });
        }

        return Promise.reject(error);
    },
);

export default httpClient;
