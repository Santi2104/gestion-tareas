import { useQuery } from '@tanstack/vue-query';
import { getTasksAction } from '../actions/getTasksAction';
import { useTaskStore } from '../stores/useTaskStore';

export function useTasksQuery() {
    const taskStore = useTaskStore();

    return useQuery({
        queryKey: ['tasks', taskStore.filters],
        queryFn: () => getTasksAction(taskStore.filters),
    });
}
