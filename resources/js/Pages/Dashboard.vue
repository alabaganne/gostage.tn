<template>
	<main-layout subtitle="Overview" title="Dashboard" max-width-class="in-dashboard-main">
		<section class="in-navy rounded-3xl p-7 md:p-9 mb-6 overflow-hidden relative">
			<div class="relative z-10 max-w-3xl">
				<div class="text-blue-300 text-xs font-extrabold uppercase tracking-widest">Welcome back</div>
				<h1 class="in-display mt-2 text-3xl md:text-5xl font-bold text-white">Keep your internship workflow moving.</h1>
				<p class="mt-4 text-blue-100 leading-7">Track roles, applications, companies, and conversations from one focused workspace.</p>
			</div>
			<div class="absolute -right-16 -bottom-24 h-64 w-64 rounded-full bg-blue-500 opacity-20"></div>
		</section>

		<div class="grid c-grid-col-sm gap-4">
			<template v-for="card in cards" :key="card.label">
				<card v-if="card.show" class="hover:border-blue-200 transition">
					<div class="p-6 flex items-center gap-5">
						<div class="h-14 w-14 rounded-2xl bg-blue-50 text-blue-600 grid place-items-center">
							<icon :name="card.icon" class="h-7 w-7" />
						</div>
						<div>
							<div class="text-gray-500 text-xs font-extrabold uppercase tracking-widest">{{ card.label }}</div>
							<div class="mt-1 text-3xl font-extrabold">{{ card.value }}</div>
						</div>
					</div>
					<template v-slot:footer>
						<inertia-link :href="card.link" class="link text-sm font-bold">View all →</inertia-link>
					</template>
				</card>
			</template>
		</div>

		<div class="mt-6 grid xl:grid-cols-3 gap-6">
			<div class="xl:col-span-2">
				<card v-if="applications" title="Recent applications" subtitle="Latest student/company activity across the platform.">
					<div v-if="applications.length > 0" class="divide-y divide-gray-100">
						<application-card v-for="application in applications" :key="application.id" :application="application" />
					</div>
					<div v-if="applications.length === 0" class="p-6 text-gray-600">No records found.</div>
					<template v-if="applications.length >= 4" v-slot:footer>
						<div class="flex justify-end"><inertia-link :href="route('applications.index')" class="in-btn in-btn-primary text-sm">View all →</inertia-link></div>
					</template>
				</card>
			</div>
			<div class="in-card p-6">
				<div class="in-heading text-xl font-bold">Quick actions</div>
				<div class="mt-5 space-y-3">
					<inertia-link :href="route('internships.index')" class="in-btn in-btn-ghost in-btn-block">Browse internships</inertia-link>
					<inertia-link v-if="['student','company'].includes(currentUser.userable_type)" :href="route('applications.index')" class="in-btn in-btn-ghost in-btn-block">Applications</inertia-link>
					<inertia-link v-if="currentUser.userable_type === 'student'" :href="route('likes.index')" class="in-btn in-btn-ghost in-btn-block">Saved roles</inertia-link>
					<inertia-link v-if="currentUser.userable_type === 'company'" :href="route('internships.create')" class="in-btn in-btn-primary in-btn-block">Post internship</inertia-link>
				</div>
			</div>
		</div>
	</main-layout>
</template>

<script>
import MainLayout from "@/Layouts/Main";
import ApplicationCard from "@/Components/Application/Card";

export default {
	components: { MainLayout, ApplicationCard },
	props: { internships_count: Number, students_count: Number, companies_count: Number, applications_count: Number, applications: Array },
	data() {
		return {
			cards: [
				{ label: 'Open Internships', value: this.internships_count, icon: 'briefcase', link: route('internships.index'), show: true },
				{ label: 'Students', value: this.students_count, icon: 'user-group', link: route('students.index'), show: this.currentUser.is_admin },
				{ label: 'Companies', value: this.companies_count, icon: 'office-building', link: route('companies.index'), show: true },
				{ label: 'Pending Applications', value: this.applications_count, icon: 'folder', link: route('applications.index'), show: this.currentUser.userable_type === 'student' || this.currentUser.userable_type === 'company' },
			],
		};
	},
};
</script>
