<template>
	<header class="topbar">
		<div class="searchgroup">
			<div class="search"><input type="text" placeholder="Search internships, companies…"></div>
			<button class="btn btn-primary searchbtn" type="button">
				<icon name="search" /> Search
			</button>
		</div>
		<div class="tb-right">
			<inertia-link v-if="currentUser.userable_type === 'student'" :href="route('likes.index')" class="iconbtn"><icon name="heart" solid /><span v-if="currentUser.likes_count > 0" class="badge"></span></inertia-link>
			<inertia-link v-if="['student', 'company'].includes(currentUser.userable_type)" :href="route('messages.index')" class="iconbtn"><icon name="mail" /></inertia-link>
			<notifications-slide-over :key="routeUrl" />
			<breeze-dropdown width="w-80">
				<template v-slot:trigger>
					<button class="iconbtn" style="width:auto;padding:0 12px;gap:9px"><span style="width:28px;height:28px;border-radius:50%;background:linear-gradient(140deg,var(--blue-300),var(--blue-700));display:grid;place-items:center;color:#fff;font-weight:700;font-family:var(--font-display);font-size:12px">{{ initials }}</span>{{ currentUser.name }}</button>
				</template>
				<template v-slot:content>
					<div class="flex items-center px-5 py-4">
						<div class="h-12 w-12 rounded-full bg-blue-600 text-white grid place-items-center font-bold">{{ initials }}</div>
						<div class="ml-3 min-w-0"><div class="font-medium truncate">{{ currentUser.name }}</div><div class="text-sm leading-none text-gray-500 truncate">{{ currentUser.email }}</div></div>
					</div>
					<breeze-dropdown-link :href="route('profile.show')">My Profile</breeze-dropdown-link>
					<breeze-dropdown-link :href="route('logout')" as="button" method="POST">Logout</breeze-dropdown-link>
				</template>
			</breeze-dropdown>
		</div>
	</header>
</template>

<script>
import BreezeDropdown from '@/Components/Breeze/Dropdown';
import BreezeDropdownLink from '@/Components/Breeze/DropdownLink';
import NotificationsSlideOver from './NotificationsSlideOver';
export default {
	components: { BreezeDropdown, BreezeDropdownLink, NotificationsSlideOver },
	computed: { initials() { return (this.currentUser.name || 'AB').split(' ').slice(0,2).map(w=>w[0]).join('').toUpperCase() } },
};
</script>
