<template>
	<div class="inline-flex items-center" :class="stacked ? 'flex-col text-center' : ''">
		<div
			class="flex items-center justify-center rounded-xl font-black tracking-tight select-none"
			:class="[
				sizeClasses,
				dark ? 'bg-white text-gray-900' : 'bg-gray-900 text-white'
			]"
		>
			<span>in</span>
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
				sm: 'h-8 w-8 text-sm rounded-lg',
				md: 'h-10 w-10 text-base',
				lg: 'h-16 w-16 text-2xl rounded-2xl',
			}[this.size] || 'h-10 w-10 text-base';
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
