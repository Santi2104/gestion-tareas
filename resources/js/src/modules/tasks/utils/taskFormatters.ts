import type { TaskStatus } from '../../../types/task';

export function formatPriorityLabel(level?: string): string {
    switch (level?.toLowerCase()) {
        case 'high':
            return 'Alta';
        case 'medium':
            return 'Media';
        case 'low':
            return 'Baja';
        default:
            return level || 'N/A';
    }
}

export function getPriorityColor(level?: string): string {
    switch (level?.toLowerCase()) {
        case 'high':
            return 'negative';
        case 'medium':
            return 'warning';
        case 'low':
            return 'positive';
        default:
            return 'grey';
    }
}

export function formatStatusLabel(status?: string): string {
    switch (status) {
        case 'completed':
            return 'Completada';
        case 'in_progress':
            return 'En Progreso';
        case 'pending':
        default:
            return 'Pendiente';
    }
}

export function getStatusColor(status?: string): string {
    switch (status) {
        case 'completed':
            return 'positive';
        case 'in_progress':
            return 'info';
        case 'pending':
        default:
            return 'warning';
    }
}

export const STATUS_OPTIONS: { label: string; value: TaskStatus }[] = [
    { label: 'Pendiente', value: 'pending' },
    { label: 'En Progreso', value: 'in_progress' },
    { label: 'Completada', value: 'completed' },
];

export function getTagColor(name?: string): string {
    switch (name?.toUpperCase()) {
        case 'DEV':
            return 'primary';
        case 'QA':
            return 'secondary';
        case 'HR':
            return 'purple-7';
        default:
            return 'blue-grey';
    }
}
