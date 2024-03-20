import { createInertiaApp } from '@westacks/inertia-svelte';
import createServer from '@westacks/inertia-svelte/server';

createServer(page =>
    createInertiaApp({
        progress: false,
        page,
        resolve: name => {
            const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true })
            return pages[`./Pages/${name}.svelte`]
        },
    }),
)
