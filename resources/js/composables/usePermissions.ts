import { type SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';

export function usePermissions() {
    const page = usePage<SharedData>();

    const can = (permissions: string[]): boolean => {
        const allPermissions = page.props.auth.permissions as Record<string, boolean>;
        return permissions.some((item) => allPermissions[item]);
    };

    return { can };
}
