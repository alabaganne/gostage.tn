<script setup>
import { computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import CompanyLogo from '@/Components/Ui/CompanyLogo.vue';

const props = defineProps({
	internship: { type: Object, required: true },
});

const icons = {
	pin: '<svg viewBox="0 0 24 24" fill="none"><path d="M12 21s7-5.5 7-11a7 7 0 10-14 0c0 5.5 7 11 7 11z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="2"/></svg>',
	clock: '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	briefcase: '<svg viewBox="0 0 24 24" fill="none"><rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" stroke-width="2"/><path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2" stroke="currentColor" stroke-width="2"/></svg>',
	save: '<svg viewBox="0 0 24 24" fill="none"><path d="M6 4h12v16l-6-4-6 4z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	arrow: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
};

const page = usePage();
const isStudent = computed(() => page.props.auth?.user?.userable_type === 'student');

const toggleSave = () => {
	router.post(route('likes.store', props.internship.id), {}, { preserveScroll: true });
};
</script>

<template>
	<article class="bg-white border border-line rounded-[18px] p-[22px] flex flex-col transition-colors hover:border-blue-300">
		<div class="flex gap-[18px] items-start max-[560px]:flex-col">
			<CompanyLogo class="w-[54px] h-[54px] rounded-[14px] text-[19px]" :name="internship.company.name" />
			<div class="flex-1 min-w-0">
				<div class="flex items-start justify-between gap-3">
					<div>
						<h3 class="font-display text-[18.5px] font-semibold mb-[3px]">
							<Link class="hover:text-blue-700" :href="route('internships.show', internship.id)">{{ internship.title }}</Link>
						</h3>
						<p class="text-sm text-muted mb-3.5"><b class="text-ink-700 font-semibold">{{ internship.company.name }}</b> · {{ internship.city.name }}</p>
					</div>
				</div>
				<div class="flex flex-wrap gap-[18px] mb-3.5 [&_span]:flex [&_span]:items-center [&_span]:gap-1.5 [&_span]:text-[13.5px] [&_span]:text-muted [&_span]:font-medium [&_svg]:w-[15px] [&_svg]:h-[15px] [&_svg]:text-muted-2">
					<span><span class="contents" v-html="icons.briefcase"></span>{{ internship.field.name }}</span>
					<span><span class="contents" v-html="icons.clock"></span>Closes {{ internship.closing_at }}</span>
				</div>
				<div v-if="internship.skills?.length" class="flex flex-wrap gap-[7px]">
					<span v-for="skill in internship.skills" :key="skill" class="inline-flex items-center px-[11px] py-[5px] rounded-lg text-xs font-semibold bg-paper-3 text-ink-700">{{ skill }}</span>
				</div>
			</div>
			<div class="flex flex-col items-end gap-3 shrink-0">
				<span v-if="internship.application" class="text-[11px] font-bold text-[#047857] bg-[#dcfce7] px-[9px] py-1 rounded-[7px] tracking-[.02em]">APPLIED</span>
				<span v-else-if="internship.is_new" class="text-[11px] font-bold text-blue-700 bg-blue-50 px-[9px] py-1 rounded-[7px] tracking-[.03em]">NEW</span>
				<button
					v-if="isStudent"
					class="w-[38px] h-[38px] rounded-[10px] border grid place-items-center cursor-pointer transition-all [&_svg]:w-[18px] [&_svg]:h-[18px]"
					:class="internship.liked
						? 'border-blue-200 bg-blue-50 text-blue-600 hover:bg-[#fef2f2] hover:border-[#fecaca] hover:text-[#dc2626]'
						: 'border-line text-muted-2 hover:border-blue-300 hover:text-blue-600'"
					type="button"
					:title="internship.liked ? 'Remove from saved' : 'Save role'"
					@click="toggleSave"
					v-html="icons.save"
				></button>
			</div>
		</div>
		<div class="flex items-center justify-between w-full mt-[18px] border-t border-line-2">
			<span class="text-[13px] text-muted-2 pt-[15px]">Posted {{ internship.created_at }}<template v-if="internship.applications_count !== undefined"> · {{ internship.applications_count }} applicants</template></span>
			<Link class="pt-[15px] text-blue-700 font-semibold inline-flex items-center gap-[7px] hover:gap-[11px] transition-all [&_svg]:w-4 [&_svg]:h-4" :href="route('internships.show', internship.id)">
				View role <span class="contents" v-html="icons.arrow"></span>
			</Link>
		</div>
	</article>
</template>
