<template>
	<public-layout v-if="!currentUser">
		<section class="bg-white border-b border-gray-200">
			<div class="max-w-7xl mx-auto px-6 py-12 lg:py-16">
				<div class="max-w-3xl">
					<div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-semibold border border-blue-100">Public internship board</div>
					<h1 class="mt-5 text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900">Find your next internship on Internly.</h1>
					<p class="mt-5 text-lg text-gray-600 leading-8">Browse real internship opportunities from companies, filter by field or city, and create a free account when you're ready to apply.</p>
				</div>
			</div>
		</section>
		<section class="max-w-7xl mx-auto px-6 py-8">
			<internships-content
				:internships="internships"
				:fields="fields"
				:cities="cities"
				:companies="companies"
				:filters="filters"
			/>
		</section>
	</public-layout>
	<main-layout v-else title="Internships" subtitle="View">
		<template v-slot:header-right>
			<inertia-link
				v-if="currentUser.userable_type === 'company'"
				:href="route('internships.create')"
				class="btn btn-lg btn-primary"
			>
				Add Internship ->
			</inertia-link>
		</template>
		<internships-content
			:internships="internships"
			:fields="fields"
			:cities="cities"
			:companies="companies"
			:filters="filters"
		/>
	</main-layout>
</template>

<script>
import MainLayout from "@/Layouts/Main";
import PublicLayout from "@/Layouts/Public";
import InternshipCard from "@/Components/Internship/Card";
import Pagination from "@/Components/Pagination";
import Filters from "./Filters";

const InternshipsContent = {
	components: { InternshipCard, Pagination, Filters },
	props: {
		internships: Object,
		fields: Array,
		cities: Array,
		companies: Array,
		filters: Object,
	},
	template: `
		<div class="flex flex-col 2xl:flex-row gap-x-6">
			<filters v-bind="{ fields, cities, companies, filters }" />
			<div class="flex-1">
				<div class="space-y-6">
					<template v-for="internship in internships.data" :key="internship.id">
						<internship-card :internship="internship" />
					</template>
				</div>
				<pagination v-if="internships.data.length > 0" :meta="internships.meta" :links="internships.meta.links" :routeParams="filters" class="mt-4" />
				<card v-else class="p-6">No internships found.</card>
			</div>
		</div>
	`
};

export default {
	components: {
		MainLayout,
		PublicLayout,
		InternshipsContent,
	},
	props: {
		internships: Object,
		fields: Array,
		cities: Array,
		companies: Array,
		filters: Object,
	},
}
</script>
