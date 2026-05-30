<template>
	<div>
		<div class="flex flex-wrap items-center gap-2">
			<span class="in-tag in-tag-blue">{{ internship.field.name }}</span>
			<span v-if="internship.application" class="in-tag in-tag-green">Applied</span>
		</div>
		<h2 class="in-display mt-4 text-3xl sm:text-4xl font-bold leading-tight text-gray-900">{{ truncateTitle ? internship.title : truncate(internship.title, 80) }}</h2>
		<div class="mt-4 flex flex-wrap gap-3 text-sm text-gray-600">
			<div class="flex items-center"><icon name="office-building" class="mr-1.5 h-5 w-5 text-blue-500" />{{ internship.company.name }}</div>
			<div class="flex items-center"><icon name="location-marker" class="mr-1.5 h-5 w-5 text-blue-500" />{{ internship.city.name }}</div>
			<div v-if="full" class="flex items-center"><icon name="clock" class="mr-1.5 h-5 w-5 text-blue-500" />Posted {{ internship.created_at }}</div>
			<div class="flex items-center"><icon name="calendar" class="mr-1.5 h-5 w-5 text-blue-500" />Closing {{ internship.closing_at }}</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		internship: { type: Object, required: true },
		full: { type: Boolean, default: true },
		truncateTitle: { type: Boolean, default: false },
	}
}
</script>
