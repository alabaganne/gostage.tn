<script setup>
import { computed, h, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';
import CompanyLogo from '@/Components/Ui/CompanyLogo.vue';
import Pagination from '@/Components/Ui/Pagination.vue';

defineOptions({
	layout: (_h, page) => h(AppShell, { active: 'companies' }, () => page),
});

const props = defineProps({
	companies: Object, // plain paginator: { data, links, current_page, ... }
});

const icons = {
	search: '<svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3-3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	pin: '<svg viewBox="0 0 24 24" fill="none"><path d="M12 21s7-5.5 7-11a7 7 0 10-14 0c0 5.5 7 11 7 11z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="2"/></svg>',
	mail: '<svg viewBox="0 0 24 24" fill="none"><rect x="4" y="5" width="16" height="14" rx="2" stroke="currentColor" stroke-width="2"/><path d="M4 8l8 5 8-5" stroke="currentColor" stroke-width="2"/></svg>',
};

const query = ref('');
const filter = ref('all');

const chips = [
	{ key: 'all', label: 'All companies' },
	{ key: 'hiring', label: 'Actively hiring' },
];

const visible = computed(() =>
	props.companies.data.filter((company) => {
		const term = query.value.trim().toLowerCase();
		const matchesTerm =
			!term ||
			company.name.toLowerCase().includes(term) ||
			(company.city?.name || '').toLowerCase().includes(term);
		const matchesFilter = filter.value === 'all' || company.internships_count > 0;
		return matchesTerm && matchesFilter;
	})
);

// The controller uses a plain paginator, so pagination fields sit at the top level.
const meta = computed(() => props.companies.meta ?? props.companies);
</script>

<template>
	<div class="px-10 pt-[34px] pb-14 w-full">
		<div class="mb-6">
			<span class="block font-display text-[12.5px] font-semibold tracking-[.18em] uppercase text-blue-600 mb-2">Directory</span>
			<h1 class="font-display text-[32px] font-semibold tracking-[-.02em]">Companies</h1>
			<p class="text-muted text-[15px] mt-1.5">Explore the companies hiring on Internly and the roles they have open right now.</p>
		</div>

		<!-- TOOLBAR -->
		<div class="flex items-center gap-3.5 mb-[22px] flex-wrap">
			<label class="flex items-center gap-2.5 bg-white border border-line rounded-[12px] px-3.5 h-[46px] flex-1 min-w-[240px] focus-within:border-blue-400 [&_svg]:w-[18px] [&_svg]:h-[18px] [&_svg]:text-muted-2 [&_svg]:shrink-0">
				<span class="contents" v-html="icons.search"></span>
				<input v-model="query" class="border-0 bg-transparent outline-none text-[14.5px] w-full" type="text" placeholder="Filter by company name or city…">
			</label>
			<div class="flex gap-2 flex-wrap">
				<button
					v-for="chip in chips"
					:key="chip.key"
					class="chip inline-flex items-center gap-[7px] h-[46px] px-4 rounded-[12px] border text-[13.5px] font-semibold cursor-pointer transition-colors"
					:class="{ 'is-active': filter === chip.key }"
					type="button"
					@click="filter = chip.key"
				>{{ chip.label }}</button>
			</div>
		</div>

		<p class="text-[13.5px] text-muted font-medium mb-4"><b class="text-ink-700 font-bold">{{ visible.length }}</b> of {{ companies.data.length }} companies</p>

		<!-- GRID -->
		<div class="grid grid-cols-3 gap-[18px] max-[1180px]:grid-cols-2 max-[760px]:grid-cols-1">
			<article
				v-for="company in visible"
				:key="company.id"
				class="bg-white border border-line rounded-[18px] p-6 flex flex-col transition-all hover:border-blue-300 hover:-translate-y-[3px]"
			>
				<div class="flex items-start gap-3.5">
					<CompanyLogo class="w-[52px] h-[52px] rounded-[14px] text-[19px]" :name="company.name" />
					<div class="flex-1 min-w-0">
						<h3 class="font-display text-[18px] font-semibold leading-[1.2]">{{ company.name }}</h3>
						<span class="inline-flex items-center gap-[5px] text-[13px] text-muted mt-[5px] [&_svg]:w-[13px] [&_svg]:h-[13px] [&_svg]:text-muted-2"><span class="contents" v-html="icons.pin"></span>{{ company.city?.name }}</span>
					</div>
					<span v-if="company.internships_count" class="ml-auto text-xs font-bold text-blue-700 bg-blue-50 px-[11px] py-[5px] rounded-full whitespace-nowrap">{{ company.internships_count }} open</span>
				</div>
				<div class="flex flex-col gap-[9px] mt-[18px] pt-4 border-t border-line-2 flex-1">
					<div class="flex items-center gap-2.5 text-[13px] text-ink-700 [&_svg]:w-[15px] [&_svg]:h-[15px] [&_svg]:text-muted-2 [&_svg]:shrink-0"><span class="contents" v-html="icons.mail"></span>{{ company.email }}</div>
				</div>
				<div class="flex gap-2.5 mt-[18px]">
					<Link class="flex-1 justify-center h-[42px] inline-flex items-center font-semibold text-[15px] rounded-[12px] bg-blue-600 text-white hover:bg-blue-700 transition-colors" :href="route('companies.show', company.id)">View</Link>
					<Link class="flex-1 justify-center h-[42px] inline-flex items-center font-semibold text-[15px] rounded-[12px] bg-paper-2 border border-line text-ink-700 hover:border-blue-300 hover:text-blue-700 transition-colors" :href="route('messages.show', company.user_id)">Message</Link>
				</div>
			</article>
		</div>

		<div v-if="!visible.length" class="text-center py-[60px] text-muted">No companies match your filters.</div>

		<Pagination :meta="meta" />
	</div>
</template>
