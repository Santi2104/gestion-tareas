export type FormFieldErrors = Record<string, string>;

/**
 * Extracts validation error messages sent directly in Spanish by the Laravel API
 * and formats them into a key-value map for form fields and VeeValidate `setErrors()`.
 */
export function extractBackendErrors(error: any): FormFieldErrors {
    const rawErrors =
        error?.response?.data?.meta?.errors || error?.response?.data?.errors;

    if (!rawErrors || typeof rawErrors !== "object") {
        return {};
    }

    const mapped: FormFieldErrors = {};

    for (const field in rawErrors) {
        if (Array.isArray(rawErrors[field]) && rawErrors[field].length > 0) {
            mapped[field] = rawErrors[field][0];
        } else if (typeof rawErrors[field] === "string") {
            mapped[field] = rawErrors[field];
        }
    }

    return mapped;
}
