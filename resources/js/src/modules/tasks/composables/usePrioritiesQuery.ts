import { useQuery } from '@tanstack/vue-query';
import { getPrioritiesAction } from '../actions/getPrioritiesAction';

export function usePrioritiesQuery() {
    return useQuery({
        queryKey: ['priorities'],
        queryFn: getPrioritiesAction,
        staleTime: 1000 * 60 * 60,
    });
}
