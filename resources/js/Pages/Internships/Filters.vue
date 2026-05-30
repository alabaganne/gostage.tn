<template>
	<aside class="filters">
		<div class="fhead"><b>Filters</b><a href="#" @click.prevent="reset">Clear all</a></div>
		<filter-group title="Fields" :items="fields" v-model="selected.fields" />
		<filter-group v-if="companies.length" title="Companies" :items="companies" v-model="selected.companies" />
		<filter-group title="Cities" :items="cities" v-model="selected.cities" />
		<div class="fgroup"><h4>Minimum pay</h4><div class="range"><input type="range" min="0" max="40" value="20"><b>$20</b></div></div>
	</aside>
</template>

<script>
import { throttle } from 'lodash'
const FilterGroup = { props: ['title','items','modelValue'], emits: ['update:modelValue'], methods: { toggle(id, checked) { const current = Array.isArray(this.modelValue) ? [...this.modelValue] : []; this.$emit('update:modelValue', checked ? [...new Set([...current, id])] : current.filter(v => v !== id)) } }, template: `<div class="fgroup"><h4>{{ title }}</h4><template v-for="item in items" :key="item.id"><label v-if="item.internships_count > 0" class="check"><input type="checkbox" :checked="(modelValue || []).includes(item.id)" @change="toggle(item.id, $event.target.checked)"> {{ item.name }} <span class="cnt">{{ item.internships_count }}</span></label></template></div>` }
export default { components: { FilterGroup }, props: { fields: Array, cities: Array, companies: Array, filters: Object }, emits: ['filter'], data() { return { selected: { fields: this.filters.fields || [], cities: this.filters.cities || [], companies: this.filters.companies || [] }, search: this.filters.search } }, watch: { selected: { handler() { this.filter() }, deep: true }, search: { handler: throttle(function () { this.filter() }, 650) } }, methods: { filter() { this.$inertia.get(this.route('internships.index'), { ...this.selected, search: this.search }, { preserveState: true, preserveScroll: true, replace: true }); this.$emit('filter', this.selected) }, reset() { this.$inertia.get(this.route('internships.index')) } } }
</script>
