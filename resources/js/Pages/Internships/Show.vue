<template>
	<component :is="currentUser ? 'main-layout' : 'public-layout'" title="Internship" subtitle="Details">
		<section v-if="!currentUser" class="max-w-7xl mx-auto px-6 pt-8">
			<inertia-link :href="route('internships.index')" class="link text-sm font-semibold">← Back to public internships</inertia-link>
		</section>

		<div :class="currentUser ? '' : 'max-w-7xl mx-auto px-6 py-8'">
			<div class="bg-white rounded-lg shadow">
				<div class="flex flex-col lg:flex-row lg:divide-x">
					<div class="flex-1">
						<div class="p-6">
							<internship-header :internship="internship" />
						</div>
						<div class="p-6 border-t">
							<p class="text-lg text-gray-700 leading-8">
								{{ internship.description }}
							</p>
						</div>
						<div v-if="internship.attachments && internship.attachments.length" class="p-6 border-t">
							<div class="font-semibold">Attachments</div>
							<div class="mt-3 space-y-2">
								<div v-for="attachment in internship.attachments" :key="attachment.url || attachment.name" class="flex items-center">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
									</svg>
									<a :href="attachment.url" target="_blank" class="link text-sm">{{ attachment.name }}</a>
								</div>
							</div>
						</div>
						<div class="p-6 border-t">
							<div class="font-semibold">Skills and expertise</div>
							<skills class="mt-3" :small="false" />
						</div>
					</div>
					<div class="w-full lg:w-96 flex-shrink-0">
						<div v-if="currentUser && (((currentUser.userable_type === 'company' && currentUser.userable_id === internship.company.id) || currentUser.is_admin) || currentUser.userable_type === 'student')" class="p-6 border-b">
							<template v-if="currentUser.userable_type === 'student'">
								<inertia-link
									v-if="internship.application && currentUser.userable_id === internship.application.student_id"
									:href="route('applications.show', internship.application)"
									class="btn btn-lg btn-primary w-full"
								>
									Applied on {{ internship.application.created_at }} ->
								</inertia-link>
								<inertia-link v-if="!internship.application" :href="route('applications.create', internship)" class="btn btn-lg btn-primary w-full">Apply -></inertia-link>
								<button @click="toggleLike(internship)" class="mt-1.5 btn btn-lg btn-dark focus:ring-0 w-full">
									<icon name="heart" solid class="flex-shrink-0 mr-1.5 h-5 w-5" />
									{{ internship.liked ? 'Dislike' : 'Like' }}
								</button>
							</template>
							<template v-else>
								<inertia-link :href="route('internships.applications.index', internship)" class="btn btn-lg btn-primary block w-full">View Applications -></inertia-link>
								<inertia-link :href="route('internships.edit', internship)" class="mt-1.5 btn btn-lg btn-dark block w-full">Edit</inertia-link>
								<delete-modal title="Delete Internship" message="Are you sure you want to delete this internship? All the data related to this record will be removed permanently removed. This action cannot be undone." :url="route('internships.destroy', internship)">
									<button class="mt-1.5 btn btn-lg btn-danger block w-full">Delete</button>
								</delete-modal>
							</template>
						</div>
						<div v-if="!currentUser" class="p-6 border-b">
							<button @click="showAuthPrompt = true" class="btn btn-lg btn-primary w-full">Apply for this internship -></button>
							<p class="mt-3 text-sm text-gray-500 leading-6 text-center">Create a free student account or log in to submit your application.</p>
						</div>
						<component :is="currentUser ? 'inertia-link' : 'div'" v-bind="currentUser ? { href: route('companies.show', internship.company) } : {}" class="p-6 border-b hover:bg-gray-50 block">
							<div class="font-semibold">Company</div>
							<div class="mt-4 space-y-4">
								<div class="flex items-center">
									<icon name="user-circle" class="h-5 w-5 text-blue-400 mr-3" />
									{{ internship.company.name }}
								</div>
								<div class="flex items-center">
									<icon name="mail" class="h-5 w-5 text-blue-400 mr-3" />
									{{ internship.company.email }}
								</div>
								<div v-if="internship.company.phone_number" class="flex items-center">
									<icon name="phone" class="h-5 w-5 text-blue-400 mr-3" />
									{{ internship.company.phone_number }}
								</div>
								<div v-if="internship.company.city" class="flex items-center">
									<icon name="location-marker" class="h-5 w-5 text-blue-400 mr-3" />
									{{ internship.company.city.name }}
								</div>
								<div v-if="internship.company.website" class="flex items-center">
									<icon name="cursor-click" class="h-5 w-5 text-blue-400 mr-3" />
									<a :href="internship.company.website" target="_blank" class="link text-base">Visit website -></a>
								</div>
							</div>
						</component>
					</div>
				</div>
			</div>
		</div>

		<div v-if="showAuthPrompt" class="fixed inset-0 z-50 bg-gray-900/60 flex items-center justify-center px-4">
			<div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
				<div class="text-2xl font-extrabold text-gray-900">Apply with Internly</div>
				<p class="mt-3 text-gray-600 leading-7">You need a student account to apply, save internships, and track your applications.</p>
				<div class="mt-6 space-y-3">
					<inertia-link :href="route('register')" class="btn btn-lg btn-primary w-full">Create student account</inertia-link>
					<inertia-link :href="route('login')" class="btn btn-lg btn-dark w-full">Login</inertia-link>
					<button @click="showAuthPrompt = false" class="btn btn-lg w-full bg-gray-100 hover:bg-gray-200 text-gray-800">Keep browsing</button>
				</div>
			</div>
		</div>
	</component>
</template>

<script>
import MainLayout from '@/Layouts/Main';
import PublicLayout from '@/Layouts/Public';
import InternshipHeader from '@/Components/Internship/Header'
import DeleteModal from '@/Components/Modal/Delete';
import skills from '@/Components/Skills';
import Like from '@/Mixins/Like';

export default {
	mixins: [Like],
	components: {
		MainLayout,
		PublicLayout,
		InternshipHeader,
		DeleteModal,
		skills,
	},
	props: {
		internship: {
			type: Object,
			required: true
		},
	},
	data() {
		return {
			showAuthPrompt: false,
		}
	},
}
</script>
