<script setup>
import { ref } from 'vue';
import AppSidebar from './AppSidebar.vue';
import AppTopbar from './AppTopbar.vue';
import NotificationsPanel from '@/Components/NotificationsPanel.vue';

defineProps({
	active: { type: String, default: '' }, // 'dashboard' | 'applications' | …
	fill: { type: Boolean, default: false }, // true for full-height, internally-scrolling pages (Messages)
});

const notificationsOpen = ref(false);
</script>

<template>
	<div class="grid grid-cols-[248px_1fr] bg-paper-2" :class="fill ? 'h-screen' : 'min-h-screen'">
		<AppSidebar :active="active" />
		<div class="flex flex-col min-w-0" :class="{ 'overflow-hidden': fill }">
			<AppTopbar @notifications="notificationsOpen = true" />
			<slot />
		</div>
		<NotificationsPanel :open="notificationsOpen" @close="notificationsOpen = false" />
	</div>
</template>
