<template>
	<div class="in-card overflow-hidden" :class="$attrs.class">
		<div v-if="title" class="in-panel-header flex justify-between items-start gap-4">
			<div>
				<h3 class="in-heading text-lg font-bold text-gray-900">{{ title }}</h3>
				<p v-if="subtitle" class="mt-1 max-w-2xl text-sm text-gray-500 leading-6">{{ subtitle }}</p>
			</div>
			<div>
				<slot name="header-right" />
			</div>
		</div>
		<slot />
		<div v-if="$slots['footer']" class="px-6 py-4 bg-gray-50 border-t border-gray-100">
			<slot name="footer" />
		</div>
	</div>
</template>

<script>
export default {
	inheritAttrs: false,
	props: {
		title: String,
		subtitle: String,
	}
}
</script>
