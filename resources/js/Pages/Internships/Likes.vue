<script setup>
import { h } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';
import RoleCard from '@/Components/Internship/RoleCard.vue';

defineOptions({
	layout: (_h, page) => h(AppShell, { active: 'saved' }, () => page),
});

defineProps({
	likes: { type: Array, default: () => [] },
});

const icons = {
	arrow: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	bookmark: '<svg viewBox="0 0 24 24" fill="none"><path d="M6 4h12v16l-6-4-6 4z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
};
</script>

<template>
	<div class="px-10 pt-[30px] pb-[50px] w-full">
		<div class="flex items-end justify-between flex-wrap gap-4 mb-6">
			<div>
				<span class="block font-display text-[12.5px] font-semibold tracking-[.18em] uppercase text-blue-600 mb-2">Your shortlist</span>
				<h1 class="font-display text-[32px] font-semibold tracking-[-.02em]">Saved roles</h1>
				<p class="text-muted text-[15px] mt-1.5">{{ likes.length }} {{ likes.length === 1 ? 'internship' : 'internships' }} saved for later. Apply before they close.</p>
			</div>
			<Link class="inline-flex items-center gap-2.5 font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-white text-ink border border-line hover:border-blue-300 hover:text-blue-700 transition-all [&_svg]:w-[17px] [&_svg]:h-[17px]" :href="route('internships.index')">
			Find more roles <span class="contents" v-html="icons.arrow"></span>
			</Link>
		</div>

		<div v-if="likes.length" class="flex flex-col gap-3.5">
			<RoleCard v-for="internship in likes" :key="internship.id" :internship="{ ...internship, liked: true }" />
		</div>

		<!-- empty state -->
		<div v-else class="flex flex-col items-center text-center py-[70px] px-5">
			<div class="w-[72px] h-[72px] rounded-[20px] bg-blue-50 text-blue-600 grid place-items-center mb-5 [&_svg]:w-[34px] [&_svg]:h-[34px]" v-html="icons.bookmark"></div>
			<h3 class="font-display text-xl font-semibold mb-2">No saved roles yet</h3>
			<p class="text-muted text-[15px] max-w-[340px] mb-[22px]">Tap the bookmark on any internship to save it here and apply when you're ready.</p>
			<Link class="inline-flex items-center gap-2.5 font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-blue-600 text-white hover:bg-blue-700 transition-colors" :href="route('internships.index')">Browse internships</Link>
		</div>
	</div>
</template>
