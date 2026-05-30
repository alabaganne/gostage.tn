<template>
	<div class="w-96 flex-shrink-0 bg-white border-r border-gray-100 flex flex-col hidden md:flex">
		<div class="flex-shrink-0">
			<div class="px-5 h-20 flex items-center border-b border-gray-100">
				<div>
					<h3 class="in-heading text-lg font-bold text-gray-900">Conversations</h3>
					<p class="max-w-2xl text-sm font-medium text-gray-500">{{ contacts.length }} conversations</p>
				</div>
			</div>
			<div class="px-5 py-3 bg-gray-50 text-gray-500 font-bold text-xs uppercase tracking-widest flex items-center">
				<icon name="sort-descending" class="h-5 w-5 mr-2 text-gray-400" /> Sorted by date
			</div>
		</div>
		<div class="border-t border-gray-100 flex-1 overflow-y-auto" scroll-region>
			<template v-if="contacts.length > 0">
				<inertia-link class="text-left hover:bg-blue-50 p-4 flex items-start w-full border-b border-gray-100 transition" v-for="contact in contacts" :key="contact.id" :href="route('messages.index', { user_id: contact.id })" :class="{ 'bg-blue-50': contact.id === selectedContactId }" preserve-scroll>
					<div class="h-11 w-11 rounded-2xl bg-blue-50 text-blue-700 grid place-items-center font-bold flex-shrink-0">{{ initials(contact.name) }}</div>
					<div class="ml-3 min-w-0">
						<div class="font-bold truncate">{{ contact.name }}</div>
						<p class="text-gray-500 text-sm truncate">{{ truncate(contact.latest_message.text, 85) }}</p>
						<span class="mt-1 text-xs text-blue-600 font-bold">{{ contact.latest_message.created_at }}</span>
					</div>
				</inertia-link>
			</template>
			<div v-else class="p-4 text-sm text-gray-700">No messages found</div>
		</div>
	</div>
</template>

<script>
export default {
	emits: ['select-contact'],
	props: { contacts: { type: Array, required: true }, selectedContactId: Number },
	methods: { initials(name) { return (name || 'IN').split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase() } }
}
</script>
