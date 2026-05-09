<template>
	<main-layout title="Companies" subtitle="View">
		<template v-slot:header-right>
			<inertia-link v-if="currentUser.is_admin" :href="route('companies.create')" class="btn btn-lg btn-primary">Add Company -></inertia-link>
		</template>
		<template v-if="companies.data.length > 0">
			<app-table :fields="['Name', 'Email', 'City', 'Number of Internships', 'Actions']">
				<tr v-for="company in companies.data" :key="company.id">
					<td class="font-medium flex items-center">
						<icon name="office-building" class="text-gray-400 mr-4" />
						{{ company.name }}
					</td>
					<td>{{ company.email }}</td>
					<td>{{ company.city.name }}</td>
					<td class="">{{ company.internships_count }}</td>
					<td class="text-right">
						<div class="flex items-center justify-end space-x-1">
							<inertia-link :href="route('companies.show', company)" class="btn btn-sm btn-primary">View</inertia-link>
							<button v-if="currentUser.userable_type === 'student'" @click="selectedUser = company" class="btn btn-sm btn-secondary">Message</button>
							<inertia-link v-if="currentUser.is_admin || currentUser.id === company.user_id" :href="route('companies.edit', company)" class="btn btn-sm btn-dark">Edit</inertia-link>
						</div>
					</td>
				</tr>
			</app-table>
			<pagination class="mt-4" :links="companies.links" :meta="companies" />
		</template>
		<card v-else class="p-6">
			No companies found
		</card>
		<contact-modal :user="selectedUser" @close="selectedUser = null" />
	</main-layout>
</template>

<script>
import MainLayout from "@/Layouts/Main";
import Pagination from "@/Components/Pagination";
import ContactModal from "@/Components/Modal/Contact";

export default {
	components: {
		MainLayout,
		Pagination,
		ContactModal,
	},
	props: {
		companies: Object
	},
	data() {
		return {
			selectedUser: null,
		}
	}
}
</script>
