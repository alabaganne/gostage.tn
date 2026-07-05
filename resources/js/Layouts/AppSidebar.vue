<script setup>
import { computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';

defineProps({
	active: { type: String, default: '' },
});

// Line icons from the design bundle (design/tailwind/workspace-shell.js).
const icons = {
	logo: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	dashboard: '<svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="9" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="14" y="3" width="7" height="5" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="14" y="12" width="7" height="9" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="3" y="16" width="7" height="5" rx="1.5" stroke="currentColor" stroke-width="2"/></svg>',
	applications: '<svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	internships: '<svg viewBox="0 0 24 24" fill="none"><rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" stroke-width="2"/><path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2" stroke="currentColor" stroke-width="2"/></svg>',
	saved: '<svg viewBox="0 0 24 24" fill="none"><path d="M6 4h12v16l-6-4-6 4z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	messages: '<svg viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	companies: '<svg viewBox="0 0 24 24" fill="none"><path d="M3 21V8l7-5 7 5v13M9 21v-6h2v6M3 21h18" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	profile: '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	settings: '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/><path d="M19 12a7 7 0 00-.1-1l2-1.5-2-3.5-2.4 1a7 7 0 00-1.7-1l-.4-2.5h-4l-.4 2.5a7 7 0 00-1.7 1l-2.4-1-2 3.5L4 11a7 7 0 000 2l-2 1.5 2 3.5 2.4-1a7 7 0 001.7 1l.4 2.5h4l.4-2.5a7 7 0 001.7-1l2.4 1 2-3.5-2-1.5a7 7 0 00.1-1z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	logout: '<svg viewBox="0 0 24 24" fill="none"><path d="M15 4h3a2 2 0 012 2v12a2 2 0 01-2 2h-3M10 17l-5-5 5-5M5 12h12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
};

const groups = [
	{
		label: 'Workspace',
		items: [
			{ id: 'dashboard', label: 'Dashboard', route: 'dashboard' },
			{ id: 'applications', label: 'Applications', route: 'applications.index' },
			{ id: 'internships', label: 'Internships', route: 'internships.index' },
			{ id: 'saved', label: 'Saved roles', route: 'likes.index' },
			{ id: 'messages', label: 'Messages', route: 'messages.index' },
			{ id: 'companies', label: 'Companies', route: 'companies.index' },
		],
	},
	{
		label: 'Account',
		items: [
			{ id: 'profile', label: 'Profile', route: 'profile.show' },
			{ id: 'settings', label: 'Settings', route: 'settings' },
		],
	},
];

const page = usePage();
const user = computed(() => page.props.auth?.user);
const isCompany = computed(() => user.value?.userable_type === 'company');
const tag = computed(() => (isCompany.value ? 'COMPANY WORKSPACE' : 'STUDENT WORKSPACE'));
const roleLabel = computed(() => (isCompany.value ? 'Company' : 'Student'));

const initials = computed(() =>
	(user.value?.name || '')
		.split(' ')
		.map((w) => w[0])
		.filter(Boolean)
		.slice(0, 2)
		.join('')
		.toUpperCase()
);

// Counts arrive via the shared `badges` prop; `saved` falls back to the
// like count that is already shared on auth.user.
const badge = (item) => {
	const badges = page.props.badges || {};
	if (badges[item.id]) return badges[item.id];
	if (item.id === 'saved') return user.value?.likes_count || null;
	return null;
};

const hrefFor = (item) => (route().has(item.route) ? route(item.route) : '#');

const logout = () => router.post(route('logout'));
</script>

<template>
	<aside class="flex flex-col sticky top-0 h-screen bg-navy-900 text-[#aeb9cf] px-4 py-[22px]">
		<Link class="flex items-center gap-[11px] px-2 pt-1.5 pb-[26px]" :href="route('home')">
			<span class="w-[38px] h-[38px] rounded-[11px] grid place-items-center text-white bg-gradient-to-br from-blue-400 to-blue-700 [&_svg]:w-[21px] [&_svg]:h-[21px]" v-html="icons.logo"></span>
			<span><b class="block font-display text-[19px] font-semibold tracking-tight text-white">Internly</b><small class="block text-[10px] tracking-[.16em] text-[#7c89a3] font-semibold -mt-0.5">{{ tag }}</small></span>
		</Link>

		<template v-for="group in groups" :key="group.label">
			<div class="text-[11px] tracking-[.13em] uppercase text-[#5d6a85] font-bold px-3 pt-[18px] pb-2">{{ group.label }}</div>
			<nav class="flex flex-col gap-[3px]">
				<Link
					v-for="item in group.items"
					:key="item.id"
					class="flex items-center gap-3 px-[13px] py-[11px] rounded-[11px] text-[14.5px] font-medium transition-colors [&_svg]:w-[19px] [&_svg]:h-[19px] [&_svg]:shrink-0"
					:class="item.id === active ? 'bg-blue-600 text-white' : 'text-[#aeb9cf] hover:bg-white/[.06] hover:text-white'"
					:href="hrefFor(item)"
				>
					<span class="contents" v-html="icons[item.id]"></span>
					<span>{{ item.label }}</span>
					<span
						v-if="badge(item)"
						class="ml-auto text-[11px] font-bold text-white min-w-[20px] h-5 rounded-full grid place-items-center px-1.5"
						:class="item.id === active ? 'bg-white/25' : 'bg-blue-600'"
					>{{ badge(item) }}</span>
				</Link>
			</nav>
		</template>

		<div class="flex-1"></div>
		<div class="flex items-center gap-[11px] px-3 py-[11px] rounded-[12px] bg-white/5 mt-2">
			<span class="w-9 h-9 rounded-full grid place-items-center text-white font-bold font-display text-sm bg-gradient-to-br from-blue-300 to-blue-700 shrink-0">{{ initials }}</span>
			<div class="min-w-0">
				<b class="block text-white text-[13.5px] truncate">{{ user?.name }}</b>
				<span class="text-xs text-[#7c89a3]">{{ roleLabel }}</span>
			</div>
			<button
				class="ml-auto w-[34px] h-[34px] rounded-[9px] grid place-items-center text-[#7c89a3] bg-transparent border-0 cursor-pointer transition-colors hover:bg-red-500/[.16] hover:text-red-300 [&_svg]:w-[18px] [&_svg]:h-[18px]"
				type="button"
				title="Log out"
				aria-label="Log out"
				@click="logout"
				v-html="icons.logout"
			></button>
		</div>
	</aside>
</template>
