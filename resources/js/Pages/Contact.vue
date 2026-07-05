<script setup>
import { h } from 'vue';
import { Link } from '@inertiajs/vue3';
import MarketingLayout from '@/Layouts/MarketingLayout.vue';

defineOptions({
	layout: (_h, page) => h(MarketingLayout, { active: 'contact', solid: true }, () => page),
});

const icons = {
	mail: '<svg viewBox="0 0 24 24" fill="none"><rect x="4" y="5" width="16" height="14" rx="2" stroke="currentColor" stroke-width="2"/><path d="M4 8l8 5 8-5" stroke="currentColor" stroke-width="2"/></svg>',
	globe: '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M3 12h18M12 3c2.5 2.5 3.8 5.7 3.8 9s-1.3 6.5-3.8 9c-2.5-2.5-3.8-5.7-3.8-9S9.5 5.5 12 3z" stroke="currentColor" stroke-width="2"/></svg>',
	linkedin: '<svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="3" stroke="currentColor" stroke-width="2"/><path d="M7 10v6M7 7v.01M11 16v-3.5a1.5 1.5 0 013 0V16M11 12v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	search: '<svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
};
</script>

<template>
	<!-- HERO -->
	<section class="pt-[54px] pb-16">
		<div class="max-w-wrap mx-auto px-7">
			<span class="inline-flex items-center gap-2 px-3.5 py-[7px] rounded-full text-[13px] font-semibold bg-blue-50 text-blue-700 border border-blue-100 mb-[26px]"><span class="w-[7px] h-[7px] rounded-full bg-blue-500 shadow-[0_0_0_4px_rgba(59,130,246,.18)]"></span>Contact</span>
			<h1 class="font-display font-bold tracking-[-.02em] text-[clamp(40px,6vw,72px)] leading-[1.02] max-w-[14ch]">Let’s talk about Internly or engineering opportunities.</h1>
			<p class="text-[18.5px] leading-[1.65] text-muted max-w-[62ch] mt-[26px]">Whether you’re a student, company, recruiter, or engineering team, you can reach the developer directly using the links below.</p>
		</div>
	</section>

	<!-- BODY -->
	<section class="bg-paper-2 border-t border-line pt-16 pb-24">
		<div class="max-w-wrap mx-auto px-7">
			<div class="grid grid-cols-[1.55fr_1fr] gap-6 items-start max-[980px]:grid-cols-1">
				<!-- Get in touch -->
				<div class="bg-white border border-line rounded-[18px] p-10">
					<h2 class="font-display text-[26px] font-semibold mb-3.5">Get in touch</h2>
					<p class="text-[15.5px] leading-[1.7] text-muted max-w-[60ch] mb-[30px]">For job opportunities, freelance work, product feedback, MVP builds, or questions about this app, email is the fastest way to reach me.</p>

					<div class="grid grid-cols-2 gap-4 max-[560px]:grid-cols-1">
						<a class="group block border border-line rounded-[14px] px-[22px] py-5 transition-all hover:border-blue-300 hover:-translate-y-0.5" href="mailto:alabaganne9@gmail.com">
							<span class="flex items-center gap-2 text-[13px] font-semibold text-muted mb-[11px] [&_svg]:w-[15px] [&_svg]:h-[15px] [&_svg]:text-blue-600"><span class="contents" v-html="icons.mail"></span>Email</span>
							<span class="block text-[16.5px] font-semibold text-ink font-display break-words group-hover:text-blue-700">alabaganne9@gmail.com</span>
						</a>
						<a class="group block border border-line rounded-[14px] px-[22px] py-5 transition-all hover:border-blue-300 hover:-translate-y-0.5" href="https://www.alabaganne.com" target="_blank" rel="noopener">
							<span class="flex items-center gap-2 text-[13px] font-semibold text-muted mb-[11px] [&_svg]:w-[15px] [&_svg]:h-[15px] [&_svg]:text-blue-600"><span class="contents" v-html="icons.globe"></span>Portfolio</span>
							<span class="block text-[16.5px] font-semibold text-ink font-display break-words group-hover:text-blue-700">www.alabaganne.com</span>
						</a>
						<a class="group block border border-line rounded-[14px] px-[22px] py-5 transition-all hover:border-blue-300 hover:-translate-y-0.5" href="https://linkedin.com/in/alabaganne" target="_blank" rel="noopener">
							<span class="flex items-center gap-2 text-[13px] font-semibold text-muted mb-[11px] [&_svg]:w-[15px] [&_svg]:h-[15px] [&_svg]:text-blue-600"><span class="contents" v-html="icons.linkedin"></span>LinkedIn</span>
							<span class="block text-[16.5px] font-semibold text-ink font-display break-words group-hover:text-blue-700">linkedin.com/in/alabaganne</span>
						</a>
						<Link class="group block border border-line rounded-[14px] px-[22px] py-5 transition-all hover:border-blue-300 hover:-translate-y-0.5" :href="route('internships.index')">
							<span class="flex items-center gap-2 text-[13px] font-semibold text-muted mb-[11px] [&_svg]:w-[15px] [&_svg]:h-[15px] [&_svg]:text-blue-600"><span class="contents" v-html="icons.search"></span>Explore the product</span>
							<span class="block text-[16.5px] font-semibold text-ink font-display break-words group-hover:text-blue-700">Browse internships</span>
						</Link>
					</div>
				</div>

				<!-- About the developer -->
				<div class="bg-navy-900 text-[#aeb9cf] rounded-[18px] p-10 self-stretch">
					<h2 class="font-display text-white text-2xl font-semibold mb-5 tracking-[-.02em]">About the developer</h2>
					<p class="text-[15.5px] leading-[1.75] text-[#aeb9cf]">Ala Baganne is a software engineer and SaaS-focused builder who likes shipping practical full-stack products with clean interfaces, solid auth, useful role permissions, and real deployment polish. He is open to good engineering opportunities and to helping people turn product ideas into working software.</p>
					<div class="mt-[30px] flex flex-col">
						<div class="flex items-center justify-between gap-4 py-4"><span class="text-[14.5px] text-[#7c89a3]">Focus</span><span class="text-[14.5px] font-semibold text-white font-display text-right">Full-stack web</span></div>
						<div class="flex items-center justify-between gap-4 py-4 border-t border-white/10"><span class="text-[14.5px] text-[#7c89a3]">Product type</span><span class="text-[14.5px] font-semibold text-white font-display text-right">SaaS apps</span></div>
						<div class="flex items-center justify-between gap-4 py-4 border-t border-white/10"><span class="text-[14.5px] text-[#7c89a3]">Available for</span><span class="text-[14.5px] font-semibold text-white font-display text-right">Roles &amp; product builds</span></div>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>
