<template>
	<span class="brand" :class="{ 'brand-compact': compact }">
		<span class="logo">
			<svg viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
		</span>
		<span v-if="showText"><b>Internly</b><small>{{ tagline || defaultTagline }}</small></span>
	</span>
</template>

<script>
export default {
	props: {
		showText: { type: Boolean, default: true },
		tagline: { type: String, default: '' },
		dark: { type: Boolean, default: false },
		compact: { type: Boolean, default: false },
	},
	computed: {
		defaultTagline() { return this.dark ? 'STUDENT WORKSPACE' : 'INTERNSHIP PLATFORM' }
	}
}
</script>
