<script setup>
import { computed, ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';

const icons = {
	search: '<svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3-3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	messages: '<svg viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
	bell: '<svg viewBox="0 0 24 24" fill="none"><path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9M13.7 21a2 2 0 01-3.4 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
};

const page = usePage();
const isCompany = computed(() => page.props.auth?.user?.userable_type === 'company');

const action = computed(() =>
	isCompany.value
		? { label: 'Post internship', route: 'internships.create' }
		: { label: 'Find internships', route: 'internships.index' }
);

const hasUnreadNotifications = computed(
	() => (page.props.auth?.user?.notifications?.unread_count || 0) > 0
);

const search = ref('');

const submitSearch = () => {
	router.get(route('internships.index'), search.value ? { search: search.value } : {});
};
</script>

<template>
	<header class="h-[70px] bg-white border-b border-line flex items-center justify-between gap-[18px] px-8 max-[680px]:px-[18px] sticky top-0 z-20">
		<div class="flex items-center gap-2 flex-1 min-w-0 max-w-[520px]">
			<label class="flex items-center gap-2.5 bg-paper-2 border border-line rounded-[11px] px-3.5 h-[42px] flex-1 min-w-0 focus-within:border-blue-400 [&_svg]:w-[17px] [&_svg]:h-[17px] [&_svg]:text-muted-2 [&_svg]:shrink-0">
				<span class="contents" v-html="icons.search"></span>
				<input
					v-model="search"
					class="border-0 bg-transparent outline-none text-sm w-full"
					type="text"
					placeholder="Search internships, companies…"
					@keyup.enter="submitSearch"
				>
			</label>
			<button
				class="inline-flex items-center justify-center font-semibold text-[15px] px-5 h-[42px] rounded-[12px] bg-blue-600 text-white hover:bg-blue-700 transition-colors whitespace-nowrap max-[680px]:hidden"
				type="button"
				@click="submitSearch"
			>Search</button>
		</div>
		<div class="flex items-center gap-2.5 shrink-0">
			<Link
				class="inline-flex items-center justify-center font-semibold text-[15px] px-[22px] h-[42px] rounded-[12px] bg-blue-600 text-white hover:bg-blue-700 transition-colors whitespace-nowrap"
				:href="route(action.route)"
			>{{ action.label }}</Link>
			<Link
				class="w-[42px] h-[42px] rounded-[11px] border border-line bg-white grid place-items-center text-ink-700 hover:border-blue-300 hover:text-blue-700 transition-colors [&_svg]:w-[19px] [&_svg]:h-[19px]"
				:href="route('messages.index')"
				title="Messages"
				aria-label="Messages"
				v-html="icons.messages"
			></Link>
			<button
				class="w-[42px] h-[42px] rounded-[11px] border border-line bg-white grid place-items-center text-ink-700 hover:border-blue-300 hover:text-blue-700 transition-colors relative [&_svg]:w-[19px] [&_svg]:h-[19px]"
				type="button"
				title="Notifications"
				aria-label="Notifications"
				@click="$emit('notifications')"
			>
				<span v-if="hasUnreadNotifications" class="absolute top-2 right-[9px] w-2 h-2 rounded-full bg-red-500 border-2 border-white"></span>
				<span class="contents" v-html="icons.bell"></span>
			</button>
		</div>
	</header>
</template>
