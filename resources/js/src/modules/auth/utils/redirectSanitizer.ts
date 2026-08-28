/**
 * Validates and sanitizes redirect URLs
 */
export function getSafeRedirectUrl(
    targetUrl: unknown,
    fallbackUrl: string = "/tasks",
): string {
    if (typeof targetUrl !== "string" || !targetUrl.trim()) {
        return fallbackUrl;
    }

    const trimmed = targetUrl.trim();

    if (
        !trimmed.startsWith("/") ||
        trimmed.startsWith("//") ||
        /^https?:\/\//i.test(trimmed)
    ) {
        return fallbackUrl;
    }

    const pathOnly = trimmed.split("?")[0].split("#")[0];

    if (
        pathOnly === "/login" ||
        pathOnly === "/register" ||
        pathOnly === "/logout"
    ) {
        return fallbackUrl;
    }

    return trimmed;
}
