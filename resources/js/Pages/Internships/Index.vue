<template>
	<public-layout v-if="!currentUser">
		<section class="hero" style="padding:54px 0 42px"><div class="wrap"><div><span class="pill"><span class="dot"></span> Public internship board</span><h1>Find internships that match your skills.</h1><p class="lede">Browse verified opportunities, filter by field or city, and create an account when you're ready to apply.</p></div></div></section>
		<section class="section" style="padding-top:34px"><div class="wrap"><internships-content v-bind="contentProps" public-mode /></div></section>
	</public-layout>
	<main-layout v-else title="Internships" subtitle="Explore">
		<template #description>250 open roles from verified companies. Filter to find the ones built for you.</template>
		<template #header-right><inertia-link v-if="currentUser.userable_type === 'company'" :href="route('internships.create')" class="btn btn-primary">Post role</inertia-link></template>
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
	props: { internships: Object, fields: Array, cities: Array, companies: Array, filters: Object, publicMode: Boolean },
	template: `
		<div>
			<div class="searchbar">
				<div class="field"><icon name="search" /><input type="text" placeholder="Role, company, or keyword" :value="filters.search" @keyup.enter="$inertia.get(route('internships.index'), { ...filters, search: $event.target.value })"></div>
				<div class="field" style="max-width:230px"><icon name="location-marker" /><input type="text" placeholder="Location or remote"></div>
				<button class="btn btn-primary" style="height:50px;padding:0 26px">Search</button>
			</div>
			<div class="qtabs"><button class="active">All roles</button><button>Engineering</button><button>Design</button><button>Data</button><button>Marketing</button><button>Product</button></div>
			<div class="browse-grid">
				<filters v-bind="{ fields, cities, companies, filters }" />
				<main><div class="res-head"><div class="cnt"><b>{{ internships.meta.total }}</b> internships found</div><div class="sortby">Sort by <select><option>Best match</option><option>Most recent</option><option>Highest pay</option><option>Closing soon</option></select></div></div><div class="rlist"><internship-card v-for="internship in internships.data" :key="internship.id" :internship="internship" /></div><pagination v-if="internships.data.length" :meta="internships.meta" :links="internships.meta.links" :routeParams="filters" class="mt-5" /><div v-else class="panel" style="padding:28px">No internships found.</div></main>
			</div>
		</div>`
}

export default { components: { MainLayout, PublicLayout, InternshipsContent }, props: { internships: Object, fields: Array, cities: Array, companies: Array, filters: Object }, computed: { contentProps() { return { internships: this.internships, fields: this.fields, cities: this.cities, companies: this.companies, filters: this.filters } } } }
</script>
