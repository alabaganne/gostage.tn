<script setup>
import { computed, h } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';
import CompanyLogo from '@/Components/Ui/CompanyLogo.vue';
import { gradientFor } from '@/utils/brand';

defineOptions({
	layout: (_h, page) => h(AppShell, { active: 'companies' }, () => page),
});

const props = defineProps({
	company: { type: Object, required: true },
});

const icons = {
	chevron: '<svg viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	pin: '<svg viewBox="0 0 24 24" fill="none"><path d="M12 21s7-5.5 7-11a7 7 0 10-14 0c0 5.5 7 11 7 11z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="2"/></svg>',
	briefcase: '<svg viewBox="0 0 24 24" fill="none"><rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" stroke-width="2"/><path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2" stroke="currentColor" stroke-width="2"/></svg>',
	globe: '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M3 12h18M12 3c2.5 2.5 3.8 5.7 3.8 9s-1.3 6.5-3.8 9c-2.5-2.5-3.8-5.7-3.8-9S9.5 5.5 12 3z" stroke="currentColor" stroke-width="2"/></svg>',
	clock: '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	mail: '<svg viewBox="0 0 24 24" fill="none"><rect x="4" y="5" width="16" height="14" rx="2" stroke="currentColor" stroke-width="2"/><path d="M4 8l8 5 8-5" stroke="currentColor" stroke-width="2"/></svg>',
	phone: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 005 5L20 13l1 4v2a1 1 0 01-1 1A16 16 0 014 4a1 1 0 011-1z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	arrow: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
};

const internships = computed(() => props.company.internships?.data ?? props.company.internships ?? []);
const roleInitials = (title) =>
	title
		.split(/\s+/)
		.map((word) => word[0])
		.filter(Boolean)
		.slice(0, 2)
		.join('')
		.toUpperCase();
</script>

<template>
	<div class="px-10 pt-7 pb-14 w-full">
		<div class="flex items-center gap-2 text-[13.5px] text-muted font-medium mb-[22px] [&_svg]:w-3.5 [&_svg]:h-3.5 [&_svg]:text-muted-2">
			<Link class="hover:text-blue-700" :href="route('companies.index')">Companies</Link>
			<span class="contents" v-html="icons.chevron"></span>
			<span class="text-ink-700 font-semibold">{{ company.name }}</span>
		</div>

		<!-- BANNER -->
		<div class="relative bg-gradient-to-br from-navy-800 to-navy-900 rounded-[26px] px-[34px] py-8 overflow-hidden mb-6">
			<div class="absolute inset-0 bg-[radial-gradient(560px_240px_at_12%_-40%,rgba(59,130,246,.32),transparent_70%)]"></div>
			<div class="relative z-[1] flex items-center gap-5 flex-wrap">
				<div class="w-[78px] h-[78px] rounded-[20px] grid place-items-center text-white font-bold font-display text-[30px] shrink-0" :style="{ background: gradientFor(company.name) }">{{ company.name.slice(0, 1).toUpperCase() }}</div>
				<div>
					<h1 class="font-display text-white text-[30px] font-semibold leading-[1.1]">{{ company.name }}</h1>
					<div class="flex items-center gap-3.5 flex-wrap mt-2.5 text-[#aebfdd] text-sm [&_span]:inline-flex [&_span]:items-center [&_span]:gap-1.5 [&_svg]:w-[15px] [&_svg]:h-[15px] [&_svg]:opacity-80">
						<span v-if="company.city?.name"><span class="contents" v-html="icons.pin"></span>{{ company.city.name }}</span>
						<span v-if="company.website"><span class="contents" v-html="icons.globe"></span>{{ company.website }}</span>
					</div>
				</div>
				<div class="ml-auto flex gap-2.5 max-[760px]:ml-0 max-[760px]:w-full">
					<Link class="inline-flex items-center justify-center font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-white text-navy-900 hover:bg-[#eef2f7] transition-colors" :href="route('messages.show', company.user_id)">Message company</Link>
				</div>
			</div>
		</div>

		<div class="grid grid-cols-[1fr_320px] gap-6 items-start max-[1080px]:grid-cols-1">
			<!-- LEFT -->
			<div class="flex flex-col gap-6">
				<!-- ABOUT -->
				<section v-if="company.about" class="bg-white border border-line rounded-[18px] p-[26px]">
					<h2 class="font-display text-[18px] font-semibold mb-3">About {{ company.name }}</h2>
					<p class="text-[15px] leading-[1.72] text-ink-700 whitespace-pre-line">{{ company.about }}</p>
				</section>

				<!-- OPEN ROLES -->
				<section class="bg-white border border-line rounded-[18px]">
					<div class="flex items-center justify-between px-[26px] pt-[22px]">
						<h2 class="font-display text-[18px] font-semibold">Open internships</h2>
						<span class="text-[13px] text-muted font-semibold bg-paper-2 border border-line-2 px-[11px] py-1 rounded-full">{{ internships.length }} {{ internships.length === 1 ? 'role' : 'roles' }}</span>
					</div>
					<div class="px-3.5 pt-2.5 pb-3.5">
						<Link
							v-for="(internship, index) in internships"
							:key="internship.id"
							class="flex items-center gap-4 px-3 py-[18px] rounded-[14px] transition-colors cursor-pointer hover:bg-paper-2 no-underline"
							:class="{ 'border-t border-line-2': index !== 0 }"
							:href="route('internships.show', internship.id)"
						>
							<span class="w-[46px] h-[46px] rounded-[12px] grid place-items-center text-white font-bold font-display text-base shrink-0" :style="{ background: gradientFor(company.name) }">{{ roleInitials(internship.title) }}</span>
							<span class="flex-1 min-w-0">
								<b class="text-base font-semibold block">{{ internship.title }}</b>
								<span class="flex flex-wrap gap-3.5 mt-[7px] text-muted text-[13px] [&_span]:inline-flex [&_span]:items-center [&_span]:gap-[5px] [&_svg]:w-[13px] [&_svg]:h-[13px] [&_svg]:text-muted-2">
									<span><span class="contents" v-html="icons.pin"></span>{{ internship.city?.name }}</span>
									<span><span class="contents" v-html="icons.clock"></span>Closes {{ internship.closing_at }}</span>
								</span>
							</span>
						</Link>
						<div v-if="!internships.length" class="px-3 py-6 text-[14px] text-muted">No open roles right now.</div>
					</div>
				</section>
			</div>

			<!-- RIGHT -->
			<div class="flex flex-col gap-4 sticky top-[94px]">
				<section class="bg-white border border-line rounded-[18px] px-6 py-[22px]">
					<h3 class="text-sm tracking-[.04em] text-muted font-bold font-display mb-4">OVERVIEW</h3>
					<div class="flex gap-3">
						<div class="flex-1 text-center bg-paper-2 border border-line-2 rounded-[12px] px-2 py-4">
							<div class="font-display text-2xl font-semibold leading-none">{{ internships.length }}</div>
							<div class="text-xs text-muted mt-1.5">Open roles</div>
						</div>
					</div>
					<Link class="w-full justify-center mt-[18px] inline-flex items-center gap-2.5 font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-blue-600 text-white hover:bg-blue-700 transition-colors [&_svg]:w-[17px] [&_svg]:h-[17px]" :href="route('internships.index', { companies: [company.id] })">
						View all roles <span class="contents" v-html="icons.arrow"></span>
					</Link>
				</section>

				<section class="bg-white border border-line rounded-[18px] px-6 py-[22px]">
					<h3 class="text-sm tracking-[.04em] text-muted font-bold font-display mb-4">CONTACT</h3>
					<div v-if="company.email" class="flex items-center gap-[13px] py-3 text-sm text-ink-700 [&_svg]:w-[17px] [&_svg]:h-[17px] [&_svg]:text-muted-2 [&_svg]:shrink-0"><span class="contents" v-html="icons.mail"></span>{{ company.email }}</div>
					<div v-if="company.website" class="flex items-center gap-[13px] py-3 text-sm text-ink-700 border-t border-line-2 [&_svg]:w-[17px] [&_svg]:h-[17px] [&_svg]:text-muted-2 [&_svg]:shrink-0"><span class="contents" v-html="icons.globe"></span><a class="text-blue-700 font-semibold" :href="company.website" target="_blank" rel="noopener">{{ company.website }}</a></div>
					<div v-if="company.phone_number" class="flex items-center gap-[13px] py-3 text-sm text-ink-700 border-t border-line-2 [&_svg]:w-[17px] [&_svg]:h-[17px] [&_svg]:text-muted-2 [&_svg]:shrink-0"><span class="contents" v-html="icons.phone"></span>{{ company.phone_number }}</div>
					<div v-if="company.city?.name" class="flex items-center gap-[13px] py-3 text-sm text-ink-700 border-t border-line-2 [&_svg]:w-[17px] [&_svg]:h-[17px] [&_svg]:text-muted-2 [&_svg]:shrink-0"><span class="contents" v-html="icons.pin"></span>{{ company.city.name }}</div>
				</section>
			</div>
		</div>
	</div>
</template>
