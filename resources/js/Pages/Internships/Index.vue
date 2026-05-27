<template>
	<public-layout v-if="!currentUser">
		<section class="relative overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-cyan-500 text-white">
			<div class="absolute inset-0 opacity-20">
				<div class="absolute -top-24 -right-20 h-72 w-72 rounded-full bg-white blur-3xl"></div>
				<div class="absolute bottom-0 left-10 h-48 w-48 rounded-full bg-cyan-200 blur-3xl"></div>
			</div>
			<div class="relative max-w-7xl mx-auto px-6 py-16 lg:py-20">
				<div class="max-w-4xl">
					<div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/15 text-white text-sm font-semibold border border-white/25 shadow-sm backdrop-blur">Public internship board</div>
					<h1 class="mt-6 text-4xl md:text-6xl font-extrabold tracking-tight leading-tight text-white">Find your next internship on Internly.</h1>
					<p class="mt-6 text-lg md:text-xl text-blue-50 leading-8 max-w-3xl">Browse real internship opportunities from companies, filter by field or city, and create a free account when you're ready to apply.</p>
					<div class="mt-8 flex flex-col sm:flex-row gap-3">
						<inertia-link :href="route('register')" class="px-5 py-3 rounded-xl bg-white text-blue-700 font-bold text-center shadow-lg hover:bg-blue-50 transition">Create free account</inertia-link>
						<inertia-link :href="route('login')" class="px-5 py-3 rounded-xl bg-blue-900/25 text-white font-bold text-center border border-white/25 hover:bg-blue-900/35 transition">Login</inertia-link>
					</div>
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
