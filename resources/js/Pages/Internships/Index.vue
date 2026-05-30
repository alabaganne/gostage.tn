<template>
	<public-layout v-if="!currentUser">
		<section class="bg-white border-b border-gray-100">
			<div class="in-wrap py-14 lg:py-20">
				<div class="max-w-3xl">
					<div class="in-pill"><span class="in-pill-dot"></span> Public internship board</div>
					<h1 class="in-display mt-5 text-4xl md:text-6xl font-bold leading-tight">Find internships that match your skills.</h1>
					<p class="mt-5 text-lg text-gray-600 leading-8">Browse real opportunities, filter by city or field, and create a free account when you're ready to apply.</p>
					<div class="mt-7 flex flex-col sm:flex-row gap-3">
						<inertia-link :href="route('register')" class="in-btn in-btn-primary">Create free account</inertia-link>
						<inertia-link :href="route('login')" class="in-btn in-btn-ghost">Login</inertia-link>
					</div>
				</div>
			</div>
		</section>
		<section class="in-wrap py-8 lg:py-10">
			<internships-content v-bind="contentProps" />
		</section>
	</public-layout>

	<main-layout v-else title="Internships" subtitle="Browse roles" max-width-class="in-dashboard-main">
		<template v-slot:header-right>
			<inertia-link v-if="currentUser.userable_type === 'company'" :href="route('internships.create')" class="in-btn in-btn-primary">Add internship</inertia-link>
		</template>
		<internships-content v-bind="contentProps" />
	</main-layout>
</template>

<script>
import MainLayout from '@/Layouts/Main'
import PublicLayout from '@/Layouts/Public'
import InternshipCard from '@/Components/Internship/Card'
import Pagination from '@/Components/Pagination'
import Filters from './Filters'

const InternshipsContent = {
	components: { InternshipCard, Pagination, Filters },
	props: { internships: Object, fields: Array, cities: Array, companies: Array, filters: Object },
	template: `
		<div class="flex flex-col 2xl:flex-row gap-6">
			<filters v-bind="{ fields, cities, companies, filters }" />
			<div class="flex-1 min-w-0">
				<div class="mb-5 flex flex-col md:flex-row md:items-end md:justify-between gap-3">
					<div>
						<div class="text-sm font-bold uppercase tracking-widest text-gray-400">Open roles</div>
						<h2 class="in-heading text-2xl font-bold">{{ internships.meta.total }} internships available</h2>
					</div>
					<div class="text-sm text-gray-500">Showing curated roles from verified companies</div>
				</div>
				<div class="space-y-4">
					<internship-card v-for="internship in internships.data" :key="internship.id" :internship="internship" />
				</div>
				<pagination v-if="internships.data.length > 0" :meta="internships.meta" :links="internships.meta.links" :routeParams="filters" class="mt-5" />
				<div v-else class="in-card p-8 text-gray-600">No internships found.</div>
			</div>
		</div>`
}

export default {
	components: { MainLayout, PublicLayout, InternshipsContent },
	props: { internships: Object, fields: Array, cities: Array, companies: Array, filters: Object },
	computed: {
		contentProps() { return { internships: this.internships, fields: this.fields, cities: this.cities, companies: this.companies, filters: this.filters } }
	}
}
</script>
