import "./bootstrap";

import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/vue3";

import store from "./store";
import reveal from "./directives/reveal";

import AuthenticatedLayout from "./Layouts/Authenticated.vue";

import Icon from "./Shared/Icon.vue";
import BrandLogo from "./Shared/BrandLogo.vue";
import Card from "./Shared/Card.vue";
import Table from "./Shared/Table.vue";

createInertiaApp({
	resolve: (name) => {
		const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
		const page = pages[`./Pages/${name}.vue`];

		if (!page.default.layout) {
			page.default.layout = AuthenticatedLayout;
		}

		return page;
	},
	setup({ el, App, props, plugin }) {
		const app = createApp({
			render: () => h(App, props),
			mounted() {
				window.addEventListener("popstate", () => {
					this.$page.props.popstate = true;
				});
			},
		})
			.use(plugin)
			.use(store)
			.mixin({
				computed: {
					currentUser() {
						return this.$page.props.auth?.user;
					},
				},
				methods: {
					route,
					truncate(value, numChars) {
						if (!value) return "";

						let str = value.substring(0, numChars).trim();
						if (numChars > value.length) {
							return str;
						} else {
							return str + "...";
						}
					},
					routeUrl() {
						return location.pathname.substr(1);
					},
				},
			});

		app.directive("reveal", reveal);

		app.component("InertiaLink", Link);
		app.component("Icon", Icon);
		app.component("BrandLogo", BrandLogo);
		app.component("Card", Card);
		app.component("AppTable", Table);

		app.mount(el);
	},
	progress: { color: "#4B5563" },
});
