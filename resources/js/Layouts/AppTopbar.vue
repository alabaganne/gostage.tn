<script setup>
import { computed, ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { Bell, MessageSquare, Search } from 'lucide-vue-next';

defineEmits(['notifications']);

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
			<label class="flex items-center gap-2.5 bg-paper-2 border border-line rounded-[11px] px-3.5 h-[42px] flex-1 min-w-0 focus-within:border-blue-400 [&_svg]:text-muted-2 [&_svg]:shrink-0">
				<Search :size="17" />
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
				class="w-[42px] h-[42px] rounded-[11px] border border-line bg-white grid place-items-center text-ink-700 hover:border-blue-300 hover:text-blue-700 transition-colors"
				:href="route('messages.index')"
				title="Messages"
				aria-label="Messages"
			><MessageSquare :size="19" /></Link>
			<button
				class="w-[42px] h-[42px] rounded-[11px] border border-line bg-white grid place-items-center text-ink-700 hover:border-blue-300 hover:text-blue-700 transition-colors relative"
				type="button"
				title="Notifications"
				aria-label="Notifications"
				@click="$emit('notifications')"
			>
				<span v-if="hasUnreadNotifications" class="absolute top-2 right-[9px] w-2 h-2 rounded-full bg-red-500 border-2 border-white"></span>
				<Bell :size="19" />
			</button>
		</div>
	</header>
</template>
