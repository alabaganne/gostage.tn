<script setup>
import { h } from 'vue';
import { Link } from '@inertiajs/vue3';
import MarketingLayout from '@/Layouts/MarketingLayout.vue';

defineOptions({
	layout: (_h, page) => h(MarketingLayout, { active: 'blog' }, () => page),
});

defineProps({
	post: { type: Object, required: true },
	related: { type: Array, default: () => [] },
});

const icons = {
	chevron: '<svg viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	doc: '<svg viewBox="0 0 24 24" fill="none"><path d="M14 2v6h6M8 13h8M8 17h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M6 2h8l6 6v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>',
	arrow: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
};

const GRADIENTS = [
	'linear-gradient(150deg,#3b82f6,#1d4ed8)',
	'linear-gradient(150deg,#6366f1,#4338ca)',
	'linear-gradient(150deg,#10b981,#047857)',
	'linear-gradient(150deg,#f59e0b,#d97706)',
];
const gradientAt = (index) => GRADIENTS[index % GRADIENTS.length];
</script>

<template>
	<!-- ARTICLE TOP -->
	<section class="pt-[54px] pb-[34px] bg-[radial-gradient(800px_360px_at_80%_-30%,#eef4ff,transparent_60%)]">
		<div class="max-w-wrap mx-auto px-7">
			<div class="flex items-center gap-2 text-[13.5px] text-muted font-medium [&_svg]:w-3.5 [&_svg]:h-3.5 [&_svg]:text-muted-2">
				<Link class="hover:text-blue-700" :href="route('blog.index')">Blog</Link>
				<span class="contents" v-html="icons.chevron"></span>
				<span class="text-blue-700 font-semibold">{{ post.category }}</span>
			</div>
			<div class="max-w-[780px]">
				<span class="inline-flex items-center gap-2 px-3.5 py-[7px] rounded-full text-[13px] font-semibold bg-blue-50 text-blue-700 border border-blue-100 mt-[18px]">{{ post.category }}</span>
				<h1 class="font-display font-semibold tracking-[-.02em] text-[clamp(32px,4.6vw,52px)] leading-[1.06] my-[18px] mb-[22px]">{{ post.title }}</h1>
				<p class="text-[19px] text-muted leading-[1.6] max-w-[680px]">{{ post.excerpt }}</p>
			</div>
			<div class="flex items-center justify-between flex-wrap gap-[18px] mt-[30px] pt-[26px] border-t border-line">
				<div class="flex items-center gap-3">
					<span class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-300 to-blue-700 grid place-items-center text-white font-bold font-display text-base">AB</span>
					<div><b class="text-[15px] font-semibold block">Ala Baganne</b><span class="text-[13px] text-muted">Internly · {{ post.published_at }} · {{ post.read_time }}</span></div>
				</div>
			</div>
		</div>
	</section>

	<!-- COVER -->
	<div class="max-w-wrap mx-auto px-7">
		<div class="cover-grid relative h-[clamp(280px,40vw,460px)] rounded-[26px] mt-2 overflow-hidden grid place-items-center text-white" :style="{ background: gradientAt(0) }">
			<div class="relative z-[1] w-[110px] h-[110px] rounded-[28px] bg-white/[.16] grid place-items-center backdrop-blur-[4px] [&_svg]:w-[52px] [&_svg]:h-[52px]" v-html="icons.doc"></div>
		</div>
	</div>

	<!-- ARTICLE BODY -->
	<div class="max-w-wrap mx-auto px-7">
		<div class="grid grid-cols-[1fr_minmax(0,720px)_1fr] pt-[56px] pb-[90px] max-[980px]:grid-cols-1">
			<article class="art-body col-start-2 max-[980px]:col-start-1 max-[980px]:mx-auto">
				<p class="lead">{{ post.description }}</p>
				<template v-for="section in post.sections" :key="section.heading">
					<h2>{{ section.heading }}</h2>
					<p>{{ section.body }}</p>
				</template>

				<div class="flex gap-[9px] flex-wrap mt-3.5">
					<span v-for="keyword in (post.keywords || '').split(',').slice(0, 4)" :key="keyword" class="inline-flex items-center px-[11px] py-[5px] rounded-lg text-xs font-semibold bg-paper-3 text-ink-700">{{ keyword.trim() }}</span>
				</div>

				<!-- AUTHOR -->
				<div class="flex gap-[18px] items-center bg-paper-2 border border-line rounded-[18px] p-[26px] mt-[46px] max-w-[720px]">
					<span class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-300 to-blue-700 grid place-items-center text-white font-bold font-display text-[22px] shrink-0">AB</span>
					<div>
						<b class="font-display text-[18px]">Ala Baganne</b>
						<div class="text-sm text-blue-700 font-semibold my-0.5 mb-2">Builder of Internly</div>
						<p class="!m-0 !text-[14.5px] text-muted !leading-[1.6] max-w-[520px]">Ala writes about early-career hiring and building products end to end. Internly is part of that journey — a real internship platform built to make applying and hiring simpler.</p>
					</div>
				</div>
			</article>
		</div>
	</div>

	<!-- RELATED -->
	<section v-if="related.length" class="bg-paper-2 border-t border-line py-20">
		<div class="max-w-wrap mx-auto px-7">
			<div class="flex items-end justify-between gap-5 flex-wrap">
				<div>
					<span class="font-display text-[12.5px] font-semibold tracking-[.18em] uppercase text-blue-600">Keep reading</span>
					<h2 class="font-display font-semibold tracking-[-.02em] text-[32px] mt-3.5">Related articles</h2>
				</div>
				<Link class="text-blue-700 font-semibold inline-flex items-center gap-[7px] hover:gap-[11px] transition-all [&_svg]:w-4 [&_svg]:h-4" :href="route('blog.index')">All articles <span class="contents" v-html="icons.arrow"></span></Link>
			</div>
			<div class="grid grid-cols-3 gap-6 mt-[34px] max-[900px]:grid-cols-1">
				<Link
					v-for="(item, index) in related"
					:key="item.slug"
					class="group bg-white border border-line rounded-[18px] overflow-hidden flex flex-col transition-all hover:-translate-y-1 hover:shadow-card hover:border-blue-200"
					:href="route('blog.show', item.slug)"
				>
					<div class="h-[150px] grid place-items-center text-white" :style="{ background: gradientAt(index + 1) }">
						<div class="w-[54px] h-[54px] rounded-[14px] bg-white/[.18] grid place-items-center [&_svg]:w-[26px] [&_svg]:h-[26px]" v-html="icons.doc"></div>
					</div>
					<div class="p-5">
						<span class="text-[12.5px] text-muted-2 font-semibold">{{ item.published_at }} · {{ item.category }}</span>
						<h3 class="font-display text-[17.5px] font-semibold mt-2 leading-[1.3]">{{ item.title }}</h3>
					</div>
				</Link>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="py-[90px]">
		<div class="max-w-wrap mx-auto px-7 text-center max-w-[680px]">
			<h2 class="font-display font-semibold tracking-[-.02em] text-[clamp(28px,3.6vw,40px)] mb-3.5">Ready to put this into practice?</h2>
			<p class="text-[18px] text-muted mb-7">Browse open internships and apply with a profile that's built to get read.</p>
			<Link class="inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-blue-600 text-white shadow-cta hover:bg-blue-700 hover:-translate-y-px transition-all [&_svg]:w-[17px] [&_svg]:h-[17px]" :href="route('internships.index')">
				Browse internships <span class="contents" v-html="icons.arrow"></span>
			</Link>
		</div>
	</section>
</template>
