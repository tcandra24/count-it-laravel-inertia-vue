import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';

import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

import SidebarProvider from './layouts/SidebarProvider.vue';
import ThemeProvider from './layouts/ThemeProvider.vue';

// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({
            render: () =>
                h(
                    ThemeProvider,
                    {},
                    {
                        default: () =>
                            h(
                                SidebarProvider,
                                {},
                                {
                                    default: () => h(App, props),
                                },
                            ),
                    },
                ),
        })
            .mixin({
                methods: {
                    hasAnyPermission: function (permissions: string[]): boolean {
                        const allPermissions = this.$page.props.auth.permissions as Record<string, boolean>;
                        return permissions.some((item) => allPermissions[item]);
                    },
                    monthName: function (month: number): string {
                        const months = [
                            '',
                            'January',
                            'Febuary',
                            'March',
                            'April',
                            'Mei',
                            'Juni',
                            'July',
                            'Agustus',
                            'September',
                            'October',
                            'November',
                            'December',
                        ];
                        return months[month];
                    },
                },
            })
            .use(plugin)
            .use(ZiggyVue)
            .use(Toast, {
                timeout: 3000,
                position: 'bottom-right',
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
