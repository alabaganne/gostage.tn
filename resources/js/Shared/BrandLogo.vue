<template>
	<div class="inline-flex items-center" :class="stacked ? 'flex-col text-center' : ''">
		<div
			class="flex items-center justify-center rounded-xl select-none"
			:class="[
				sizeClasses,
				dark ? 'bg-white text-gray-900' : 'bg-gray-900 text-white'
			]"
		>
			<svg viewBox="0 0 32 32" fill="none" aria-hidden="true" class="h-3/5 w-3/5">
				<path d="M8 21.5L14 15.5L18.5 19.5L24.5 10.5" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
				<circle cx="8" cy="21.5" r="2.5" fill="currentColor" />
				<circle cx="14" cy="15.5" r="2.5" fill="currentColor" />
				<circle cx="18.5" cy="19.5" r="2.5" fill="currentColor" />
				<circle cx="24.5" cy="10.5" r="2.5" fill="currentColor" />
			</svg>
		</div>
		<div v-if="showText" :class="stacked ? 'mt-3' : 'ml-3'">
			<div :class="[titleClasses, dark ? 'text-white' : 'text-gray-900']">Internly</div>
			<div v-if="tagline" :class="[taglineClasses, dark ? 'text-gray-300' : 'text-gray-500']">{{ tagline }}</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		showText: {
			type: Boolean,
			default: true,
		},
		tagline: {
			type: String,
			default: '',
		},
		size: {
			type: String,
			default: 'md',
		},
		dark: {
			type: Boolean,
			default: false,
		},
		stacked: {
			type: Boolean,
			default: false,
		},
	},
	computed: {
		sizeClasses() {
			return {
				sm: 'h-8 w-8 rounded-lg',
				md: 'h-10 w-10',
				lg: 'h-16 w-16 rounded-2xl',
			}[this.size] || 'h-10 w-10';
		},
		titleClasses() {
			return this.size === 'lg' ? 'text-2xl font-extrabold tracking-tight' : 'text-xl font-extrabold tracking-tight';
		},
		taglineClasses() {
			return 'text-xs uppercase tracking-wide';
		},
	},
};
</script>
