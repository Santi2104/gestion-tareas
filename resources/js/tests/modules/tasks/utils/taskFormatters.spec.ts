import { describe, it, expect } from 'vitest';
import {
    formatPriorityLabel,
    getPriorityColor,
    formatStatusLabel,
    getStatusColor,
    STATUS_OPTIONS,
    getTagColor,
} from '../../../../src/modules/tasks/utils/taskFormatters';

describe('taskFormatters', () => {
    describe('formatPriorityLabel', () => {
        it('should format low, medium, and high priority levels to Spanish correctly', () => {
            expect(formatPriorityLabel('low')).toBe('Baja');
            expect(formatPriorityLabel('medium')).toBe('Media');
            expect(formatPriorityLabel('high')).toBe('Alta');
        });

        it('should be case-insensitive', () => {
            expect(formatPriorityLabel('LOW')).toBe('Baja');
            expect(formatPriorityLabel('Medium')).toBe('Media');
            expect(formatPriorityLabel('HIGH')).toBe('Alta');
        });

        it('should return the original string or N/A when unknown or undefined', () => {
            expect(formatPriorityLabel('urgent')).toBe('urgent');
            expect(formatPriorityLabel(undefined)).toBe('N/A');
        });
    });

    describe('getPriorityColor', () => {
        it('should map priorities to Quasar palette colors', () => {
            expect(getPriorityColor('low')).toBe('positive');
            expect(getPriorityColor('medium')).toBe('warning');
            expect(getPriorityColor('high')).toBe('negative');
        });

        it('should fallback to grey for unknown priority levels', () => {
            expect(getPriorityColor('unknown')).toBe('grey');
            expect(getPriorityColor(undefined)).toBe('grey');
        });
    });

    describe('formatStatusLabel', () => {
        it('should format task status codes to Spanish readable labels', () => {
            expect(formatStatusLabel('pending')).toBe('Pendiente');
            expect(formatStatusLabel('in_progress')).toBe('En Progreso');
            expect(formatStatusLabel('completed')).toBe('Completada');
        });

        it('should default to Pendiente for unknown or undefined status', () => {
            expect(formatStatusLabel(undefined)).toBe('Pendiente');
            expect(formatStatusLabel('draft')).toBe('Pendiente');
        });
    });

    describe('getStatusColor', () => {
        it('should map task statuses to corresponding badge colors', () => {
            expect(getStatusColor('completed')).toBe('positive');
            expect(getStatusColor('in_progress')).toBe('info');
            expect(getStatusColor('pending')).toBe('warning');
        });

        it('should default to warning for undefined status', () => {
            expect(getStatusColor(undefined)).toBe('warning');
        });
    });

    describe('STATUS_OPTIONS', () => {
        it('should contain the 3 valid task statuses with Spanish labels', () => {
            expect(STATUS_OPTIONS).toHaveLength(3);
            expect(STATUS_OPTIONS).toEqual([
                { label: 'Pendiente', value: 'pending' },
                { label: 'En Progreso', value: 'in_progress' },
                { label: 'Completada', value: 'completed' },
            ]);
        });
    });

    describe('getTagColor', () => {
        it('should return matching Quasar brand colors for tag names', () => {
            expect(getTagColor('DEV')).toBe('primary');
            expect(getTagColor('QA')).toBe('secondary');
            expect(getTagColor('HR')).toBe('purple-7');
        });

        it('should handle case insensitivity and fallback for other tags', () => {
            expect(getTagColor('dev')).toBe('primary');
            expect(getTagColor('DESIGN')).toBe('blue-grey');
            expect(getTagColor(undefined)).toBe('blue-grey');
        });
    });
});
