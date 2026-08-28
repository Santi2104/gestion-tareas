import { useQuery } from '@tanstack/vue-query';
import { getTagsAction } from '../actions/getTagsAction';

export function useTagsQuery() {
    return useQuery({
        queryKey: ['tags'],
        queryFn: getTagsAction,
        staleTime: 1000 * 60 * 60,
    });
}
