import { describe, it, expect, beforeEach } from 'vitest';
import { setActivePinia, createPinia } from 'pinia';
import { useTaskStore } from '../../../../src/modules/tasks/stores/useTaskStore';
import type { Task } from '../../../../src/types/task';

describe('useTaskStore', () => {
    beforeEach(() => {
        setActivePinia(createPinia());
    });

    it('should initialize with empty filters and closed dialog state', () => {
        const store = useTaskStore();

        expect(store.filters).toEqual({
            status: null,
            due_date: null,
            priority_id: null,
        });
        expect(store.isFormDialogOpen).toBe(false);
        expect(store.selectedTask).toBeNull();
    });

    it('should update individual filters correctly', () => {
        const store = useTaskStore();

        store.setStatusFilter('in_progress');
        store.setDueDateFilter('2026-12-31');
        store.setPriorityFilter(2);

        expect(store.filters.status).toBe('in_progress');
        expect(store.filters.due_date).toBe('2026-12-31');
        expect(store.filters.priority_id).toBe(2);
    });

    it('should reset all filters back to null', () => {
        const store = useTaskStore();

        store.setStatusFilter('completed');
        store.setDueDateFilter('2026-12-31');
        store.setPriorityFilter(1);

        store.resetFilters();

        expect(store.filters.status).toBeNull();
        expect(store.filters.due_date).toBeNull();
        expect(store.filters.priority_id).toBeNull();
    });

    it('should open create dialog with clean selectedTask state', () => {
        const store = useTaskStore();

        store.openCreateDialog();

        expect(store.isFormDialogOpen).toBe(true);
        expect(store.selectedTask).toBeNull();
    });

    it('should open edit dialog with the provided task populated', () => {
        const store = useTaskStore();
        const mockTask: Task = {
            id: 1,
            title: 'Fix issue',
            description: 'Important fix',
            status: 'pending',
            due_date: '2026-12-31',
            priority_id: 1,
            priority: { id: 1, name: 'high' },
            tags: [],
            created_at: '2026-01-01',
            updated_at: '2026-01-01',
        };

        store.openEditDialog(mockTask);

        expect(store.isFormDialogOpen).toBe(true);
        expect(store.selectedTask).toEqual(mockTask);
    });

    it('should close dialog and clear selected task', () => {
        const store = useTaskStore();
        const mockTask: Task = {
            id: 1,
            title: 'Fix issue',
            description: null,
            status: 'pending',
            due_date: null,
            priority_id: 1,
            tags: [],
            created_at: '2026-01-01',
            updated_at: '2026-01-01',
        };

        store.openEditDialog(mockTask);
        store.closeFormDialog();

        expect(store.isFormDialogOpen).toBe(false);
        expect(store.selectedTask).toBeNull();
    });
});
