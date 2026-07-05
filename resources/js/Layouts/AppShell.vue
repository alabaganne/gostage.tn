<script setup>
import AppSidebar from './AppSidebar.vue';
import AppTopbar from './AppTopbar.vue';

defineProps({
	active: { type: String, default: '' }, // 'dashboard' | 'applications' | …
	fill: { type: Boolean, default: false }, // true for full-height, internally-scrolling pages (Messages)
});
</script>

<template>
	<div class="grid grid-cols-[248px_1fr] bg-paper-2" :class="fill ? 'h-screen' : 'min-h-screen'">
		<AppSidebar :active="active" />
		<div class="flex flex-col min-w-0" :class="{ 'overflow-hidden': fill }">
			<AppTopbar />
			<slot />
		</div>
	</div>
</template>
