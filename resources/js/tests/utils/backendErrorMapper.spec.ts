import { describe, it, expect } from 'vitest';
import { extractBackendErrors } from '../../src/utils/backendErrorMapper';

describe('backendErrorMapper', () => {
    it('should extract validation errors from meta.errors envelope structure', () => {
        const error = {
            response: {
                data: {
                    meta: {
                        errors: {
                            email: ['The email has already been taken.'],
                            password: [
                                'The password must be at least 8 characters.',
                            ],
                        },
                    },
                },
            },
        };

        const result = extractBackendErrors(error);

        expect(result).toEqual({
            email: 'The email has already been taken.',
            password: 'The password must be at least 8 characters.',
        });
    });

    it('should extract validation errors from direct errors object fallback', () => {
        const error = {
            response: {
                data: {
                    errors: {
                        title: ['The title field is required.'],
                    },
                },
            },
        };

        const result = extractBackendErrors(error);

        expect(result).toEqual({
            title: 'The title field is required.',
        });
    });

    it('should handle string error messages directly if not array wrapped', () => {
        const error = {
            response: {
                data: {
                    errors: {
                        priority_id: 'The selected priority is invalid.',
                    },
                },
            },
        };

        const result = extractBackendErrors(error);

        expect(result).toEqual({
            priority_id: 'The selected priority is invalid.',
        });
    });

    it('should return empty object on null, undefined or malformed error objects', () => {
        expect(extractBackendErrors(null)).toEqual({});
        expect(extractBackendErrors(undefined)).toEqual({});
        expect(extractBackendErrors({})).toEqual({});
        expect(extractBackendErrors({ response: {} })).toEqual({});
        expect(
            extractBackendErrors({ response: { data: { meta: {} } } }),
        ).toEqual({});
    });
});
