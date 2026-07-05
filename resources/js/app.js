import "./bootstrap";

// Import modules...
import { createApp, h } from "vue";
import {
	App as InertiaApp,
	plugin as InertiaPlugin,
} from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";

import store from "./store";

import AuthenticatedLayout from "./Layouts/Authenticated.vue";

const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });

const el = document.getElementById("app");

const app = createApp({
	render: () =>
		h(InertiaApp, {
			initialPage: JSON.parse(el.dataset.page),
			resolveComponent: (name) => {
				const module = pages[`./Pages/${name}.vue`];

				if(!module.default.layout) {
					module.default.layout = AuthenticatedLayout;
				}

				return module.default;
			},
			resolveErrors: page => (page.props.errors || {}),
		}),
	mounted() {
		window.addEventListener('popstate', () => {
			this.$page.props.popstate = true;
		})
	}
})
	.mixin({
		computed: {
			currentUser() {
				return this.$page.props.auth?.user;
			}
		},
		methods: {
			route,
			truncate(value, numChars) {
				if(!value) return "";

				let str = value.substring(0, numChars).trim();
				if(numChars > value.length) {
					return str;
				} else {
					return str + "...";
				}
			},
			routeUrl() {
				return location.pathname.substr(1)
			},
		}
	})
	.use(InertiaPlugin)
	.use(store);

import Icon from "./Shared/Icon.vue";
import BrandLogo from "./Shared/BrandLogo.vue";
import Card from "./Shared/Card.vue";
import Table from "./Shared/Table.vue";
app.component('Icon', Icon);
app.component('BrandLogo', BrandLogo);
app.component('Card', Card);
app.component('AppTable', Table);

app.mount(el);

InertiaProgress.init({ color: "#4B5563" });
