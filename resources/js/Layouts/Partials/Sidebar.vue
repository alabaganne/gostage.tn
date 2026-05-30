<template>
	<aside id="sidebar" v-show="sidebarActive" class="w-80 in-sidebar flex-shrink-0 fixed top-0 min-h-screen lg:relative z-50 shadow-2xl">
		<div class="h-20 px-7 flex justify-between items-center border-b border-white border-opacity-10">
			<brand-logo dark />
			<button @click="closeSidebar" class="text-blue-100 p-1 rounded-lg hover:bg-white hover:bg-opacity-10 lg:hidden">
				<icon name="x" class="h-5 w-5" />
			</button>
		</div>
		<div class="px-3 py-5 space-y-1">
			<div class="px-4 pb-3 text-xs font-extrabold uppercase tracking-widest text-blue-300">Workspace</div>
			<template v-for="link in mainLinks" :key="link.name">
				<inertia-link
					v-if="link.show"
					:href="route(link.name)"
					class="px-4 py-3 flex items-center rounded-xl font-semibold text-sm transition"
					:class="route().current(`${link.name.split('.')[0]}*`) ? 'in-sidebar-active' : 'hover:bg-white hover:bg-opacity-10'"
				>
					<icon :name="link.icon" class="text-blue-300" />
					<span class="ml-4">{{ link.label }}</span>
				</inertia-link>
			</template>
		</div>
		<div class="px-3 py-5 border-t border-white border-opacity-10 space-y-1">
			<div class="px-4 pb-3 text-xs font-extrabold uppercase tracking-widest text-blue-300">Public</div>
			<inertia-link
				v-for="link in secondaryLinks"
				:key="link.name"
				:href="route(link.name)"
				class="px-4 py-3 flex items-center hover:bg-white hover:bg-opacity-10 rounded-xl font-semibold text-sm"
			>
				<icon :name="link.icon" class="text-blue-300" />
				<span class="ml-4">{{ link.label }}</span>
			</inertia-link>
		</div>
		<div class="absolute bottom-0 left-0 right-0 p-4">
			<div class="rounded-2xl bg-white bg-opacity-10 border border-white border-opacity-10 p-4">
				<div class="text-sm font-bold text-white">{{ currentUser.name }}</div>
				<div class="mt-1 text-xs text-blue-200 truncate">{{ currentUser.email }}</div>
			</div>
		</div>
	</aside>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
	data() {
		return {
			mainLinks: [
				{ name: 'dashboard', label: 'Dashboard', icon: 'collection', show: true },
				{ name: 'applications.index', label: 'Applications', icon: 'folder', show: ['student', 'company'].includes(this.currentUser.userable_type) },
				{ name: 'internships.index', label: 'Internships', icon: 'briefcase', show: true },
				{ name: 'companies.index', label: 'Companies', icon: 'office-building', show: this.currentUser.is_admin || this.currentUser.userable_type === 'student' },
				{ name: 'students.index', label: 'Students', icon: 'user-group', show: this.currentUser.is_admin },
				{ name: 'fields.index', label: 'Fields of Studies', icon: 'light-bulb', show: this.currentUser.is_admin },
			],
			secondaryLinks: [
				{ name: 'home', label: 'Home', icon: 'home' },
				{ name: 'blog.index', label: 'Blog', icon: 'document-text' },
				{ name: 'contact', label: 'Contact us', icon: 'mail' },
			],
		};
	},
	computed: { ...mapGetters(['sidebarActive']) },
	methods: { ...mapActions(['closeSidebar']) },
	created() { if(window.innerWidth < 1024) this.closeSidebar(); }
};
</script>
