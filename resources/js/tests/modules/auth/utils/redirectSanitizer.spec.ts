import { describe, it, expect } from 'vitest';
import { getSafeRedirectUrl } from '../../../../src/modules/auth/utils/redirectSanitizer';

describe('redirectSanitizer', () => {
    it('should allow valid relative internal paths', () => {
        expect(getSafeRedirectUrl('/tasks')).toBe('/tasks');
        expect(getSafeRedirectUrl('/tasks/create')).toBe('/tasks/create');
        expect(getSafeRedirectUrl('/tasks?status=pending&priority_id=1')).toBe(
            '/tasks?status=pending&priority_id=1',
        );
    });

    it('should prevent Open Redirect vulnerabilities by rejecting absolute URLs', () => {
        expect(getSafeRedirectUrl('https://malicious-site.com')).toBe('/tasks');
        expect(getSafeRedirectUrl('http://evil.com/phishing')).toBe('/tasks');
        expect(getSafeRedirectUrl('//evil.com')).toBe('/tasks');
        expect(getSafeRedirectUrl('javascript:alert(1)')).toBe('/tasks');
    });

    it('should prevent redirect loops back to authentication routes', () => {
        expect(getSafeRedirectUrl('/login')).toBe('/tasks');
        expect(getSafeRedirectUrl('/register')).toBe('/tasks');
        expect(getSafeRedirectUrl('/logout')).toBe('/tasks');
        expect(getSafeRedirectUrl('/login?redirect=/tasks')).toBe('/tasks');
    });

    it('should fallback to default or custom fallback on invalid input types', () => {
        expect(getSafeRedirectUrl(null)).toBe('/tasks');
        expect(getSafeRedirectUrl(undefined)).toBe('/tasks');
        expect(getSafeRedirectUrl('')).toBe('/tasks');
        expect(getSafeRedirectUrl('   ')).toBe('/tasks');
        expect(getSafeRedirectUrl(12345)).toBe('/tasks');
        expect(getSafeRedirectUrl(null, '/custom-fallback')).toBe(
            '/custom-fallback',
        );
    });
});
