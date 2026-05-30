<template>
	<button :type="type" class="in-btn in-btn-primary uppercase tracking-wide text-xs" :class="$attrs.class">
		<slot />
	</button>
</template>

<script>
	export default {
		inheritAttrs: false,
		props: {
			type: {
				type: String,
				default: 'submit',
			},
		},
	}
</script>
