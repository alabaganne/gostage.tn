<script setup>
import { computed, h } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';
import CompanyLogo from '@/Components/Ui/CompanyLogo.vue';

defineOptions({
	layout: (_h, page) => h(AppShell, { active: 'applications' }, () => page),
});

const props = defineProps({
	application: { type: Object, required: true },
});

const icons = {
	chevron: '<svg viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	calendarCheck: '<svg viewBox="0 0 24 24" fill="none"><path d="M8 2v4M16 2v4M3 9h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><rect x="3" y="4" width="18" height="17" rx="2" stroke="currentColor" stroke-width="2"/><path d="M9 14l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	pin: '<svg viewBox="0 0 24 24" fill="none"><path d="M12 21s7-5.5 7-11a7 7 0 10-14 0c0 5.5 7 11 7 11z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="2"/></svg>',
	clock: '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	external: '<svg viewBox="0 0 24 24" fill="none"><path d="M7 17L17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	check: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	dot: '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="4" fill="currentColor"/></svg>',
	download: '<svg viewBox="0 0 24 24" fill="none"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	arrow: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	mail: '<svg viewBox="0 0 24 24" fill="none"><rect x="4" y="5" width="16" height="14" rx="2" stroke="currentColor" stroke-width="2"/><path d="M4 8l8 5 8-5" stroke="currentColor" stroke-width="2"/></svg>',
	person: '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	phone: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 005 5L20 13l1 4v2a1 1 0 01-1 1A16 16 0 014 4a1 1 0 011-1z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
};

const page = usePage();
const user = computed(() => page.props.auth?.user);
const isStudent = computed(() => user.value?.userable_type === 'student');
// Legacy boolean statuses map onto the enum introduced with the redesign.
const normalizedStatus = computed(() => {
	const status = props.application.status;
	if (status === true || status === 'accepted') return 'offer';
	if (status === false || status === 'rejected') return 'closed';
	return status || 'submitted';
});

const open = computed(() => !['offer', 'closed'].includes(normalizedStatus.value));

const canReply = computed(
	() => (user.value?.userable_type === 'company' || user.value?.is_admin) && open.value
);

const STAGES = {
	submitted: { label: 'Submitted', color: '#b45309', bg: '#fef3c7', border: '#d97706', title: 'Application submitted' },
	viewed: { label: 'Viewed', color: '#1d4ed8', bg: '#eef4ff', border: '#2563eb', title: 'Viewed by the company' },
	review: { label: 'In review', color: '#b45309', bg: '#fef3c7', border: '#d97706', title: 'Application in review' },
	interview: { label: 'Interview', color: '#047857', bg: '#dcfce7', border: '#059669', title: 'Interview stage' },
	offer: { label: 'Offer', color: '#6d28d9', bg: '#ede9fe', border: '#7c3aed', title: 'Offer extended' },
	closed: { label: 'Not selected', color: '#5b6677', bg: '#eef2f9', border: '#8a93a3', title: 'Not selected' },
};

const stage = computed(() => {
	const base = STAGES[normalizedStatus.value] || STAGES.submitted;
	const notes = {
		offer: `${props.application.company.name} wants to move forward with this application.`,
		closed: 'This application was closed.',
	};
	return { ...base, note: notes[normalizedStatus.value] || `${props.application.company.name} is reviewing this application.` };
});

const counterpart = computed(() =>
	isStudent.value
		? { ...props.application.company, role: 'Company' }
		: { ...props.application.student, role: 'Applicant' }
);

const reply = (status) => router.post(route('applications.reply', props.application.id), { status });
const withdraw = () => {
	if (confirm('Withdraw this application? This cannot be undone.')) {
		router.delete(route('applications.destroy', props.application.id));
	}
};
</script>

<template>
	<div class="px-10 pt-7 pb-14 w-full">
		<div class="flex items-center gap-2 text-[13.5px] text-muted font-medium mb-[22px] [&_svg]:w-3.5 [&_svg]:h-3.5 [&_svg]:text-muted-2">
			<Link class="hover:text-blue-700" :href="route('applications.index')">Applications</Link>
			<span class="contents" v-html="icons.chevron"></span>
			<span class="text-ink-700 font-semibold">{{ application.internship.title }}</span>
		</div>

		<!-- STATUS BANNER -->
		<div class="flex items-center gap-4 bg-white border border-line border-l-4 rounded-[18px] px-6 py-[18px] mb-[22px]" :style="{ borderLeftColor: stage.border }">
			<div class="w-11 h-11 rounded-[12px] grid place-items-center shrink-0 [&_svg]:w-[22px] [&_svg]:h-[22px]" :style="{ background: stage.bg, color: stage.color }" v-html="icons.calendarCheck"></div>
			<div>
				<b class="text-base font-display font-semibold block">{{ stage.title }}</b>
				<span class="text-[13.5px] text-muted">{{ stage.note }}</span>
			</div>
			<div class="ml-auto text-right text-[13px] text-muted-2 max-[680px]:hidden">
				<b class="text-[13.5px] text-ink-700 font-body">Updated {{ application.updated_at }}</b><br>
				Applied {{ application.created_at }}
			</div>
		</div>

		<div class="grid grid-cols-[1fr_350px] gap-6 items-start max-[1080px]:grid-cols-1">
			<!-- LEFT -->
			<div class="flex flex-col gap-4">
				<section class="bg-white border border-line rounded-[18px] overflow-hidden px-8 py-[30px]">
					<div class="flex items-start gap-[18px]">
						<CompanyLogo class="w-[62px] h-[62px] rounded-[16px] text-[22px]" :name="application.company.name" />
						<div>
							<h1 class="font-display text-[26px] font-semibold leading-[1.12]">{{ application.internship.title }}</h1>
							<p class="text-[15px] text-muted mt-1.5"><b class="text-ink-700 font-semibold">{{ application.company.name }}</b> · {{ application.internship.field.name }}</p>
						</div>
					</div>
					<div class="flex flex-wrap gap-2.5 mt-[22px] [&_.m]:flex [&_.m]:items-center [&_.m]:gap-[7px] [&_.m]:text-[13.5px] [&_.m]:text-ink-700 [&_.m]:font-medium [&_.m]:bg-paper-2 [&_.m]:border [&_.m]:border-line-2 [&_.m]:px-[13px] [&_.m]:py-2 [&_.m]:rounded-[9px] [&_svg]:w-[15px] [&_svg]:h-[15px] [&_svg]:text-blue-600">
						<span class="m"><span class="contents" v-html="icons.pin"></span>{{ application.internship.city.name }}</span>
						<span class="m"><span class="contents" v-html="icons.clock"></span>Closes {{ application.internship.closing_at }}</span>
						<Link class="m no-underline" :href="route('internships.show', application.internship.id)"><span class="contents" v-html="icons.external"></span>View role posting</Link>
					</div>
				</section>

				<!-- TIMELINE -->
				<section class="bg-white border border-line rounded-[18px] px-8 py-[30px]">
					<h2 class="font-display text-[18px] font-semibold mb-1.5">Application timeline</h2>
					<p class="text-[13.5px] text-muted mb-[18px]">Every update on this application, newest at the bottom.</p>
					<div class="relative pl-[34px] before:content-[''] before:absolute before:left-[11px] before:top-1.5 before:bottom-2.5 before:w-0.5 before:bg-line">
						<div class="relative pb-[26px]">
							<span class="absolute -left-[34px] top-0 w-6 h-6 rounded-full bg-blue-600 border-2 border-blue-600 text-white grid place-items-center [&_svg]:w-[13px] [&_svg]:h-[13px]" v-html="icons.check"></span>
							<b class="text-[15px] font-display font-semibold block">Application submitted</b>
							<div class="text-[13px] text-muted mt-[3px]">{{ application.created_at }}</div>
						</div>
						<div v-if="!open" class="relative">
							<span class="absolute -left-[34px] top-0 w-6 h-6 rounded-full border-2 text-white grid place-items-center shadow-[0_0_0_4px_rgba(5,150,105,.18)] [&_svg]:w-[13px] [&_svg]:h-[13px]" :style="{ background: stage.border, borderColor: stage.border }" v-html="icons.dot"></span>
							<b class="text-[15px] font-display font-semibold block">{{ stage.title }}</b>
							<div class="text-[13px] text-muted mt-[3px]">Updated {{ application.updated_at }}</div>
						</div>
						<div v-else class="relative">
							<span class="absolute -left-[34px] top-0 w-6 h-6 rounded-full bg-white border-2 border-line text-muted-2 grid place-items-center"></span>
							<b class="text-[15px] font-display font-semibold block text-muted-2">Decision</b>
							<div class="text-[13px] text-muted mt-[3px]">Pending review by {{ application.company.name }}</div>
						</div>
					</div>
				</section>

				<!-- SUBMITTED APPLICATION -->
				<section class="bg-white border border-line rounded-[18px] px-8 py-[30px]">
					<h2 class="font-display text-[18px] font-semibold mb-1.5">{{ isStudent ? 'Your submitted application' : 'Submitted application' }}</h2>
					<p class="text-[13.5px] text-muted mb-[18px]">This is exactly what {{ application.company.name }} received on {{ application.created_at }}.</p>

					<div v-if="application.cover_letter" class="py-4">
						<div class="text-xs tracking-[.06em] uppercase text-muted-2 font-bold mb-2">Cover note</div>
						<p class="text-[15px] leading-[1.7] text-ink-700 whitespace-pre-line">{{ application.cover_letter }}</p>
					</div>

					<div v-if="application.message" class="py-4 border-t border-line-2">
						<div class="text-xs tracking-[.06em] uppercase text-muted-2 font-bold mb-2">Message to the company</div>
						<p class="text-[15px] leading-[1.7] text-ink-700 whitespace-pre-line">{{ application.message }}</p>
					</div>

					<div v-if="application.attachments.length" class="py-4 border-t border-line-2">
						<div class="text-xs tracking-[.06em] uppercase text-muted-2 font-bold mb-2">Attachments</div>
						<div class="flex flex-wrap gap-3 mt-1">
							<a
								v-for="attachment in application.attachments"
								:key="attachment.url || attachment.name"
								class="flex items-center gap-[11px] bg-paper-2 border border-line rounded-[12px] px-[15px] py-3 no-underline hover:border-blue-300 transition-colors"
								:href="attachment.url"
								target="_blank"
								rel="noopener"
							>
								<span class="w-[38px] h-[38px] rounded-[9px] bg-[#fee2e2] text-[#dc2626] grid place-items-center shrink-0 text-[10px] font-extrabold font-display">{{ (attachment.name || '').split('.').pop().slice(0, 3).toUpperCase() || 'DOC' }}</span>
								<span><b class="text-[13.5px] text-ink block font-semibold">{{ attachment.name }}</b><span v-if="attachment.size" class="text-xs text-muted">{{ Math.round(attachment.size / 1024) }} KB</span></span>
								<span class="ml-1.5 text-muted-2 [&_svg]:w-[17px] [&_svg]:h-[17px]" v-html="icons.download"></span>
							</a>
						</div>
					</div>
				</section>
			</div>

			<!-- RIGHT -->
			<div class="flex flex-col gap-4 sticky top-[94px]">
				<section v-if="canReply" class="bg-white border border-line rounded-[18px] px-6 py-[22px]">
					<h3 class="text-sm tracking-[.04em] text-muted font-bold font-display mb-4">REVIEW</h3>
					<button class="w-full justify-center inline-flex items-center gap-2.5 font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-blue-600 text-white hover:bg-blue-700 transition-colors [&_svg]:w-[17px] [&_svg]:h-[17px]" type="button" @click="reply('offer')">
						Advance to offer <span class="contents" v-html="icons.arrow"></span>
					</button>
					<button class="w-full justify-center mt-2.5 inline-flex items-center font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-white text-ink border border-line hover:border-blue-300 hover:text-blue-700 transition-all" type="button" @click="reply('closed')">
						Disqualify
					</button>
				</section>

				<section class="bg-white border border-line rounded-[18px] px-6 py-[22px]">
					<h3 class="text-sm tracking-[.04em] text-muted font-bold font-display mb-4">APPLICATION DETAILS</h3>
					<div class="flex items-center justify-between py-[11px] text-sm"><span class="text-muted">Application ID</span><span class="font-semibold text-ink-700 font-display">#{{ application.id }}</span></div>
					<div class="flex items-center justify-between py-[11px] text-sm border-t border-line-2"><span class="text-muted">Submitted</span><span class="font-semibold text-ink-700 font-display">{{ application.created_at }}</span></div>
					<div class="flex items-center justify-between py-[11px] text-sm border-t border-line-2"><span class="text-muted">Last update</span><span class="font-semibold text-ink-700 font-display">{{ application.updated_at }}</span></div>
					<div class="flex items-center justify-between py-[11px] text-sm border-t border-line-2"><span class="text-muted">Stage</span><span class="font-semibold font-display" :style="{ color: stage.color }">{{ stage.label }}</span></div>
				</section>

				<section class="bg-white border border-line rounded-[18px] px-6 py-[22px]">
					<h3 class="text-sm tracking-[.04em] text-muted font-bold font-display mb-4">{{ isStudent ? 'COMPANY' : 'APPLICANT' }}</h3>
					<div class="flex items-center gap-[13px] mb-4">
						<CompanyLogo class="w-[46px] h-[46px] rounded-[12px] text-base" :name="counterpart.name" />
						<div><b class="font-display text-base block">{{ counterpart.name }}</b><span class="text-[13px] text-muted">{{ counterpart.role }}</span></div>
					</div>
					<div v-if="counterpart.email" class="flex items-center gap-3 py-[9px] text-sm text-ink-700 [&_svg]:w-[17px] [&_svg]:h-[17px] [&_svg]:text-muted-2 [&_svg]:shrink-0"><span class="contents" v-html="icons.mail"></span>{{ counterpart.email }}</div>
					<div v-if="counterpart.phone_number" class="flex items-center gap-3 py-[9px] text-sm text-ink-700 [&_svg]:w-[17px] [&_svg]:h-[17px] [&_svg]:text-muted-2 [&_svg]:shrink-0"><span class="contents" v-html="icons.phone"></span>{{ counterpart.phone_number }}</div>
					<div v-if="counterpart.city?.name" class="flex items-center gap-3 py-[9px] text-sm text-ink-700 [&_svg]:w-[17px] [&_svg]:h-[17px] [&_svg]:text-muted-2 [&_svg]:shrink-0"><span class="contents" v-html="icons.pin"></span>{{ counterpart.city.name }}</div>
					<Link class="w-full justify-center mt-[14px] inline-flex items-center gap-2.5 font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-blue-600 text-white hover:bg-blue-700 transition-colors [&_svg]:w-[17px] [&_svg]:h-[17px]" :href="route('messages.show', counterpart.user_id)">
						{{ isStudent ? 'Message recruiter' : 'Message applicant' }} <span class="contents" v-html="icons.arrow"></span>
					</Link>
				</section>

				<template v-if="isStudent && open">
					<Link class="w-full justify-center inline-flex items-center font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-white text-ink border border-line hover:border-blue-300 hover:text-blue-700 transition-all" :href="route('applications.edit', application.id)">Edit application</Link>
					<button class="w-full justify-center inline-flex items-center font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-white text-[#dc2626] border border-[#fecaca] hover:bg-[#fef2f2] transition-colors" type="button" @click="withdraw">Withdraw application</button>
				</template>
			</div>
		</div>
	</div>
</template>
