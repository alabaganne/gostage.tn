<script setup>
import { computed, h, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import MarketingLayout from '@/Layouts/MarketingLayout.vue';

defineOptions({
	layout: (_h, page) => h(MarketingLayout, { active: 'blog' }, () => page),
});

const props = defineProps({
	posts: { type: Array, default: () => [] },
});

const icons = {
	doc: '<svg viewBox="0 0 24 24" fill="none"><path d="M14 2v6h6M8 13h8M8 17h5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M6 2h8l6 6v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	chat: '<svg viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	chart: '<svg viewBox="0 0 24 24" fill="none"><path d="M3 17l6-6 4 4 7-7M14 8h6v6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	star: '<svg viewBox="0 0 24 24" fill="none"><path d="M12 2l2.4 7.4H22l-6 4.4 2.3 7.2L12 16.6 5.7 21l2.3-7.2-6-4.4h7.6z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
};

const GRADIENTS = [
	'linear-gradient(150deg,#3b82f6,#1d4ed8)',
	'linear-gradient(150deg,#6366f1,#4338ca)',
	'linear-gradient(150deg,#10b981,#047857)',
	'linear-gradient(150deg,#f59e0b,#d97706)',
	'linear-gradient(150deg,#ec4899,#be185d)',
	'linear-gradient(150deg,#06b6d4,#0e7490)',
];
const ICONS = [icons.doc, icons.chat, icons.chart, icons.star];

const gradientAt = (index) => GRADIENTS[index % GRADIENTS.length];
const iconAt = (index) => ICONS[index % ICONS.length];

const categories = computed(() => ['All', ...new Set(props.posts.map((post) => post.category))]);
const active = ref('All');

const filtered = computed(() =>
	active.value === 'All' ? props.posts : props.posts.filter((post) => post.category === active.value)
);
const featured = computed(() => filtered.value[0]);
const rest = computed(() => filtered.value.slice(1));
</script>

<template>
	<!-- HERO -->
	<section class="pt-[70px] pb-[30px] bg-[radial-gradient(900px_420px_at_80%_-20%,#eef4ff,transparent_60%)]">
		<div class="max-w-wrap mx-auto px-7">
			<span class="font-display text-[12.5px] font-semibold tracking-[.18em] uppercase text-blue-600">The Internly blog</span>
			<h1 class="font-display font-semibold tracking-[-.02em] leading-[1.04] text-[clamp(38px,5vw,60px)] max-w-[760px] my-[18px]">Advice for landing the internship — and making it count.</h1>
			<p class="text-[18.5px] text-muted max-w-[560px]">Practical guides on applications, interviews, and early-career growth, plus hiring insights for the companies on the other side of the table.</p>
			<div class="flex gap-2.5 flex-wrap mt-[34px] mb-2">
				<button
					v-for="category in categories"
					:key="category"
					class="px-[18px] py-[9px] rounded-full text-sm font-semibold border transition-colors"
					:class="active === category ? 'bg-blue-600 text-white border-blue-600' : 'border-line text-ink-700 bg-white hover:border-blue-300 hover:text-blue-700'"
					type="button"
					@click="active = category"
				>{{ category }}</button>
			</div>
		</div>
	</section>

	<!-- FEATURED -->
	<section v-if="featured" class="pt-6 pb-2.5">
		<div class="max-w-wrap mx-auto px-7">
			<Link class="group grid grid-cols-[1.15fr_1fr] border border-line rounded-[26px] overflow-hidden mt-3.5 bg-white shadow-xs transition-all hover:shadow-card hover:-translate-y-[3px] max-[880px]:grid-cols-1" :href="route('blog.show', featured.slug)">
				<div class="cover-grid relative min-h-[380px] grid place-items-center text-white max-[880px]:min-h-[240px]" :style="{ background: gradientAt(0) }">
					<div class="relative z-[1] w-24 h-24 rounded-3xl bg-white/[.16] grid place-items-center backdrop-blur-[4px] [&_svg]:w-[46px] [&_svg]:h-[46px]" v-html="iconAt(0)"></div>
				</div>
				<div class="p-[46px] max-[880px]:p-8">
					<span class="inline-flex items-center gap-2 px-3.5 py-[7px] rounded-full text-[13px] font-semibold bg-blue-50 text-blue-700 border border-blue-100 mb-[18px]">Featured · {{ featured.category }}</span>
					<h2 class="font-display font-semibold tracking-[-.02em] text-[clamp(26px,3vw,36px)] mb-4">{{ featured.title }}</h2>
					<p class="text-[16.5px] text-muted leading-[1.65] mb-[26px]">{{ featured.excerpt }}</p>
					<div class="flex items-center gap-3">
						<span class="w-[42px] h-[42px] rounded-full bg-gradient-to-br from-blue-300 to-blue-700 grid place-items-center text-white font-bold font-display text-[15px]">AB</span>
						<div><b class="text-sm font-semibold block">Ala Baganne</b><span class="text-[13px] text-muted">{{ featured.published_at }} · {{ featured.read_time }}</span></div>
					</div>
				</div>
			</Link>
		</div>
	</section>

	<!-- POSTS GRID -->
	<section class="pt-12 pb-[104px]">
		<div class="max-w-wrap mx-auto px-7">
			<h3 v-if="rest.length" class="font-display text-[15px] tracking-[.04em] text-muted font-semibold mb-1.5">LATEST ARTICLES</h3>
			<div class="grid grid-cols-3 gap-6 mt-[30px] max-[900px]:grid-cols-2 max-[620px]:grid-cols-1">
				<Link
					v-for="(post, index) in rest"
					:key="post.slug"
					class="group bg-white border border-line rounded-[18px] overflow-hidden flex flex-col transition-all hover:-translate-y-1 hover:shadow-card hover:border-blue-200"
					:href="route('blog.show', post.slug)"
				>
					<div class="relative h-[178px] grid place-items-center text-white" :style="{ background: gradientAt(index + 1) }">
						<span class="absolute z-[1] top-3.5 left-3.5 bg-white/[.92] text-ink text-[11.5px] font-bold px-[11px] py-[5px] rounded-full tracking-[.02em]">{{ post.category }}</span>
						<div class="relative z-[1] w-[60px] h-[60px] rounded-2xl bg-white/[.18] grid place-items-center [&_svg]:w-7 [&_svg]:h-7" v-html="iconAt(index + 1)"></div>
					</div>
					<div class="p-[22px] flex flex-col flex-1">
						<span class="text-[12.5px] text-muted-2 font-semibold tracking-[.02em]">{{ post.published_at }}</span>
						<h3 class="font-display text-[19px] font-semibold my-[9px] leading-[1.25]">{{ post.title }}</h3>
						<p class="text-[14.5px] text-muted leading-[1.6] mb-[18px]">{{ post.excerpt }}</p>
						<div class="mt-auto pt-4 border-t border-line-2 flex items-center justify-between">
							<div class="flex items-center gap-3"><span class="w-[42px] h-[42px] rounded-full bg-gradient-to-br from-blue-300 to-blue-700 grid place-items-center text-white font-bold font-display text-[15px]">AB</span><b class="text-sm font-semibold">Ala Baganne</b></div>
							<span class="text-[13px] text-muted font-medium">{{ post.read_time }}</span>
						</div>
					</div>
				</Link>
			</div>
		</div>
	</section>
</template>
