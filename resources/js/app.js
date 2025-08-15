import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
// import AppLayout from "@/Layouts/AppLayout.vue";
import MyLayout from "@/Layouts/MyLayout.vue";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'))
        page.then((module) => {
            let defaultLayout = MyLayout; // (name.startsWith("Admin/")) ? AdminLayout : AppLayout
            module.default.layout = module.default.layout || defaultLayout;
        });
        return page;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                // unstyled: true,
                theme: {
                    preset: Aura,
                    options: {
                        cssLayer: {
                            name: 'primevue',
                            order: 'theme, base, primevue'
                        }
                    }
                }
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
