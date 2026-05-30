<template>
	<main-layout title="Applications" subtitle="Pipeline" maxWidthClass="max-w-6xl">
		<div class="mb-6 grid md:grid-cols-3 gap-4">
			<div class="in-card p-5"><div class="text-xs font-bold uppercase tracking-widest text-gray-400">Total</div><div class="mt-2 text-3xl font-extrabold">{{ applications.meta.total }}</div></div>
			<div class="in-card p-5"><div class="text-xs font-bold uppercase tracking-widest text-gray-400">Pending</div><div class="mt-2 text-3xl font-extrabold">{{ pendingCount }}</div></div>
			<div class="in-card p-5"><div class="text-xs font-bold uppercase tracking-widest text-gray-400">Reviewed</div><div class="mt-2 text-3xl font-extrabold">{{ reviewedCount }}</div></div>
		</div>
		<div v-if="applications.data.length > 0">
			<card title="Application activity" subtitle="Track every submitted application and review state." class="divide-y divide-gray-100">
				<template v-for="application in applications.data" :key="application.id">
					<application-card :application="application" />
				</template>
			</card>
			<pagination :links="applications.meta.links" :meta="applications.meta" class="mt-4" />
		</div>
		<card v-else class="p-8 text-gray-600">No applications found.</card>
	</main-layout>
</template>

<script>
import MainLayout from "@/Layouts/Main";
import ApplicationCard from "@/Components/Application/Card";
import Pagination from '@/Components/Pagination';

export default {
	components: { MainLayout, ApplicationCard, Pagination },
	props: { applications: Object },
	computed: {
		pendingCount() { return this.applications.data.filter(application => application.status === null).length },
		reviewedCount() { return this.applications.data.filter(application => application.status !== null).length },
	}
}
</script>
