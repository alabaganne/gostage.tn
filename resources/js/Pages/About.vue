<script setup>
import { h } from 'vue';
import { Link } from '@inertiajs/vue3';
import MarketingLayout from '@/Layouts/MarketingLayout.vue';

defineOptions({
	layout: (_h, page) => h(MarketingLayout, { active: 'about' }, () => page),
});

const icons = {
	arrow: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	check: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	code: '<svg viewBox="0 0 24 24" fill="none"><path d="M8 9l-4 3 4 3M16 9l4 3-4 3M13 5l-2 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	star: '<svg viewBox="0 0 24 24" fill="none"><path d="M12 3l2.5 6.5L21 11l-6.5 2.5L12 20l-2.5-6.5L3 11l6.5-1.5z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	home: '<svg viewBox="0 0 24 24" fill="none"><path d="M3 21h18M5 21V10l7-5 7 5v11M9 21v-6h6v6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	mail: '<svg viewBox="0 0 24 24" fill="none"><rect x="4" y="5" width="16" height="14" rx="2" stroke="currentColor" stroke-width="2"/><path d="M4 8l8 5 8-5" stroke="currentColor" stroke-width="2"/></svg>',
	globe: '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M3 12h18M12 3c2.5 2.5 3.8 5.7 3.8 9s-1.3 6.5-3.8 9c-2.5-2.5-3.8-5.7-3.8-9S9.5 5.5 12 3z" stroke="currentColor" stroke-width="2"/></svg>',
	linkedin: '<svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="3" stroke="currentColor" stroke-width="2"/><path d="M7 10v6M7 7v.01M11 16v-3.5a1.5 1.5 0 013 0V16M11 12v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
};

const problems = [
	{ title: 'Public discovery', body: 'Internship listings are accessible without logging in, making opportunities easier to find and share.' },
	{ title: 'Role-aware workflows', body: 'Students, companies, and admins each get the permissions and screens they need.' },
	{ title: 'Company onboarding', body: 'Companies complete their profile before posting, helping students evaluate opportunities with more trust.' },
];

const skills = [
	{ icon: 'code', title: 'Full-stack', body: 'Laravel, Vue, databases, auth, deployment' },
	{ icon: 'star', title: 'Product-minded', body: 'Focused on useful features and polished demos' },
	{ icon: 'home', title: 'Builder', body: 'Shipping SaaS-style apps end to end' },
];
</script>

<template>
	<!-- ============ HERO ============ -->
	<section class="relative overflow-hidden pt-[60px] pb-[76px] bg-[radial-gradient(1000px_480px_at_82%_-10%,#eef4ff,transparent_60%),linear-gradient(180deg,#fff,#f6f8fc)]">
		<div class="absolute inset-0 opacity-70 [background-image:linear-gradient(#eef1f6_1px,transparent_1px),linear-gradient(90deg,#eef1f6_1px,transparent_1px)] [background-size:54px_54px] [mask-image:radial-gradient(700px_440px_at_76%_4%,#000,transparent_75%)] [-webkit-mask-image:radial-gradient(700px_440px_at_76%_4%,#000,transparent_75%)]"></div>
		<div v-reveal class="relative max-w-[900px] mx-auto px-7">
			<span class="inline-flex items-center gap-2 px-3.5 py-[7px] rounded-full text-[13px] font-semibold bg-blue-50 text-blue-700 border border-blue-100"><span class="w-[7px] h-[7px] rounded-full bg-blue-500 shadow-[0_0_0_4px_rgba(59,130,246,.18)]"></span>About Internly</span>
			<h1 class="font-display font-semibold tracking-[-.02em] leading-[1.04] text-[clamp(40px,5.6vw,68px)] my-6 max-w-[15ch]">A cleaner way for students and companies to <span class="bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">meet.</span></h1>
			<p class="text-[18.5px] text-muted max-w-[64ch] leading-[1.64]">Internly is an internship discovery platform built to make early-career hiring simpler: students can browse public opportunities and apply online, while companies can publish internships and manage applications from one focused workspace.</p>
			<div class="flex gap-3.5 mt-[34px] flex-wrap">
				<Link class="inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-blue-600 text-white shadow-cta hover:bg-blue-700 hover:-translate-y-px transition-all [&_svg]:w-[17px] [&_svg]:h-[17px]" :href="route('internships.index')">
					Browse internships <span class="contents" v-html="icons.arrow"></span>
				</Link>
				<Link class="inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-white text-ink border border-line hover:border-blue-300 hover:text-blue-700 hover:-translate-y-px transition-all" :href="route('register')">Create account</Link>
			</div>
		</div>
	</section>

	<!-- ============ WHAT IT SOLVES ============ -->
	<section class="py-24">
		<div class="max-w-wrap mx-auto px-7">
			<div v-reveal class="max-w-[680px]">
				<span class="font-display text-[12.5px] font-semibold tracking-[.18em] uppercase text-blue-600">What it solves</span>
				<h2 class="font-display font-semibold tracking-[-.02em] text-[clamp(30px,4vw,46px)] mt-4">Built around three real problems.</h2>
			</div>
			<div class="grid grid-cols-3 gap-[22px] mt-[54px] max-[880px]:grid-cols-1">
				<div v-for="problem in problems" :key="problem.title" v-reveal class="bg-white border border-line rounded-[18px] p-8 transition-all duration-200 hover:-translate-y-1 hover:shadow-card hover:border-blue-200">
					<div class="w-[46px] h-[46px] rounded-[13px] bg-blue-50 text-blue-700 grid place-items-center mb-[22px] [&_svg]:w-[22px] [&_svg]:h-[22px]" v-html="icons.check"></div>
					<h3 class="font-display text-xl font-semibold mb-[11px]">{{ problem.title }}</h3>
					<p class="text-[15px] text-muted leading-[1.62]">{{ problem.body }}</p>
				</div>
			</div>
		</div>
	</section>

	<!-- ============ BUILT BY ============ -->
	<section class="py-24 bg-paper-2 border-t border-line">
		<div class="max-w-wrap mx-auto px-7">
			<div class="grid grid-cols-[.85fr_1.15fr] gap-14 items-start max-[920px]:grid-cols-1 max-[920px]:gap-10">
				<div v-reveal class="sticky top-[104px] max-[920px]:static">
					<div class="bg-white border border-line rounded-[26px] p-[34px] shadow-xs">
						<div class="w-[72px] h-[72px] rounded-[20px] bg-gradient-to-br from-blue-400 to-blue-700 grid place-items-center text-white font-display font-bold text-[28px] shadow-cta mb-5">AB</div>
						<h3 class="font-display text-2xl font-semibold mb-1">Ala Baganne</h3>
						<div class="text-sm text-blue-700 font-semibold mb-6">Software engineer &amp; builder</div>
						<div class="flex flex-col gap-3.5">
							<div v-for="(skill, index) in skills" :key="skill.title" class="flex gap-[13px] items-start py-[15px] [&_svg]:w-[17px] [&_svg]:h-[17px]" :class="{ 'border-t border-line-2': index !== 0 }">
								<span class="w-[34px] h-[34px] rounded-[10px] bg-paper-3 text-blue-700 grid place-items-center shrink-0" v-html="icons[skill.icon]"></span>
								<div><b class="block font-display text-[15px] font-semibold mb-0.5">{{ skill.title }}</b><span class="text-[13.5px] text-muted leading-[1.5]">{{ skill.body }}</span></div>
							</div>
						</div>
					</div>
				</div>

				<div v-reveal>
					<span class="block font-display text-[12.5px] font-semibold tracking-[.18em] uppercase text-blue-600 mb-3.5">Built by</span>
					<h2 class="font-display font-semibold tracking-[-.02em] text-[clamp(28px,3.6vw,40px)] mb-[22px]">One developer, end to end.</h2>
					<p class="text-[16.5px] text-ink-700 leading-[1.72] mb-5 max-w-[60ch]">I’m a software engineer and builder focused on practical SaaS products, clean user experiences, and reliable full-stack execution. I enjoy taking an idea from rough requirements to a working deployed product: frontend, backend, database, authentication, permissions, deployment, and the final details that make a demo feel real.</p>
					<p class="text-[16.5px] text-muted leading-[1.72] mb-5 max-w-[60ch]">Internly is part of that builder journey: a real product-style application with public SEO-friendly pages, role-based student/company flows, company onboarding, application management, uploads, messaging, and admin controls.</p>
					<p class="text-[16.5px] text-muted leading-[1.72] max-w-[60ch]">I’m open to strong engineering opportunities, especially roles where I can build useful products end to end. If you have a product idea, an MVP to launch, or a business workflow you want turned into software, I’m also open to building for people and helping bring practical ideas to life.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- ============ DEVELOPER CONTACT ============ -->
	<section class="pb-[104px] bg-paper-2">
		<div class="max-w-wrap mx-auto px-7">
			<div v-reveal class="relative overflow-hidden bg-gradient-to-br from-navy-800 to-navy-900 rounded-[26px] px-[56px] py-[60px] max-[820px]:px-[30px] max-[820px]:py-[44px]">
				<div class="absolute inset-0 bg-[radial-gradient(640px_300px_at_18%_-30%,rgba(59,130,246,.35),transparent_70%)]"></div>
				<div class="relative z-[1] grid grid-cols-2 gap-11 items-center max-[820px]:grid-cols-1 max-[820px]:gap-8">
					<div>
						<span class="inline-flex items-center gap-2 px-3.5 py-[7px] rounded-full text-[13px] font-semibold bg-white/[.07] text-[#cfe0ff] border border-white/[.14] mb-[18px]">Developer contact</span>
						<h2 class="font-display font-semibold tracking-[-.02em] text-white text-[clamp(26px,3.4vw,36px)] mb-4">Let’s build something.</h2>
						<p class="text-[#aebfdd] text-base leading-[1.65] max-w-[42ch]">If you’re hiring for full-stack, frontend, backend, or product-focused engineering roles — or you want to build a product from an idea — I’d be glad to connect.</p>
					</div>
					<div class="flex flex-col gap-3">
						<a class="flex items-center gap-3.5 bg-white/5 border border-white/10 rounded-[14px] px-[18px] py-4 transition-all hover:bg-white/[.09] hover:border-blue-400 hover:translate-x-[3px] [&_svg]:w-[19px] [&_svg]:h-[19px]" href="mailto:alabaganne9@gmail.com">
							<span class="w-[42px] h-[42px] rounded-[11px] bg-blue-500/[.18] text-[#bcd4ff] grid place-items-center shrink-0" v-html="icons.mail"></span>
							<span class="flex items-center"><span class="text-xs text-[#7c89a3] font-semibold mr-2.5">Email</span><span class="text-[15.5px] text-white font-semibold font-display break-words">alabaganne9@gmail.com</span></span>
						</a>
						<a class="flex items-center gap-3.5 bg-white/5 border border-white/10 rounded-[14px] px-[18px] py-4 transition-all hover:bg-white/[.09] hover:border-blue-400 hover:translate-x-[3px] [&_svg]:w-[19px] [&_svg]:h-[19px]" href="https://www.alabaganne.com" target="_blank" rel="noopener">
							<span class="w-[42px] h-[42px] rounded-[11px] bg-blue-500/[.18] text-[#bcd4ff] grid place-items-center shrink-0" v-html="icons.globe"></span>
							<span class="flex items-center"><span class="text-xs text-[#7c89a3] font-semibold mr-2.5">Portfolio</span><span class="text-[15.5px] text-white font-semibold font-display break-words">www.alabaganne.com</span></span>
						</a>
						<a class="flex items-center gap-3.5 bg-white/5 border border-white/10 rounded-[14px] px-[18px] py-4 transition-all hover:bg-white/[.09] hover:border-blue-400 hover:translate-x-[3px] [&_svg]:w-[19px] [&_svg]:h-[19px]" href="https://linkedin.com/in/alabaganne" target="_blank" rel="noopener">
							<span class="w-[42px] h-[42px] rounded-[11px] bg-blue-500/[.18] text-[#bcd4ff] grid place-items-center shrink-0" v-html="icons.linkedin"></span>
							<span class="flex items-center"><span class="text-xs text-[#7c89a3] font-semibold mr-2.5">LinkedIn</span><span class="text-[15.5px] text-white font-semibold font-display break-words">linkedin.com/in/alabaganne</span></span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>
