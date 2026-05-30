<template>
	<div class="flex-1 flex flex-col overflow-hidden p-5 md:p-8" style="max-height: calc(100vh - 80px);">
		<div class="mb-5 flex items-end justify-between gap-4">
			<div>
				<div class="text-blue-700 text-xs font-extrabold uppercase tracking-widest">Inbox</div>
				<h1 class="in-display mt-1 text-3xl font-bold text-gray-900">Messages</h1>
			</div>
			<inertia-link :href="route('internships.index')" class="in-btn in-btn-ghost text-sm">Browse roles</inertia-link>
		</div>
		<div class="in-panel flex-1 min-h-0 flex flex-row overflow-hidden">
			<contacts-list :contacts="contacts" :selectedContactId="selectedContact?.id" />
			<conversation :contact="selectedContact" />
		</div>
	</div>
</template>

<script>
import ContactsList from "./ContactsList";
import Conversation from "./Conversation";

export default {
	components: { Conversation, ContactsList },
	props: { contacts: Array, selectedContact: Object },
	mounted() {
		for(let i = 0; i < this.contacts.length; i++) {
			if(this.contacts[i].id === this.route().params.user_id) {
				this.selectedContact = this.contacts[i];
				break;
			}
		}
		if (!window.Echo) return;
		window.Echo.private('user.' + this.currentUser.id).listen('.messages', message => {
			if(route().current('messages.index')) this.$inertia.reload();
		});
	},
}
</script>
