<template>
	<div class="p-5 md:p-8 mx-auto flex flex-1 flex-col w-full" :class="maxWidthClass || 'max-w-7xl'">
		<header v-if="title" class="mb-7 flex flex-col lg:flex-row lg:justify-between lg:items-end gap-4">
			<div>
				<div class="text-blue-700 text-xs font-extrabold uppercase tracking-widest">{{ subtitle }}</div>
				<div class="in-display mt-1 text-gray-900 text-3xl md:text-4xl font-bold">{{ title }}</div>
			</div>
			<div>
				<slot name="header-right" />
			</div>
		</header>
		<main class="flex-1">
			<slot :key="routeUrl()" />
		</main>
		<footer class="mt-8 text-gray-500 text-xs font-medium text-center">
			Designed and developed by <a href="https://www.linkedin.com/in/alabaganne/" target="_blank" class="link hover:underline">Ala Baganne</a>
		</footer>
	</div>
</template>

<script>
export default {
	props: {
		title: String,
		subtitle: { type: String, default: 'Page' },
		maxWidthClass: { type: String },
	}
}
</script>
