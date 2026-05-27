require("./bootstrap");

// Import modules...
import { createApp, h } from "vue";
import {
	App as InertiaApp,
	plugin as InertiaPlugin,
} from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";

import store from "./store";

const el = document.getElementById("app");

import AuthenticatedLayout from "./Layouts/Authenticated";
const app = createApp({
	render: () =>
		h(InertiaApp, {
			initialPage: JSON.parse(el.dataset.page),
			resolveComponent: (name) => {
				const module = require(`./Pages/${name}`);

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

import Icon from "./Shared/Icon";
import BrandLogo from "./Shared/BrandLogo";
import Card from "./Shared/Card";
import Table from "./Shared/Table";
app.component('Icon', Icon);
app.component('BrandLogo', BrandLogo);
app.component('Card', Card);
app.component('AppTable', Table);

app.mount(el);

InertiaProgress.init({ color: "#4B5563" });
