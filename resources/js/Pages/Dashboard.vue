<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';
import CompanyLogo from '@/Components/Ui/CompanyLogo.vue';
import StatusPill from '@/Components/Ui/StatusPill.vue';

defineOptions({
	layout: (h, page) => h(AppShell, { active: 'dashboard' }, () => page),
});

const props = defineProps({
	internships_count: Number,
	students_count: Number,
	companies_count: Number,
	applications_count: Number,
	applications: { type: Array, default: () => [] },
	recommended: { type: Array, default: () => [] },
});

const icons = {
	arrow: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	briefcase: '<svg viewBox="0 0 24 24" fill="none"><rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" stroke-width="2"/><path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2" stroke="currentColor" stroke-width="2"/></svg>',
	building: '<svg viewBox="0 0 24 24" fill="none"><path d="M3 21V8l7-5 7 5v13M9 21v-6h2v6M3 21h18" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	list: '<svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	chat: '<svg viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	people: '<svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="3.5" stroke="currentColor" stroke-width="2"/><path d="M2.5 20c0-3.3 2.9-5.5 6.5-5.5s6.5 2.2 6.5 5.5M16 4.6a3.5 3.5 0 010 6.8M18.6 15c1.8.8 2.9 2.3 2.9 4.9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	chevron: '<svg viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
};

const page = usePage();
const user = computed(() => page.props.auth?.user);
const firstName = computed(() => (user.value?.name || '').split(' ')[0]);
const isMember = computed(() => ['student', 'company'].includes(user.value?.userable_type));

const interviewsCount = computed(
	() => props.applications.filter((a) => ['interview', 'accepted'].includes(a.status)).length
);

const cards = computed(() =>
	[
		{
			label: 'Open internships',
			value: props.internships_count,
			icon: icons.briefcase,
			gradient: 'linear-gradient(140deg,#3b82f6,#1d4ed8)',
			href: route('internships.index'),
			show: true,
		},
		{
			label: 'Companies hiring',
			value: props.companies_count,
			icon: icons.building,
			gradient: 'linear-gradient(140deg,#6366f1,#4338ca)',
			href: route('companies.index'),
			show: true,
		},
		{
			label: 'My applications',
			value: props.applications_count,
			icon: icons.list,
			gradient: 'linear-gradient(140deg,#f59e0b,#d97706)',
			href: route('applications.index'),
			show: isMember.value,
		},
		{
			label: 'Interviews',
			value: interviewsCount.value,
			icon: icons.chat,
			gradient: 'linear-gradient(140deg,#10b981,#047857)',
			href: route('applications.index'),
			show: isMember.value,
		},
		{
			label: 'Students',
			value: props.students_count,
			icon: icons.people,
			gradient: 'linear-gradient(140deg,#10b981,#047857)',
			href: route('students.index'),
			show: !!user.value?.is_admin,
		},
	].filter((card) => card.show)
);
</script>

<template>
	<div class="px-10 pt-[34px] pb-[50px] w-full">
		<div class="flex items-end justify-between flex-wrap gap-4 mb-7">
			<div>
				<span class="block font-display text-[12.5px] font-semibold tracking-[.18em] uppercase text-blue-600 mb-2">Overview</span>
				<h1 class="font-display text-[32px] font-semibold tracking-[-.02em]">Welcome back, {{ firstName }} 👋</h1>
				<p class="text-muted text-[15px] mt-1.5">Here's what's happening with your internship search.</p>
			</div>
			<Link class="inline-flex items-center gap-2.5 font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-white text-ink border border-line hover:border-blue-300 hover:text-blue-700 transition-all [&_svg]:w-[17px] [&_svg]:h-[17px]" :href="route('internships.index')">
				Browse all roles
				<span class="contents" v-html="icons.arrow"></span>
			</Link>
		</div>

		<!-- STATS -->
		<div class="grid grid-cols-4 gap-4 mb-7 max-[1000px]:grid-cols-2">
			<div v-for="card in cards" :key="card.label" class="bg-white border border-line rounded-[18px] p-[22px]">
				<div class="flex items-center justify-between mb-[18px]">
					<div class="w-11 h-11 rounded-[12px] grid place-items-center text-white [&_svg]:w-[21px] [&_svg]:h-[21px]" :style="{ background: card.gradient }" v-html="card.icon"></div>
				</div>
				<div class="text-[12.5px] tracking-[.08em] uppercase text-muted-2 font-bold">{{ card.label }}</div>
				<div class="font-display text-[34px] font-semibold mt-1 leading-none">{{ card.value ?? 0 }}</div>
				<Link class="inline-flex items-center gap-1.5 mt-3.5 text-[13.5px] font-semibold text-blue-700 [&_svg]:w-3.5 [&_svg]:h-3.5" :href="card.href">
					View all <span class="contents" v-html="icons.arrow"></span>
				</Link>
			</div>
		</div>

		<!-- TWO COL -->
		<div class="grid grid-cols-[1.7fr_1fr] gap-4 items-start max-[980px]:grid-cols-1">
			<!-- recent applications -->
			<section class="bg-white border border-line rounded-[18px] overflow-hidden">
				<div class="flex items-center justify-between px-[22px] py-5 border-b border-line-2">
					<div>
						<h3 class="font-display text-[17px] font-semibold">Recent applications</h3>
						<p class="text-[13px] text-muted mt-0.5">Track the status of every role you've applied to.</p>
					</div>
					<Link class="text-[13.5px] font-semibold text-blue-700" :href="route('applications.index')">View all</Link>
				</div>

				<Link
					v-for="(application, index) in applications"
					:key="application.id"
					class="flex items-center gap-[15px] px-[22px] py-4 transition-colors hover:bg-paper-2"
					:class="{ 'border-b border-line-2': index !== applications.length - 1 }"
					:href="route('applications.show', application.id)"
				>
					<CompanyLogo class="w-11 h-11 rounded-[11px] text-[15px]" :name="application.company?.name || application.student?.name" />
					<div class="flex-1 min-w-0">
						<b class="text-[15px] font-semibold block">{{ application.internship.title }}</b>
						<span class="text-[13px] text-muted">{{ application.company?.name || application.student?.name }} · {{ application.internship.city?.name }}</span>
					</div>
					<StatusPill :status="application.status" />
					<div class="text-[13px] text-muted-2 text-right whitespace-nowrap">{{ application.created_at }}</div>
					<div class="w-[34px] h-[34px] rounded-[9px] border border-line grid place-items-center text-muted-2 shrink-0 [&_svg]:w-4 [&_svg]:h-4" v-html="icons.chevron"></div>
				</Link>

				<div v-if="!applications.length" class="px-[22px] py-8 text-[14px] text-muted">
					No applications yet.
					<Link class="font-semibold text-blue-700" :href="route('internships.index')">Browse internships</Link>
					to get started.
				</div>
			</section>

			<!-- right column -->
			<div class="flex flex-col gap-4">
				<!-- recommended -->
				<section v-if="recommended.length" class="bg-white border border-line rounded-[18px] overflow-hidden">
					<div class="flex items-center justify-between px-[22px] py-5 border-b border-line-2">
						<div><h3 class="font-display text-[17px] font-semibold">Recommended for you</h3></div>
						<Link class="text-[13.5px] font-semibold text-blue-700" :href="route('internships.index')">More</Link>
					</div>
					<div class="py-2">
						<Link
							v-for="item in recommended"
							:key="item.id"
							class="flex items-center gap-3 px-[22px] py-[13px] transition-colors hover:bg-paper-2"
							:href="route('internships.show', item.id)"
						>
							<CompanyLogo class="w-10 h-10 rounded-[10px] text-[13px]" :name="item.company" />
							<div>
								<b class="text-sm font-semibold block">{{ item.title }}</b>
								<span class="text-[12.5px] text-muted">{{ item.company }} · {{ item.city }}</span>
							</div>
							<span v-if="item.match" class="ml-auto text-xs font-bold text-blue-700 bg-blue-50 px-[9px] py-1 rounded-[7px] whitespace-nowrap">{{ item.match }}%</span>
						</Link>
					</div>
				</section>
			</div>
		</div>
	</div>
</template>
