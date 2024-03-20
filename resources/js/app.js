import './bootstrap';
import { createInertiaApp } from '@westacks/inertia-svelte';
import Layout from './Pages/Layout.svelte';

createInertiaApp({
    progress: false,
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true });
        let page = pages[`./Pages/${name}.svelte`];

        const layouts = [Layout];

        if (page.layout) {
            for (let i = 0; i < page.layout.length; i++) {
                const el = page.layout[i];
                layouts.push(el);
            }
        }

        return { default: page.default, layout: layouts };
    },
    setup({ el, App }) {
        new App({ target: el, hydrate: true });
    },
})
