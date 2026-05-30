<template>
	<aside id="sidebar" v-show="sidebarActive" class="side">
		<inertia-link class="brand" :href="route('home')"><brand-logo dark tagline="STUDENT WORKSPACE" /></inertia-link>
		<div class="grp">Workspace</div>
		<nav>
			<inertia-link v-for="link in mainLinks" :key="link.name" v-show="link.show" :href="route(link.name)" :class="{ active: route().current(`${link.name.split('.')[0]}*`) }">
				<icon :name="link.icon" /> {{ link.label }} <span v-if="link.count" class="nb">{{ link.count }}</span>
			</inertia-link>
		</nav>
		<div class="grp">Account</div>
		<nav>
			<inertia-link :href="route('profile.show')"><icon name="user-circle" /> Profile</inertia-link>
			<inertia-link href="#"><icon name="collection" /> Settings</inertia-link>
		</nav>
		<div class="spacer"></div>
		<div class="me">
			<span class="av">{{ initials }}</span>
			<div style="min-width:0"><b>{{ currentUser.name }}</b><span>{{ currentUser.userable_type || 'Admin' }}</span></div>
			<inertia-link class="out" :href="route('logout')" method="POST" as="button" title="Log out" aria-label="Log out"><icon name="x" /></inertia-link>
		</div>
	</aside>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
	data() {
		return { mainLinks: [
			{ name: 'dashboard', label: 'Dashboard', icon: 'collection', show: true },
			{ name: 'applications.index', label: 'Applications', icon: 'folder', show: ['student', 'company'].includes(this.currentUser.userable_type) },
			{ name: 'internships.index', label: 'Internships', icon: 'briefcase', show: true },
			{ name: 'likes.index', label: 'Saved roles', icon: 'heart', show: this.currentUser.userable_type === 'student', count: this.currentUser.likes_count || 0 },
			{ name: 'messages.index', label: 'Messages', icon: 'mail', show: ['student', 'company'].includes(this.currentUser.userable_type), count: 3 },
			{ name: 'companies.index', label: 'Companies', icon: 'office-building', show: this.currentUser.is_admin || this.currentUser.userable_type === 'student' },
		] };
	},
	computed: { ...mapGetters(['sidebarActive']), initials() { return (this.currentUser.name || 'AB').split(' ').slice(0,2).map(w=>w[0]).join('').toUpperCase() } },
	methods: { ...mapActions(['closeSidebar']) },
	created() { if(window.innerWidth < 1024) this.closeSidebar(); }
};
</script>
