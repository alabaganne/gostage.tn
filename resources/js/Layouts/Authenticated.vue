<template>
	<div v-if="currentUser" class="flex min-h-screen in-layout-bg">
		<toast :toast="$page.props.toast" :popstate="$page.props.popstate" />
		<sidebar :key="routeUrl()" />
		<div class="flex-1 flex flex-col text-gray-900 min-w-0">
			<navbar />
			<slot />
		</div>
	</div>
	<slot v-else />
</template>

<script>
import Sidebar from './Partials/Sidebar';
import Navbar from './Partials/Navbar';
import Toast from './Partials/Toast';

export default {
	components: { Sidebar, Navbar, Toast },
	mounted() {
		if (!this.currentUser || !window.Echo) return;

		window.Echo.private('user.' + this.currentUser.id)
			.listen('.messages', e => {
				if(!route().current('messages.index')) {
					this.$page.props.toast = e.toast
				}
			})
	}
}
</script>
