import { ZiggyVue, Ziggy } from './ziggy'

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy) // 💥 Aquí se inyecta route()
            .mount(el)
    },
    progress: {
        color: '#4B5563',
    },
})

initializeTheme()
