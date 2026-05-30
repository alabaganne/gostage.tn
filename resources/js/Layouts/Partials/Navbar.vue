<template>
	<nav class="bg-white h-20 flex justify-between items-center px-4 md:px-6 border-b border-gray-100 sticky top-0 z-30">
		<button @click="toggleSidebar" class="p-2 hover:text-blue-700 hover:bg-blue-50 rounded-xl">
			<icon name="menu" solid />
		</button>
		<div class="hidden md:block text-sm text-gray-500">
			<span class="font-bold text-gray-900">Internly</span> · {{ currentUser.userable_type }} workspace
		</div>
		<div class="flex items-center space-x-2">
			<inertia-link v-if="currentUser.userable_type === 'student'" :href="route('likes.index')" class="p-2 hover:bg-blue-50 rounded-xl block" :class="{ 'text-red-600 hover:bg-red-50': currentUser.likes_count > 0 }">
				<icon name="heart" solid />
			</inertia-link>
			<inertia-link v-if="['student', 'company'].includes(currentUser.userable_type)" :href="route('messages.index')" class="p-2 hover:bg-blue-50 rounded-xl">
				<icon name="chat-alt-2" solid />
			</inertia-link>
			<notifications-slide-over :key="routeUrl" />
			<breeze-dropdown width="w-80">
				<template v-slot:trigger>
					<button class="pl-2 pr-1 py-1 flex items-center gap-3 rounded-full border border-gray-200 hover:border-blue-200 hover:bg-blue-50 text-sm">
						<span class="hidden sm:block font-bold text-gray-700">{{ currentUser.name }}</span>
						<span class="h-9 w-9 rounded-full bg-blue-600 text-white grid place-items-center font-bold">{{ initials }}</span>
					</button>
				</template>
				<template v-slot:content>
					<div class="flex items-center px-5 py-4">
						<div class="h-12 w-12 rounded-full bg-blue-600 text-white grid place-items-center font-bold">{{ initials }}</div>
						<div class="ml-3 min-w-0">
							<div class="font-medium truncate">{{ currentUser.name }}</div>
							<div class="text-sm leading-none text-gray-500 truncate">{{ currentUser.email }}</div>
						</div>
					</div>
					<breeze-dropdown-link v-if="currentUser.is_admin" href="#">Manage Users</breeze-dropdown-link>
					<breeze-dropdown-link :href="route('profile.show')">My Profile</breeze-dropdown-link>
					<breeze-dropdown-link :href="route('logout')" as="button" method="POST">Logout</breeze-dropdown-link>
				</template>
			</breeze-dropdown>
		</div>
	</nav>
</template>

<script>
import BreezeDropdown from '@/Components/Breeze/Dropdown';
import BreezeDropdownLink from '@/Components/Breeze/DropdownLink';
import NotificationsSlideOver from './NotificationsSlideOver';
import { mapActions, mapGetters } from 'vuex';

export default {
	components: { BreezeDropdown, BreezeDropdownLink, NotificationsSlideOver },
	computed: {
		...mapGetters(['sidebarActive']),
		initials() { return (this.currentUser.name || 'IN').split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase() }
	},
	methods: { ...mapActions(['toggleSidebar']) },
};
</script>
