<template>
	<div class="flex-1 max-h-full flex flex-col min-w-0">
		<div class="h-20 px-6 bg-white flex justify-between items-center border-b border-gray-100">
			<template v-if="contact">
				<div class="flex items-center min-w-0">
					<div class="h-12 w-12 rounded-2xl bg-blue-600 text-white grid place-items-center font-bold flex-shrink-0">{{ initials(contact.name) }}</div>
					<div class="ml-3 min-w-0">
						<div class="leading-5 text-lg font-bold truncate">{{ contact.name }}</div>
						<div class="text-gray-500 text-sm truncate">{{ contact.email }}</div>
					</div>
				</div>
			</template>
			<div v-else class="font-bold text-gray-600">No contact selected</div>
		</div>
		<div v-if="contact" class="flex-1 p-6 space-y-4 overflow-auto bg-gray-50" scroll-region ref="messagesContainer">
			<div class="flex" v-for="message in contact.messages" :key="message.id">
				<div class="flex flex-col" :class="{ 'ml-auto text-right': sentMessage(message) }">
					<div class="px-1 mb-1 text-gray-500 text-xs font-bold">{{ sentMessage(message) ? 'You' : contact.name }}</div>
					<div class="p-4 max-w-lg rounded-2xl border text-left" :class="sentMessage(message) ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-900 border-gray-100'">
						<div class="text-sm leading-6">{{ message.text }}</div>
						<div class="mt-2 text-xs font-bold" :class="sentMessage(message) ? 'text-blue-100' : 'text-blue-600'">{{ message.created_at }}</div>
					</div>
				</div>
			</div>
		</div>
		<form v-if="contact" @submit.prevent="sendMessage" class="border-t border-gray-100 bg-white mt-auto p-3 flex items-center gap-3">
			<input v-model="newMessage" type="text" class="in-input text-sm" placeholder="Write a message" />
			<button type="submit" class="in-btn in-btn-primary flex-shrink-0">Send →</button>
		</form>
	</div>
</template>

<script>
import { nextTick } from 'vue';

export default {
	props: { contact: { type: Object, required: false } },
	data() { return { newMessage: '' } },
	watch: { contact: { handler() { this.scrollToBottom(); }, deep: true } },
	mounted() { this.scrollToBottom(); },
	methods: {
		sendMessage() {
			if(this.newMessage === '') return;
			this.$inertia.post(this.route('messages.store'), { to_id: this.contact.id, text: this.newMessage }, { preserveScroll: true, onSuccess: () => { this.newMessage = '' } });
		},
		async scrollToBottom() {
			await nextTick();
			if (!this.$refs.messagesContainer) return;
			this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight - this.$refs.messagesContainer.clientHeight;
		},
		sentMessage(message) { return this.currentUser.id === message.from_id; },
		initials(name) { return (name || 'IN').split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase() },
	}
}
</script>
