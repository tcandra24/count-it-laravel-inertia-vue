import type { route as routeFn } from 'ziggy-js';

declare global {
    const route: typeof routeFn;
}

interface User {
    id: number;
    name: string;
    email: string;
}

interface Auth {
    user: User;
    permissions: Record<string, boolean>;
}

interface PageProps extends InertiaPageProps {
    auth: Auth;
}

declare module '@inertiajs/vue3' {
    interface PageProps extends Record<string, unknown> {
        auth: Auth;
    }
}
