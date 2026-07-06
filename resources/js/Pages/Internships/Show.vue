<script>
import { h } from 'vue';
import AppShell from '@/Layouts/AppShell.vue';
import MarketingLayout from '@/Layouts/MarketingLayout.vue';

export default {
	layout: (_h, page) =>
		page.props?.auth?.user
			? h(AppShell, { active: 'internships' }, () => page)
			: h(MarketingLayout, { active: 'browse', solid: true }, () => page),
};
</script>

<script setup>
import { computed, ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import CompanyLogo from '@/Components/Ui/CompanyLogo.vue';

const props = defineProps({
	internship: { type: Object, required: true },
});

const icons = {
	chevron: '<svg viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	pin: '<svg viewBox="0 0 24 24" fill="none"><path d="M12 21s7-5.5 7-11a7 7 0 10-14 0c0 5.5 7 11 7 11z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="2"/></svg>',
	calendar: '<svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="17" rx="2" stroke="currentColor" stroke-width="2"/><path d="M3 9h18M8 2v4M16 2v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	clock: '<svg viewBox="0 0 24 24" fill="none"><path d="M12 8v4l3 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/></svg>',
	check: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	heart: '<svg viewBox="0 0 24 24" fill="none"><path d="M12 21s-7-4.6-9.5-9C1 9 2.5 5.5 6 5.5c2 0 3.2 1.2 4 2.3.8-1.1 2-2.3 4-2.3 3.5 0 5 3.5 3.5 6.5C19 16.4 12 21 12 21z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	arrow: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	warning: '<svg viewBox="0 0 24 24" fill="none"><path d="M12 9v4M12 17h.01M10.3 3.9 1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	mail: '<svg viewBox="0 0 24 24" fill="none"><rect x="4" y="5" width="16" height="14" rx="2" stroke="currentColor" stroke-width="2"/><path d="M4 8l8 5 8-5" stroke="currentColor" stroke-width="2"/></svg>',
	phone: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 005 5L20 13l1 4v2a1 1 0 01-1 1A16 16 0 014 4a1 1 0 011-1z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	external: '<svg viewBox="0 0 24 24" fill="none"><path d="M7 17L17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	lock: '<svg viewBox="0 0 24 24" fill="none"><rect x="4" y="10" width="16" height="11" rx="2" stroke="currentColor" stroke-width="2"/><path d="M8 10V7a4 4 0 018 0v3" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="15.5" r="1.6" fill="currentColor"/></svg>',
	close: '<svg viewBox="0 0 24 24" fill="none"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
};

const page = usePage();
const user = computed(() => page.props.auth?.user);
const isStudent = computed(() => user.value?.userable_type === 'student');
const ownsIt = computed(
	() => user.value?.userable_type === 'company' && user.value?.userable_id === props.internship.company.id
);

// Description can be stored as HTML or plain text with newlines.
const descriptionHtml = computed(() => {
	const text = props.internship.description || '';
	if (/<[a-z][\s\S]*>/i.test(text)) return text;
	return text
		.split(/\n{2,}|\n/)
		.filter(Boolean)
		.map((paragraph) => `<p>${paragraph}</p>`)
		.join('');
});

const WORK_TYPES = { remote: 'Remote', hybrid: 'Hybrid', onsite: 'On-site' };

const showLoginModal = ref(false);
const openLoginModal = () => (showLoginModal.value = true);
const closeLoginModal = () => (showLoginModal.value = false);

const toggleLike = () => {
	if (!user.value) return openLoginModal();
	router.post(route('likes.store', props.internship.id), {}, { preserveScroll: true });
};
</script>

<template>
	<!-- Breadcrumb -->
	<div :class="user ? 'px-10 pt-7 pb-14 w-full max-w-wrap mx-auto' : ''">
		<template v-if="!user">
			<section class="bg-white border-b border-line pt-[26px]">
				<div class="max-w-wrap mx-auto px-7">
					<div class="flex items-center gap-2 text-[13.5px] text-muted font-medium pb-[22px] [&_svg]:w-3.5 [&_svg]:h-3.5 [&_svg]:text-muted-2">
						<Link class="hover:text-blue-700" :href="route('internships.index')">Internships</Link>
						<span class="contents" v-html="icons.chevron"></span>
						<span class="text-ink-700 font-semibold">{{ internship.title }}</span>
					</div>
				</div>
			</section>
		</template>
		<div v-else class="flex items-center gap-2 text-[13.5px] text-muted font-medium mb-[22px] [&_svg]:w-3.5 [&_svg]:h-3.5 [&_svg]:text-muted-2">
			<Link class="hover:text-blue-700" :href="route('internships.index')">Internships</Link>
			<span class="contents" v-html="icons.chevron"></span>
			<span class="text-ink-700 font-semibold">{{ internship.title }}</span>
		</div>

		<div :class="user ? '' : 'max-w-wrap mx-auto px-7'">
			<div class="grid grid-cols-[1fr_350px] gap-6 items-start max-[1080px]:grid-cols-1" :class="{ 'pt-7 pb-20': !user }">
				<!-- LEFT -->
				<div class="flex flex-col gap-4">
					<section class="bg-white border border-line rounded-[18px] overflow-hidden px-8 py-[30px]">
						<div class="flex items-start gap-[18px]">
							<CompanyLogo class="w-[62px] h-[62px] rounded-[16px] text-[22px]" :name="internship.company.name" />
							<div>
								<h1 class="font-display text-[28px] font-semibold leading-[1.1]">{{ internship.title }}</h1>
								<p class="text-[15px] text-muted mt-1.5"><b class="text-ink-700 font-semibold">{{ internship.company.name }}</b> · {{ internship.field.name }}</p>
							</div>
						</div>
						<div class="flex flex-wrap gap-2.5 mt-[22px] [&_.m]:flex [&_.m]:items-center [&_.m]:gap-[7px] [&_.m]:text-[13.5px] [&_.m]:text-ink-700 [&_.m]:font-medium [&_.m]:bg-paper-2 [&_.m]:border [&_.m]:border-line-2 [&_.m]:px-[13px] [&_.m]:py-2 [&_.m]:rounded-[9px] [&_svg]:w-[15px] [&_svg]:h-[15px] [&_svg]:text-blue-600">
							<span class="m"><span class="contents" v-html="icons.pin"></span>{{ internship.city.name }}<template v-if="internship.work_type"> · {{ WORK_TYPES[internship.work_type] || internship.work_type }}</template></span>
							<span v-if="internship.duration_weeks" class="m"><span class="contents" v-html="icons.clock"></span>{{ internship.duration_weeks }} weeks</span>
							<span class="m"><span class="contents" v-html="icons.calendar"></span>Posted {{ internship.created_at }}</span>
							<span class="m"><span class="contents" v-html="icons.clock"></span>Closing {{ internship.closing_at }}</span>
						</div>
					</section>

					<section class="dbody bg-white border border-line rounded-[18px] px-8 py-[30px] [&_h2]:font-display [&_h2]:text-[18px] [&_h2]:font-semibold [&_h2]:mb-3.5 [&_h2:not(:first-child)]:mt-[30px] [&_p]:text-[15.5px] [&_p]:leading-[1.7] [&_p]:text-ink-700 [&_p]:mb-3.5">
						<div v-html="descriptionHtml"></div>
						<template v-if="internship.skills?.length">
							<div class="h-px bg-line-2 my-[30px]"></div>
							<h2>Skills &amp; expertise</h2>
							<div class="flex flex-wrap gap-2 [&>span]:text-[13px] [&>span]:px-[13px] [&>span]:py-[7px] [&>span]:rounded-lg [&>span]:font-semibold [&>span]:bg-blue-50 [&>span]:text-blue-700">
								<span v-for="skill in internship.skills" :key="skill">{{ skill }}</span>
							</div>
						</template>
					</section>
				</div>

				<!-- RIGHT -->
				<div class="flex flex-col gap-4 sticky top-[94px]">
					<section class="bg-white border border-line rounded-[18px] p-6">
						<template v-if="internship.pay">
							<div class="flex items-baseline gap-2 mb-1"><b class="font-display text-[30px] font-semibold">${{ internship.pay.amount }}</b><span class="text-sm text-muted">/ {{ internship.pay.unit }}</span></div>
							<p class="text-[13.5px] text-muted mb-5">Paid internship<template v-if="internship.term"> · {{ internship.term }}</template></p>
						</template>
						<!-- Company managing its own role -->
						<template v-if="ownsIt">
							<Link class="w-full justify-center inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-blue-600 text-white hover:bg-blue-700 transition-colors [&_svg]:w-[17px] [&_svg]:h-[17px]" :href="route('internships.applications.index', internship.id)">
								View applicants <span class="contents" v-html="icons.arrow"></span>
							</Link>
							<Link class="w-full justify-center mt-2.5 inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-white text-ink border border-line hover:border-blue-300 hover:text-blue-700 transition-colors" :href="route('internships.edit', internship.id)">
								Edit role
							</Link>
						</template>

						<!-- Student who already applied -->
						<template v-else-if="internship.application">
							<div class="flex items-center gap-2.5 w-full justify-center bg-[#dcfce7] text-[#047857] font-semibold text-[14.5px] py-3.5 rounded-[12px] mb-2.5 [&_svg]:w-[18px] [&_svg]:h-[18px]">
								<span class="contents" v-html="icons.check"></span>
								Applied on {{ internship.application.created_at }}
							</div>
							<button
								class="w-full justify-center mt-2.5 inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] transition-colors [&_svg]:w-[17px] [&_svg]:h-[17px]"
								:class="internship.liked ? 'bg-[#fef2f2] border border-[#fecaca] text-[#dc2626]' : 'bg-white text-ink border border-line hover:border-blue-300 hover:text-blue-700'"
								type="button"
								@click="toggleLike"
							>
								<span class="contents" v-html="icons.heart"></span>
								{{ internship.liked ? 'Saved' : 'Save this role' }}
							</button>
						</template>

						<!-- Everyone else: guest or student who hasn't applied -->
						<template v-else>
							<component
								:is="user && isStudent ? Link : 'button'"
								class="w-full justify-center inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-blue-600 text-white hover:bg-blue-700 transition-colors [&_svg]:w-[17px] [&_svg]:h-[17px]"
								v-bind="user && isStudent ? { href: route('applications.create', internship.id) } : { type: 'button' }"
								@click="!user && openLoginModal()"
							>
								Apply now <span class="contents" v-html="icons.arrow"></span>
							</component>
							<button
								v-if="!user || isStudent"
								class="w-full justify-center mt-2.5 inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] transition-colors [&_svg]:w-[17px] [&_svg]:h-[17px]"
								:class="internship.liked ? 'bg-[#fef2f2] border border-[#fecaca] text-[#dc2626]' : 'bg-white text-ink border border-line hover:border-blue-300 hover:text-blue-700'"
								type="button"
								@click="toggleLike"
							>
								<span class="contents" v-html="icons.heart"></span>
								{{ internship.liked ? 'Saved' : 'Save this role' }}
							</button>
						</template>

						<div class="flex items-center gap-[9px] mt-[18px] pt-[18px] border-t border-line-2 text-[13.5px] text-muted [&_svg]:w-4 [&_svg]:h-4 [&_svg]:text-[#d97706]">
							<span class="contents" v-html="icons.warning"></span>
							<span>Applications close on <b class="text-ink-700 font-semibold">{{ internship.closing_at }}</b></span>
						</div>
					</section>

					<section class="bg-white border border-line rounded-[18px] p-6">
						<div class="flex items-center gap-[13px] mb-[18px]">
							<CompanyLogo class="w-[46px] h-[46px] rounded-[12px] text-base" :name="internship.company.name" />
							<div><b class="font-display text-base block">{{ internship.company.name }}</b><span class="text-[13px] text-muted">{{ internship.company.city?.name }}</span></div>
						</div>
						<div class="flex flex-col gap-0.5 [&_.ci]:flex [&_.ci]:items-center [&_.ci]:gap-3 [&_.ci]:py-2.5 [&_.ci]:text-sm [&_.ci]:text-ink-700 [&_svg]:w-[17px] [&_svg]:h-[17px] [&_svg]:text-muted-2 [&_svg]:shrink-0">
							<div v-if="internship.company.email" class="ci"><span class="contents" v-html="icons.mail"></span>{{ internship.company.email }}</div>
							<div v-if="internship.company.phone_number" class="ci"><span class="contents" v-html="icons.phone"></span>{{ internship.company.phone_number }}</div>
							<div v-if="internship.company.city?.name" class="ci"><span class="contents" v-html="icons.pin"></span>{{ internship.company.city.name }}</div>
						</div>
						<a v-if="internship.company.website" class="inline-flex items-center gap-[7px] mt-3.5 text-sm font-semibold text-blue-700 [&_svg]:w-[15px] [&_svg]:h-[15px]" :href="internship.company.website" target="_blank" rel="noopener">
							Visit website <span class="contents" v-html="icons.external"></span>
						</a>
					</section>
				</div>
			</div>
		</div>
	</div>

	<!-- LOGIN-REQUIRED MODAL -->
	<Teleport to="body">
		<div
			v-if="showLoginModal"
			class="fixed inset-0 bg-navy-900/55 backdrop-blur-[3px] flex items-center justify-center z-[100] p-6"
			@click.self="closeLoginModal"
			@keydown.esc="closeLoginModal"
		>
			<div class="relative bg-white rounded-[20px] max-w-[420px] w-full px-[34px] py-9 text-center">
				<button class="absolute top-[18px] right-[18px] w-9 h-9 rounded-[10px] border-0 bg-paper-2 text-muted grid place-items-center cursor-pointer hover:bg-paper-3 hover:text-ink [&_svg]:w-[18px] [&_svg]:h-[18px]" aria-label="Close" @click="closeLoginModal" v-html="icons.close"></button>
				<div class="w-[62px] h-[62px] rounded-[17px] bg-blue-50 text-blue-600 grid place-items-center mx-auto mb-5 [&_svg]:w-[30px] [&_svg]:h-[30px]" v-html="icons.lock"></div>
				<h3 class="font-display text-[22px] font-semibold mb-2.5">Log in to apply</h3>
				<p class="text-[15px] text-muted leading-[1.6] mb-[26px]">You need an Internly account to apply for this internship and track your application. It only takes a minute.</p>
				<div class="flex flex-col gap-2.5">
					<Link class="w-full justify-center inline-flex items-center font-semibold text-base px-7 py-4 rounded-[13px] bg-blue-600 text-white hover:bg-blue-700 transition-colors" :href="route('login')">Log in</Link>
					<Link class="w-full justify-center inline-flex items-center font-semibold text-base px-7 py-4 rounded-[13px] bg-white text-ink border border-line hover:border-blue-300 hover:text-blue-700 transition-colors" :href="route('register')">Create an account</Link>
				</div>
			</div>
		</div>
	</Teleport>
</template>
