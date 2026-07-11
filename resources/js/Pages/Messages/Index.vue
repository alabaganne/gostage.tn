<script setup>
import { computed, h, nextTick, onMounted, ref, watch } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';
import { gradientFor } from '@/utils/brand';

defineOptions({
	layout: (_h, page) => h(AppShell, { active: 'messages', fill: true }, () => page),
});

const props = defineProps({
	contacts: { type: Array, default: () => [] },
	selectedContact: { type: Object, default: null },
});

const icons = {
	search: '<svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3-3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	send: '<svg viewBox="0 0 24 24" fill="none"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
};

const page = usePage();
const me = computed(() => page.props.auth?.user);

const initialsFor = (name) =>
	(name || '')
		.split(/\s+/)
		.map((word) => word[0])
		.filter(Boolean)
		.slice(0, 2)
		.join('')
		.toUpperCase();

const search = ref('');
const visibleContacts = computed(() =>
	props.contacts.filter(
		(contact) => !search.value || contact.name.toLowerCase().includes(search.value.trim().toLowerCase())
	)
);

const isUnread = (contact) =>
	contact.latest_message &&
	contact.latest_message.to_id === me.value?.id &&
	!contact.latest_message.read_at;

const pick = (contact) => {
	router.get(route('messages.index'), { user_id: contact.id }, { preserveState: false, preserveScroll: true });
};

const form = useForm({ to_id: null, text: '' });

const thread = ref(null);
const scrollToBottom = () => nextTick(() => thread.value && (thread.value.scrollTop = thread.value.scrollHeight));

const send = () => {
	if (!form.text.trim() || !props.selectedContact) return;
	form.to_id = props.selectedContact.id;
	form.post(route('messages.store'), {
		preserveScroll: true,
		onSuccess: () => {
			form.reset('text');
			scrollToBottom();
		},
	});
};

watch(() => props.selectedContact?.messages?.length, scrollToBottom);

onMounted(() => {
	scrollToBottom();

	// Realtime messaging is currently disabled.
	// Keep this Echo listener commented out so it can be restored later after
	// broadcast/WebSocket configuration is available again.
	// if (!window.Echo || !me.value) return;
	// window.Echo.private('user.' + me.value.id).listen('.messages', () => {
	// 	if (route().current('messages.index')) router.reload();
	// });
});
</script>

<template>
	<div class="flex-1 grid grid-cols-[340px_1fr] min-h-0 max-[860px]:grid-cols-1">
		<!-- CONVERSATION LIST -->
		<aside class="border-r border-line bg-white flex flex-col min-h-0 max-[860px]:hidden">
			<div class="px-5 pt-5 pb-3.5 border-b border-line-2 shrink-0">
				<div class="flex items-baseline justify-between mb-3.5">
					<h1 class="font-display text-[21px] font-semibold">Messages</h1>
					<span class="text-[13px] text-muted font-medium">{{ contacts.length }} {{ contacts.length === 1 ? 'conversation' : 'conversations' }}</span>
				</div>
				<div class="flex items-center gap-[9px] bg-paper-2 border border-line rounded-[10px] px-3 h-10 focus-within:border-blue-400 [&_svg]:w-4 [&_svg]:h-4 [&_svg]:text-muted-2">
					<span class="contents" v-html="icons.search"></span>
					<input v-model="search" class="border-0 bg-transparent outline-none text-sm w-full" type="text" placeholder="Search conversations">
				</div>
			</div>
			<div class="overflow-y-auto flex-1 min-h-0">
				<div
					v-for="contact in visibleContacts"
					:key="contact.id"
					class="conv"
					:class="{ active: contact.id === selectedContact?.id }"
					@click="pick(contact)"
				>
					<div class="w-[46px] h-[46px] rounded-[12px] shrink-0 grid place-items-center text-white font-bold font-display text-[15px]" :style="{ background: gradientFor(contact.name) }">{{ initialsFor(contact.name) }}</div>
					<div class="flex-1 min-w-0">
						<div class="flex items-baseline justify-between gap-2">
							<b class="text-[14.5px] font-semibold whitespace-nowrap overflow-hidden text-ellipsis">{{ contact.name }}</b>
							<span class="text-[11.5px] text-muted-2 shrink-0 font-medium">{{ contact.latest_message?.created_at }}</span>
						</div>
						<div class="text-xs text-blue-700 font-semibold my-px mb-1 capitalize">{{ contact.userable_type }}</div>
						<div class="prev" :class="{ unread: isUnread(contact) }">{{ contact.latest_message?.text }}</div>
					</div>
				</div>
				<div v-if="!visibleContacts.length" class="px-5 py-8 text-[14px] text-muted">No conversations yet.</div>
			</div>
		</aside>

		<!-- THREAD -->
		<section v-if="selectedContact" class="flex flex-col min-h-0 bg-paper-2">
			<div class="shrink-0 bg-white border-b border-line px-6 py-3.5 flex items-center gap-[13px]">
				<div class="w-11 h-11 rounded-[12px] grid place-items-center text-white font-bold font-display text-[15px]" :style="{ background: gradientFor(selectedContact.name) }">{{ initialsFor(selectedContact.name) }}</div>
				<div class="flex-1 min-w-0">
					<b class="text-base font-semibold block">{{ selectedContact.name }}</b>
					<span class="text-[12.5px] text-muted">{{ selectedContact.email }}</span>
				</div>
			</div>

			<div ref="thread" class="flex-1 overflow-y-auto px-6 py-[22px] flex flex-col gap-1 min-h-0">
				<div
					v-for="message in selectedContact.messages || []"
					:key="message.id"
					class="bubble"
					:class="message.from_id === me?.id ? 'me' : 'them'"
				>{{ message.text }}<span class="time">{{ message.created_at }}</span></div>
			</div>

			<div class="shrink-0 bg-white border-t border-line px-6 py-3.5 flex items-end gap-3">
				<div class="flex-1 flex items-center bg-paper-2 border border-line rounded-[13px] px-4 min-h-[46px] focus-within:border-blue-400">
					<input v-model="form.text" class="border-0 bg-transparent outline-none text-[14.5px] w-full py-3 text-ink" type="text" placeholder="Write a message…" @keydown.enter="send">
				</div>
				<button class="w-[46px] h-[46px] rounded-[13px] bg-blue-600 text-white border-0 grid place-items-center cursor-pointer shrink-0 hover:bg-blue-700 transition-colors [&_svg]:w-[19px] [&_svg]:h-[19px]" :disabled="form.processing" @click="send" v-html="icons.send"></button>
			</div>
		</section>

		<section v-else class="flex flex-col items-center justify-center min-h-0 bg-paper-2 text-center px-6">
			<h3 class="font-display text-xl font-semibold mb-2">No conversation selected</h3>
			<p class="text-muted text-[15px] max-w-[340px]">Message a company from an internship or application page and the conversation will show up here.</p>
		</section>
	</div>
</template>
