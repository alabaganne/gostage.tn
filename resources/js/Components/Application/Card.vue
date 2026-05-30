<template>
	<inertia-link :href="route('applications.show', application)" class="px-6 py-4 flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 group hover:bg-blue-50 transition">
		<div v-if="currentUser.userable_type === 'company'" class="lg:w-5/12 flex items-center min-w-0">
			<div class="h-14 w-14 rounded-2xl bg-blue-50 text-blue-700 grid place-items-center font-bold flex-shrink-0">{{ initials(application.student.name) }}</div>
			<div class="ml-4 min-w-0">
				<div class="text-blue-700 font-bold truncate">{{ application.student.name }}</div>
				<div class="mt-1 text-sm text-gray-500 flex items-center min-w-0">
					<icon name="mail" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
					<span class="truncate">{{ application.student.email }}</span>
				</div>
			</div>
		</div>
		<div v-else class="lg:w-5/12 min-w-0">
			<div class="text-blue-700 font-bold truncate">{{ application.internship.title }}</div>
			<div class="mt-2 text-sm text-gray-500 flex flex-wrap items-center gap-3">
				<div class="flex items-center"><icon name="office-building" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />{{ application.company.name }}</div>
				<div class="flex items-center"><icon name="location-marker" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />{{ application.internship.city.name }}</div>
			</div>
		</div>
		<div class="flex-1 text-sm">
			<div class="font-bold text-gray-900">Applied on {{ application.created_at }}</div>
			<div class="mt-2 text-gray-500 flex items-center">
				<icon v-if="application.status === null" name="clock" solid class="flex-shrink-0 mr-1 h-5 w-5 text-gray-400" />
				<icon v-else-if="application.status === true" solid name="check-circle" class="flex-shrink-0 mr-1 h-5 w-5 text-green-500" />
				<icon v-else name="x-circle" solid class="flex-shrink-0 mr-1 h-5 w-5 text-red-500" />
				{{ application.status === null ? "Awaiting review" : "Reviewed by company" }}
			</div>
		</div>
		<div class="text-lg text-blue-700 font-bold transform group-hover:translate-x-1.5 transition duration-150">→</div>
	</inertia-link>
</template>

<script>
export default {
	props: { application: { type: Object, required: true } },
	methods: {
		initials(name) { return (name || 'IN').split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase() }
	}
}
</script>
