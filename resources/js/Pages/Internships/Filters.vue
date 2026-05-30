<template>
	<div class="flex-shrink-0 2xl:w-96 order-2 2xl:order-first mt-6 2xl:mt-0">
		<div class="in-filter-panel">
			<div class="p-5 border-b border-gray-100">
				<h3 class="in-heading text-lg font-bold">Filters</h3>
				<p class="mt-1 text-sm text-gray-500">Find roles by title, field, company, or city.</p>
			</div>
			<form @submit.prevent="filter" autocomplete="off" class="p-5 border-b border-gray-100">
				<label for="search-internships" class="in-label">Search</label>
				<div class="flex gap-2">
					<input type="text" class="in-input" id="search-internships" v-model="search" placeholder="Search internships" />
					<button class="in-btn in-btn-primary" type="submit">Search</button>
				</div>
			</form>
			<filter-group title="Fields of Study" :items="fields" v-model="selected.fields" />
			<filter-group v-if="companies.length" title="Companies" :items="companies" v-model="selected.companies" />
			<filter-group title="Cities" :items="cities" v-model="selected.cities" />
			<div class="p-5 border-t border-gray-100">
				<button @click="reset" type="button" class="in-btn in-btn-ghost in-btn-block">Reset filters</button>
			</div>
		</div>
	</div>
</template>

<script>
import { throttle } from 'lodash'

const FilterGroup = {
	props: ['title', 'items', 'modelValue'],
	emits: ['update:modelValue'],
	methods: {
		toggle(id, checked) {
			const current = Array.isArray(this.modelValue) ? [...this.modelValue] : []
			const next = checked ? [...new Set([...current, id])] : current.filter(value => value !== id)
			this.$emit('update:modelValue', next)
		},
	},
	template: `
		<div class="p-5 border-b border-gray-100">
			<div class="in-label">{{ title }}</div>
			<div class="mt-3 space-y-2">
				<template v-for="item in items" :key="item.id">
					<label v-if="item.internships_count > 0" class="flex justify-between items-center gap-3 text-sm text-gray-700">
						<span class="flex items-center gap-2"><input type="checkbox" :value="item.id" :checked="(modelValue || []).includes(item.id)" @change="toggle(item.id, $event.target.checked)" />{{ item.name }}</span>
						<span class="in-tag in-tag-blue">{{ item.internships_count }}</span>
					</label>
				</template>
				<div v-if="!items.filter(el => el.internships_count !== 0).length" class="text-gray-500 text-sm">No filters found.</div>
			</div>
		</div>`
}

export default {
	components: { FilterGroup },
	props: { fields: Array, cities: Array, companies: Array, filters: Object },
	emits: ['filter'],
	data() {
		return { selected: { fields: this.filters.fields || [], cities: this.filters.cities || [], companies: this.filters.companies || [] }, search: this.filters.search }
	},
	watch: {
		selected: { handler() { this.filter() }, deep: true },
		search: { handler: throttle(function () { this.filter() }, 650) }
	},
	methods: {
		filter() {
			this.$inertia.get(this.route('internships.index'), { ...this.selected, search: this.search }, { preserveState: true, preserveScroll: true, replace: true })
			this.$emit('filter', this.selected)
		},
		reset() { this.$inertia.get(this.route('internships.index')) },
	},
}
</script>
