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
            const data = error.response.data as ApiErrorResponse;
            const message = data.message || "An unexpected error occurred.";

            Notify.create({
                type: "negative",
                message: message,
                caption: data.error_code
                    ? `Code: ${data.error_code}`
                    : undefined,
                position: "top-right",
                timeout: 4000,
            });
        } else if (error.request) {
            Notify.create({
                type: "negative",
                message:
                    "Unable to connect to the server. Please check your network connection.",
                position: "top-right",
                timeout: 4000,
            });
        }

        return Promise.reject(error);
    },
);

export default httpClient;
