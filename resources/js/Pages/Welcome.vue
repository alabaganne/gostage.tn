<script setup>
import { h } from 'vue';
import { Link } from '@inertiajs/vue3';
import MarketingLayout from '@/Layouts/MarketingLayout.vue';
import CompanyLogo from '@/Components/Ui/CompanyLogo.vue';

defineOptions({
	layout: (_h, page) => h(MarketingLayout, {}, () => page),
});

const props = defineProps({
	featured: { type: Array, default: () => [] },
	stats: { type: Object, default: () => ({}) },
});

const icons = {
	arrow: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	search: '<svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3-3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	check: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	star: '<svg viewBox="0 0 24 24" fill="none"><path d="M12 3l2.5 6.5L21 11l-6.5 2.5L12 20l-2.5-6.5L3 11l6.5-1.5z" fill="currentColor"/></svg>',
	bookmark: '<svg viewBox="0 0 24 24" fill="none"><path d="M6 4h12v16l-6-4-6 4z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	doc: '<svg viewBox="0 0 24 24" fill="none"><path d="M14 2v6h6M8 13h8M8 17h5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M6 2h8l6 6v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	track: '<svg viewBox="0 0 24 24" fill="none"><path d="M3 12l4 4 6-9M14 13l2 2 5-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	plus: '<svg viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>',
};

const steps = [
	{ icon: icons.search, title: 'Discover roles', body: 'Search and filter verified internships by field, location, and start date — surfaced to match your profile.' },
	{ icon: icons.doc, title: 'Apply in minutes', body: 'Build your profile once and apply with a single click. Reuse your details, attach your portfolio, and skip repetitive forms.' },
	{ icon: icons.track, title: 'Track & connect', body: "Follow every application's status in real time and message recruiters directly when companies want to move forward." },
];

const faqs = [
	{ q: 'Is Internly free for students?', a: 'Yes — completely free. Students can create a profile, browse every internship, apply to as many roles as they like, and track applications at no cost. We never charge candidates.' },
	{ q: 'How do companies post an internship?', a: 'Create a company account, fill in the role details, requirements, and compensation, then publish. Your listing goes live immediately and appears in relevant student searches. Most teams post their first role in under five minutes.' },
	{ q: 'Are the internships verified?', a: "Every company is reviewed before their listings go public, and we monitor postings for quality. We highlight clear start dates and transparent requirements so you always know what you're applying to." },
	{ q: 'Can I track all my applications in one place?', a: 'Absolutely. Your dashboard shows the live status of every application — submitted, viewed, in review, or interview — so you never have to dig through your inbox to know where you stand.' },
	{ q: 'Do you offer remote and international internships?', a: "Yes. You can filter by location, and many companies on Internly hire globally, so you'll find opportunities far beyond your immediate area." },
];
</script>

<template>
	<!-- ============ HERO ============ -->
	<section class="relative overflow-hidden pt-16 pb-24 bg-[radial-gradient(1100px_520px_at_78%_-8%,#eef4ff,transparent_60%),linear-gradient(180deg,#fff,#f6f8fc)]">
		<div class="absolute inset-0 opacity-70 [background-image:linear-gradient(#eef1f6_1px,transparent_1px),linear-gradient(90deg,#eef1f6_1px,transparent_1px)] [background-size:54px_54px] [mask-image:radial-gradient(720px_460px_at_70%_8%,#000,transparent_75%)] [-webkit-mask-image:radial-gradient(720px_460px_at_70%_8%,#000,transparent_75%)]"></div>
		<div class="relative max-w-wrap mx-auto px-7 grid grid-cols-[1.05fr_.95fr] gap-14 items-center max-[940px]:grid-cols-1 max-[940px]:gap-[60px]">
			<div v-reveal>
				<span class="inline-flex items-center gap-2 px-3.5 py-[7px] rounded-full text-[13px] font-semibold bg-blue-50 text-blue-700 border border-blue-100"><span class="w-[7px] h-[7px] rounded-full bg-blue-500 shadow-[0_0_0_4px_rgba(59,130,246,.18)]"></span> {{ stats.internships }} open internships right now</span>
				<h1 class="font-display font-semibold tracking-[-.02em] leading-[1.04] text-[clamp(40px,5.4vw,68px)] my-[22px]">Launch your career with the <span class="bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">right internship.</span></h1>
				<p class="text-[18.5px] text-muted max-w-[520px] leading-[1.62]">Internly connects ambitious students with companies that are hiring. Discover roles that match your skills, apply in minutes, and track every application from one clean workspace.</p>
				<div class="flex gap-3.5 mt-8 mb-[26px] flex-wrap">
					<Link class="inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-blue-600 text-white shadow-cta hover:bg-blue-700 hover:-translate-y-px transition-all [&_svg]:w-[17px] [&_svg]:h-[17px]" :href="route('internships.index')">
						Browse internships <span class="contents" v-html="icons.arrow"></span>
					</Link>
					<Link class="inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-white text-ink border border-line hover:border-blue-300 hover:text-blue-700 hover:-translate-y-px transition-all" :href="route('register')">Post a role — for companies</Link>
				</div>
				<div class="flex items-center gap-[22px] text-muted text-sm font-medium">
					<div class="flex">
						<span v-for="(letter, index) in ['A', 'M', 'K', '+']" :key="letter" class="w-[34px] h-[34px] rounded-full border-[2.5px] border-white bg-gradient-to-br from-blue-300 to-blue-600 grid place-items-center text-white font-bold text-xs font-display" :class="{ '-ml-[11px]': index !== 0 }">{{ letter }}</span>
					</div>
					<div><div class="text-[#f5a623] tracking-[1px]">★★★★★</div><div>Trusted by {{ stats.students }}+ students</div></div>
				</div>
			</div>

			<!-- product mockup -->
			<div v-reveal class="relative max-[940px]:max-w-[520px] max-[940px]:mx-auto">
				<div class="absolute -inset-y-[8%] -inset-x-[8%] -top-[12%] bg-[radial-gradient(closest-side,rgba(59,130,246,.28),transparent)] blur-[20px] z-0"></div>
				<div class="relative z-[1] bg-white border border-line rounded-[22px] shadow-big overflow-hidden">
					<div class="flex items-center justify-between px-[18px] py-4 border-b border-line-2 bg-paper-2">
						<div class="flex-1 flex items-center gap-2.5 bg-white border border-line rounded-[10px] px-[13px] py-[9px] text-muted-2 text-[13.5px] mr-3 [&_svg]:w-4 [&_svg]:h-4"><span class="contents" v-html="icons.search"></span> Product design internships…</div>
						<div class="flex gap-1.5"><i class="w-[9px] h-[9px] rounded-full bg-line block"></i><i class="w-[9px] h-[9px] rounded-full bg-line block"></i><i class="w-[9px] h-[9px] rounded-full bg-line block"></i></div>
					</div>
					<Link
						v-for="(internship, index) in featured.slice(0, 4)"
						:key="internship.id"
						class="flex items-center gap-3.5 px-[18px] py-[15px] hover:bg-blue-50 transition-colors"
						:class="{ 'border-b border-line-2': index !== Math.min(featured.length, 4) - 1 }"
						:href="route('internships.show', internship.id)"
					>
						<CompanyLogo class="w-[42px] h-[42px] rounded-[11px] font-display" :name="internship.company.name" />
						<div><h4 class="font-display text-[14.5px] font-semibold mb-[3px]">{{ internship.title }}</h4><p class="text-[12.5px] text-muted">{{ internship.company.name }} · {{ internship.city.name }}</p></div>
						<div class="ml-auto text-right shrink-0"><span class="block text-[11px] text-blue-600 font-semibold mt-0.5">Apply now</span></div>
					</Link>
				</div>
				<div class="absolute z-[2] bg-white border border-line rounded-[14px] shadow-card px-4 py-[13px] flex items-center gap-[11px] -top-[22px] -left-[26px] animate-[bob_5s_ease-in-out_infinite]">
					<div class="w-[38px] h-[38px] rounded-[10px] grid place-items-center text-white [&_svg]:w-[17px] [&_svg]:h-[17px]" style="background:linear-gradient(140deg,#10b981,#047857)" v-html="icons.check"></div>
					<div><b class="text-sm font-display block">Application sent</b><span class="text-[11.5px] text-muted block">Atlas Cloud · 2m ago</span></div>
				</div>
				<div class="absolute z-[2] bg-white border border-line rounded-[14px] shadow-card px-4 py-[13px] flex items-center gap-[11px] -bottom-[24px] -right-[22px] animate-[bob_5s_ease-in-out_infinite_.8s]">
					<div class="w-[38px] h-[38px] rounded-[10px] grid place-items-center text-white bg-gradient-to-br from-blue-500 to-blue-700 [&_svg]:w-[17px] [&_svg]:h-[17px]" v-html="icons.star"></div>
					<div><b class="text-sm font-display block">92% match</b><span class="text-[11.5px] text-muted block">Based on your skills</span></div>
				</div>
			</div>
		</div>
	</section>

	<!-- ============ TRUST ============ -->
	<div class="py-[30px] border-b border-line">
		<div class="max-w-wrap mx-auto px-7">
			<p class="text-center text-[12.5px] tracking-[.14em] uppercase text-muted-2 font-semibold mb-[22px]">Students placed at teams of every size</p>
			<div class="flex items-center justify-center gap-[54px] flex-wrap opacity-[.62] [&>span]:font-display [&>span]:font-bold [&>span]:text-[21px] [&>span]:text-ink-700 [&>span]:flex [&>span]:items-center [&>span]:gap-2 [&_svg]:w-[22px] [&_svg]:h-[22px] [&_svg]:text-muted">
				<span><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" stroke="currentColor" stroke-width="2"/></svg>Novabyte</span>
				<span><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="9"/></svg>Greenfield</span>
				<span><svg viewBox="0 0 24 24" fill="none"><path d="M4 12l8-8 8 8-8 8z" stroke="currentColor" stroke-width="2"/></svg>Stride Labs</span>
				<span><svg viewBox="0 0 24 24" fill="none"><path d="M3 12h18M12 3v18" stroke="currentColor" stroke-width="2"/></svg>Atlas Cloud</span>
				<span><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7z"/></svg>Lumen</span>
			</div>
		</div>
	</div>

	<!-- ============ FEATURED INTERNSHIPS ============ -->
	<section class="py-[104px]" id="internships">
		<div class="max-w-wrap mx-auto px-7">
			<div class="flex items-end justify-between gap-6 flex-wrap">
				<div v-reveal class="max-w-[680px]">
					<span class="font-display text-[12.5px] font-semibold tracking-[.18em] uppercase text-blue-600">Open roles</span>
					<h2 class="font-display font-semibold tracking-[-.02em] text-[clamp(30px,4vw,46px)] my-4">Internships worth applying to.</h2>
					<p class="text-[17px] text-muted leading-[1.6]">Hand-picked, recently posted, and open right now. New roles are added across design, engineering, data, and growth.</p>
				</div>
				<Link v-reveal class="inline-flex items-center gap-2.5 font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-white text-ink border border-line hover:border-blue-300 hover:text-blue-700 hover:-translate-y-px transition-all [&_svg]:w-[17px] [&_svg]:h-[17px]" :href="route('internships.index')">
					View all {{ stats.internships }} roles <span class="contents" v-html="icons.arrow"></span>
				</Link>
			</div>

			<div class="grid grid-cols-3 gap-5 mt-12 max-[880px]:grid-cols-1">
				<article v-for="internship in featured" :key="internship.id" class="jcard">
					<div class="flex items-start justify-between mb-4">
						<CompanyLogo class="w-12 h-12 rounded-[13px] text-lg" :name="internship.company.name" />
						<div class="w-[34px] h-[34px] rounded-[9px] border border-line grid place-items-center text-muted-2 [&_svg]:w-[18px] [&_svg]:h-[18px]" v-html="icons.bookmark"></div>
					</div>
					<h3 class="font-display text-lg font-semibold mb-[5px]">
						<Link class="hover:text-blue-700" :href="route('internships.show', internship.id)">{{ internship.title }}</Link>
					</h3>
					<p class="text-[13.5px] text-muted mb-4">{{ internship.company.name }} · {{ internship.city.name }}</p>
					<div class="flex flex-wrap gap-2 mb-[18px]">
						<span class="tag">{{ internship.field.name }}</span>
						<span v-for="skill in (internship.skills || []).slice(0, 2)" :key="skill" class="tag">{{ skill }}</span>
					</div>
					<div class="flex items-center justify-between mt-auto pt-4 border-t border-line-2">
						<div><span class="text-[12.5px] text-muted">Closes {{ internship.closing_at }}</span></div>
						<Link class="inline-flex items-center px-[11px] py-[5px] rounded-full text-[13px] font-semibold bg-blue-50 text-blue-700 border border-blue-100" :href="route('internships.show', internship.id)">Apply</Link>
					</div>
				</article>
			</div>
		</div>
	</section>

	<!-- ============ HOW IT WORKS (dark) ============ -->
	<section class="py-[104px] bg-navy-800 text-[#c6d2e8]" id="how">
		<div class="max-w-wrap mx-auto px-7">
			<div v-reveal class="max-w-[680px]">
				<span class="font-display text-[12.5px] font-semibold tracking-[.18em] uppercase text-blue-300">How it works</span>
				<h2 class="font-display font-semibold tracking-[-.02em] text-white text-[clamp(30px,4vw,46px)] my-4">From browsing to offer in three steps.</h2>
				<p class="text-[17px] text-[#9fb0ce] leading-[1.6]">Internly removes the busywork so you can focus on landing the role. No spreadsheets, no lost emails, no guessing where you stand.</p>
			</div>
			<div class="grid grid-cols-3 gap-[26px] mt-[54px] max-[880px]:grid-cols-1">
				<div v-for="(step, index) in steps" :key="step.title" v-reveal class="relative p-[30px] rounded-[18px] bg-gradient-to-b from-white/[.05] to-white/[.02] border border-white/10">
					<div class="font-display text-sm font-semibold text-navy-900 bg-blue-400 w-[38px] h-[38px] rounded-[11px] grid place-items-center mb-[22px]">{{ index + 1 }}</div>
					<div class="absolute top-[30px] right-[30px] text-white/[.16] [&_svg]:w-[30px] [&_svg]:h-[30px]" v-html="step.icon"></div>
					<h3 class="font-display text-white text-xl font-semibold mb-2.5">{{ step.title }}</h3>
					<p class="text-[#9fb0ce] text-[15px] leading-[1.6]">{{ step.body }}</p>
				</div>
			</div>
		</div>
	</section>

	<!-- ============ SPLIT ============ -->
	<section class="py-[104px]">
		<div class="max-w-wrap mx-auto px-7">
			<div v-reveal class="max-w-[680px] text-center mx-auto">
				<span class="font-display text-[12.5px] font-semibold tracking-[.18em] uppercase text-blue-600">Built for both sides</span>
				<h2 class="font-display font-semibold tracking-[-.02em] text-[clamp(30px,4vw,46px)] my-4">One platform. Two perspectives.</h2>
			</div>
			<div class="grid grid-cols-2 gap-6 mt-[52px] max-[880px]:grid-cols-1">
				<div v-reveal class="rounded-[26px] p-[42px] relative overflow-hidden bg-paper-2 border border-line">
					<span class="font-display text-xs font-semibold tracking-[.16em] uppercase text-blue-600">For students</span>
					<h3 class="font-display text-[28px] font-semibold tracking-[-.02em] my-3.5">Find the internship that fits you.</h3>
					<p class="text-base text-muted max-w-[420px] leading-[1.6]">Stop scrolling through irrelevant listings. Internly shows you roles that actually match your skills and goals.</p>
					<ul class="list-none my-[26px] mb-[30px] flex flex-col gap-3.5">
						<li v-for="benefit in ['Personalized role recommendations', 'One-click applications & saved drafts', 'Real-time application tracking']" :key="benefit" class="flex items-center gap-3 text-[15px] font-medium text-ink-700">
							<span class="w-6 h-6 rounded-[7px] bg-blue-100 text-blue-700 grid place-items-center shrink-0 [&_svg]:w-3.5 [&_svg]:h-3.5" v-html="icons.check"></span>{{ benefit }}
						</li>
					</ul>
					<Link class="inline-flex items-center gap-2.5 font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-blue-600 text-white shadow-cta hover:bg-blue-700 hover:-translate-y-px transition-all" :href="route('register')">Create student account</Link>
				</div>
				<div v-reveal class="rounded-[26px] p-[42px] relative overflow-hidden bg-gradient-to-br from-blue-600 to-blue-700 text-white">
					<span class="font-display text-xs font-semibold tracking-[.16em] uppercase text-[#bcd4ff]">For companies</span>
					<h3 class="font-display text-[28px] font-semibold tracking-[-.02em] text-white my-3.5">Hire interns without the chaos.</h3>
					<p class="text-base text-[#d4e2ff] max-w-[420px] leading-[1.6]">Publish roles, review qualified candidates, and manage your pipeline from one structured dashboard.</p>
					<ul class="list-none my-[26px] mb-[30px] flex flex-col gap-3.5">
						<li v-for="benefit in ['Post roles in under 5 minutes', 'Qualified candidate pipeline', 'Direct messaging with applicants']" :key="benefit" class="flex items-center gap-3 text-[15px] font-medium text-[#eaf1ff]">
							<span class="w-6 h-6 rounded-[7px] bg-white/[.18] text-white grid place-items-center shrink-0 [&_svg]:w-3.5 [&_svg]:h-3.5" v-html="icons.check"></span>{{ benefit }}
						</li>
					</ul>
					<Link class="inline-flex items-center gap-2.5 font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-white text-navy-900 hover:-translate-y-px hover:shadow-[0_18px_34px_-18px_rgba(0,0,0,.6)] transition-all" :href="route('register')">Post an internship</Link>
				</div>
			</div>
		</div>
	</section>

	<!-- ============ STATS ============ -->
	<section class="pt-5 pb-24">
		<div class="max-w-wrap mx-auto px-7">
			<div v-reveal class="grid grid-cols-4 gap-6 bg-white border border-line rounded-[26px] shadow-xs px-6 py-[46px] max-[680px]:grid-cols-2 max-[680px]:gap-[34px]">
				<div class="text-center p-3.5"><b class="block font-display font-semibold text-[clamp(38px,5vw,54px)] bg-gradient-to-r from-blue-500 to-blue-700 bg-clip-text text-transparent leading-none">{{ stats.students }}</b><span class="text-sm text-muted font-semibold tracking-[.04em] mt-2 block">STUDENTS</span></div>
				<div class="text-center p-3.5"><b class="block font-display font-semibold text-[clamp(38px,5vw,54px)] bg-gradient-to-r from-blue-500 to-blue-700 bg-clip-text text-transparent leading-none">{{ stats.companies }}</b><span class="text-sm text-muted font-semibold tracking-[.04em] mt-2 block">COMPANIES</span></div>
				<div class="text-center p-3.5"><b class="block font-display font-semibold text-[clamp(38px,5vw,54px)] bg-gradient-to-r from-blue-500 to-blue-700 bg-clip-text text-transparent leading-none">{{ stats.internships }}</b><span class="text-sm text-muted font-semibold tracking-[.04em] mt-2 block">OPEN ROLES</span></div>
				<div class="text-center p-3.5"><b class="block font-display font-semibold text-[clamp(38px,5vw,54px)] bg-gradient-to-r from-blue-500 to-blue-700 bg-clip-text text-transparent leading-none">{{ stats.applications }}</b><span class="text-sm text-muted font-semibold tracking-[.04em] mt-2 block">APPLICATIONS</span></div>
			</div>
		</div>
	</section>

	<!-- ============ FAQ ============ -->
	<section class="py-[104px] bg-paper-2 border-t border-line" id="faq">
		<div class="max-w-wrap mx-auto px-7">
			<div v-reveal class="max-w-[680px] text-center mx-auto">
				<span class="font-display text-[12.5px] font-semibold tracking-[.18em] uppercase text-blue-600">FAQ</span>
				<h2 class="font-display font-semibold tracking-[-.02em] text-[clamp(30px,4vw,46px)] my-4">Questions, answered.</h2>
				<p class="text-[17px] text-muted leading-[1.6] mx-auto">Everything you need to know about using Internly as a student or a company.</p>
			</div>
			<div class="max-w-[820px] mx-auto mt-[46px]">
				<details v-for="(faq, index) in faqs" :key="faq.q" class="group border border-line rounded-[14px] bg-white mb-3 overflow-hidden open:border-blue-200 open:shadow-xs transition-all" :open="index === 0">
					<summary class="list-none cursor-pointer px-6 py-5 flex items-center justify-between gap-4 font-display font-semibold text-[17px] [&::-webkit-details-marker]:hidden">
						{{ faq.q }}
						<span class="shrink-0 w-[30px] h-[30px] rounded-lg bg-blue-50 text-blue-700 grid place-items-center transition-transform group-open:rotate-45 group-open:bg-blue-600 group-open:text-white [&_svg]:w-[15px] [&_svg]:h-[15px]" v-html="icons.plus"></span>
					</summary>
					<div class="px-6 pb-[22px] text-muted text-[15.5px] leading-[1.65] max-w-[680px]">{{ faq.a }}</div>
				</details>
			</div>
		</div>
	</section>

	<!-- ============ CTA ============ -->
	<section class="pb-[104px] bg-paper-2">
		<div class="max-w-wrap mx-auto px-7">
			<div v-reveal class="relative overflow-hidden bg-gradient-to-br from-navy-800 to-navy-900 rounded-[26px] px-[60px] py-[72px] text-center">
				<div class="absolute inset-0 bg-[radial-gradient(700px_320px_at_50%_-30%,rgba(59,130,246,.4),transparent_70%)]"></div>
				<div class="absolute inset-0 [background-image:linear-gradient(rgba(255,255,255,.05)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.05)_1px,transparent_1px)] [background-size:46px_46px] [mask-image:radial-gradient(560px_280px_at_50%_120%,#000,transparent)] [-webkit-mask-image:radial-gradient(560px_280px_at_50%_120%,#000,transparent)]"></div>
				<div class="relative z-[1]">
					<span class="inline-flex items-center gap-2 px-3.5 py-[7px] rounded-full text-[13px] font-semibold bg-white/[.07] text-[#cfe0ff] border border-white/[.14] mb-5">Start today — it's free</span>
					<h2 class="font-display font-semibold tracking-[-.02em] text-white text-[clamp(30px,4.4vw,46px)] mb-4">Your next internship is one click away.</h2>
					<p class="text-[#aebfdd] text-lg max-w-[520px] mx-auto mb-[30px]">Join the students already building their careers on Internly. Create your profile and start applying today.</p>
					<div class="flex gap-3.5 justify-center flex-wrap">
						<Link class="inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-white text-navy-900 hover:-translate-y-px hover:shadow-[0_18px_34px_-18px_rgba(0,0,0,.6)] transition-all" :href="route('register')">Create free account</Link>
						<Link class="inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-white/10 text-white border border-white/20 hover:-translate-y-px transition-all" :href="route('blog.index')">Read the blog</Link>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>
