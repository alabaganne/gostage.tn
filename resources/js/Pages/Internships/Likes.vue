<template>
	<main-layout title="Saved roles" subtitle="Internships" maxWidthClass="max-w-6xl">
		<div class="mb-6 in-navy rounded-3xl p-7 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
			<div>
				<div class="text-blue-300 text-xs font-extrabold uppercase tracking-widest">Your shortlist</div>
				<h1 class="in-display mt-2 text-3xl font-bold text-white">Roles worth coming back to.</h1>
				<p class="mt-3 text-blue-100 leading-7">Save internships while browsing, compare them here, and apply when ready.</p>
			</div>
			<inertia-link :href="route('internships.index')" class="in-btn bg-white text-gray-900">Browse more roles</inertia-link>
		</div>

		<div v-if="localLikes.length > 0" class="space-y-4">
			<internship-card v-for="internship in localLikes" :key="internship.id" :internship="internship" @dislike="onDislike" />
		</div>
		<card v-else class="p-8 text-gray-600">
			No saved roles yet. Browse internships and hit save to build your shortlist.
		</card>
	</main-layout>
</template>

<script>
import MainLayout from "@/Layouts/Main";
import InternshipCard from "@/Components/Internship/Card";

export default {
	components: { MainLayout, InternshipCard },
	props: { likes: { type: Array, required: true } },
	data() { return { localLikes: [] } },
	mounted() { this.localLikes = JSON.parse(JSON.stringify(this.likes)); },
	methods: { onDislike(internship) { this.localLikes = this.localLikes.filter(localInternship => localInternship.id !== internship.id) } }
}
</script>
