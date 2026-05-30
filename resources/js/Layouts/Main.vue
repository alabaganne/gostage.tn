<template>
	<div class="content" :class="maxWidthClass">
		<div v-if="title" class="page-head">
			<div>
				<span class="eyebrow">{{ subtitle }}</span>
				<h1>{{ title }}</h1>
				<p v-if="$slots.description"><slot name="description" /></p>
			</div>
			<div><slot name="header-right" /></div>
		</div>
		<slot :key="routeUrl()" />
	</div>
</template>

<script>
export default {
	props: { title: String, subtitle: { type: String, default: 'Page' }, maxWidthClass: String }
}
</script>
