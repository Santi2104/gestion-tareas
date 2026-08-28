export interface ApiSuccessResponse<T> {
    data: T;
}

export interface ApiErrorResponse {
    success: false;
    message: string;
    error_code: string;
    meta?: {
        errors?: Record<string, string[]>;
    };
}
