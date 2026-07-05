<template>
	<!-- Text-only brand until a real logo is ready. -->
	<div class="inline-flex items-center" :class="stacked ? 'flex-col text-center' : ''">
		<div v-if="showText">
			<div :class="[titleClasses, dark ? 'text-white' : 'text-gray-900']">Internly</div>
			<div v-if="tagline" :class="[taglineClasses, dark ? 'text-gray-300' : 'text-gray-500']">{{ tagline }}</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		showText: { type: Boolean, default: true },
		tagline: { type: String, default: '' },
		dark: { type: Boolean, default: false },
		stacked: { type: Boolean, default: false },
		size: { type: String, default: 'md' },
	},
	computed: {
		titleClasses() {
			return this.size === 'lg' ? 'text-2xl font-extrabold tracking-tight' : 'text-xl font-extrabold tracking-tight';
		},
		taglineClasses() {
			return 'text-xs uppercase tracking-wide';
		},
	},
};
</script>
