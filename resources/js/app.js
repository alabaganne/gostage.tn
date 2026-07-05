import "./bootstrap";

import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/vue3";

import reveal from "./directives/reveal";
import AppShell from "./Layouts/AppShell.vue";

createInertiaApp({
	resolve: (name) => {
		const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
		const page = pages[`./Pages/${name}.vue`];

		// Pages without an explicit layout land in the workspace shell.
		if (!page.default.layout) {
			page.default.layout = (_h, child) => h(AppShell, {}, () => child);
		}

		return page;
	},
	setup({ el, App, props, plugin }) {
		const app = createApp({ render: () => h(App, props) }).use(plugin);

		// Ziggy's @routes directive defines window.route; expose it to templates.
		app.config.globalProperties.route = window.route;

		app.directive("reveal", reveal);
		app.component("InertiaLink", Link);

		app.mount(el);
	},
	progress: { color: "#2563eb" },
});
