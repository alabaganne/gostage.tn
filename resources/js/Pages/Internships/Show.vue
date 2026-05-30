<template>
	<component :is="currentUser ? 'main-layout' : 'public-layout'" title="Internship" subtitle="Details" max-width-class="max-w-7xl">
		<section v-if="!currentUser" class="bg-white border-b border-gray-100">
			<div class="in-wrap py-8">
				<inertia-link :href="route('internships.index')" class="font-bold text-sm text-blue-700 hover:text-blue-800">← Back to public internships</inertia-link>
			</div>
		</section>

		<div :class="currentUser ? '' : 'in-wrap py-8'">
			<div class="in-panel">
				<div class="flex flex-col lg:flex-row lg:divide-x lg:divide-gray-100">
					<div class="flex-1 min-w-0">
						<div class="p-6 md:p-8">
							<internship-header :internship="internship" />
						</div>
						<div class="p-6 md:p-8 border-t border-gray-100">
							<div class="in-label">Role overview</div>
							<p class="mt-3 text-lg text-gray-700 leading-9 whitespace-pre-line">{{ internship.description }}</p>
						</div>
						<div v-if="internship.attachments && internship.attachments.length" class="p-6 md:p-8 border-t border-gray-100">
							<div class="in-heading font-bold text-xl">Attachments</div>
							<div class="mt-4 space-y-2">
								<div v-for="attachment in internship.attachments" :key="attachment.url || attachment.name" class="flex items-center rounded-xl border border-gray-100 p-3">
									<icon name="link" class="h-5 w-5 text-blue-500 mr-3" />
									<a :href="attachment.url" target="_blank" class="link text-sm font-bold">{{ attachment.name }}</a>
								</div>
							</div>
						</div>
						<div class="p-6 md:p-8 border-t border-gray-100">
							<div class="in-heading font-bold text-xl">Skills and expertise</div>
							<skills class="mt-3" :small="false" />
						</div>
					</div>

					<aside class="w-full lg:w-96 flex-shrink-0 bg-gray-50">
						<div v-if="currentUser && (((currentUser.userable_type === 'company' && currentUser.userable_id === internship.company.id) || currentUser.is_admin) || currentUser.userable_type === 'student')" class="p-6 border-b border-gray-100 bg-white">
							<template v-if="currentUser.userable_type === 'student'">
								<inertia-link v-if="internship.application && currentUser.userable_id === internship.application.student_id" :href="route('applications.show', internship.application)" class="in-btn in-btn-primary in-btn-block">Applied on {{ internship.application.created_at }} →</inertia-link>
								<inertia-link v-if="!internship.application" :href="route('applications.create', internship)" class="in-btn in-btn-primary in-btn-block">Apply →</inertia-link>
								<button @click="toggleLike(internship)" class="mt-2 in-btn in-btn-ghost in-btn-block">
									<icon name="heart" solid class="flex-shrink-0 h-5 w-5" /> {{ internship.liked ? 'Saved' : 'Save role' }}
								</button>
							</template>
							<template v-else>
								<inertia-link :href="route('internships.applications.index', internship)" class="in-btn in-btn-primary in-btn-block">View applications →</inertia-link>
								<inertia-link :href="route('internships.edit', internship)" class="mt-2 in-btn in-btn-ghost in-btn-block">Edit role</inertia-link>
								<delete-modal title="Delete Internship" message="Are you sure you want to delete this internship? All the data related to this record will be permanently removed. This action cannot be undone." :url="route('internships.destroy', internship)">
									<button class="mt-2 in-btn in-btn-dark in-btn-block bg-red-600 hover:bg-red-700">Delete role</button>
								</delete-modal>
							</template>
						</div>
						<div v-if="!currentUser" class="p-6 border-b border-gray-100 bg-white">
							<button @click="showAuthPrompt = true" class="in-btn in-btn-primary in-btn-block">Apply for this internship →</button>
							<p class="mt-3 text-sm text-gray-500 leading-6 text-center">Create a free student account or log in to submit your application.</p>
						</div>

						<div class="p-6 border-b border-gray-100">
							<div class="text-xs font-bold uppercase tracking-widest text-gray-400">Role details</div>
							<div class="mt-4 grid grid-cols-2 gap-3">
								<div class="in-card p-3"><div class="text-xs text-gray-500">Location</div><div class="mt-1 font-bold">{{ internship.city.name }}</div></div>
								<div class="in-card p-3"><div class="text-xs text-gray-500">Field</div><div class="mt-1 font-bold">{{ internship.field.name }}</div></div>
								<div class="in-card p-3"><div class="text-xs text-gray-500">Deadline</div><div class="mt-1 font-bold">{{ internship.closing_at }}</div></div>
								<div class="in-card p-3"><div class="text-xs text-gray-500">Type</div><div class="mt-1 font-bold">Hybrid</div></div>
							</div>
						</div>

						<component :is="currentUser ? 'inertia-link' : 'div'" v-bind="currentUser ? { href: route('companies.show', internship.company) } : {}" class="p-6 hover:bg-white block">
							<div class="in-heading font-bold text-xl">Company</div>
							<div class="mt-4 space-y-4 text-sm text-gray-700">
								<div class="flex items-center"><div class="in-logo-tile mr-3">{{ companyInitials }}</div><span class="font-bold">{{ internship.company.name }}</span></div>
								<div class="flex items-center"><icon name="mail" class="h-5 w-5 text-blue-500 mr-3" />{{ internship.company.email }}</div>
								<div v-if="internship.company.phone_number" class="flex items-center"><icon name="phone" class="h-5 w-5 text-blue-500 mr-3" />{{ internship.company.phone_number }}</div>
								<div v-if="internship.company.city" class="flex items-center"><icon name="location-marker" class="h-5 w-5 text-blue-500 mr-3" />{{ internship.company.city.name }}</div>
								<div v-if="internship.company.website" class="flex items-center"><icon name="cursor-click" class="h-5 w-5 text-blue-500 mr-3" /><a :href="internship.company.website" target="_blank" class="link text-base font-bold">Visit website →</a></div>
							</div>
						</component>
					</aside>
				</div>
			</div>
		</div>

		<div v-if="showAuthPrompt" class="fixed inset-0 z-50 bg-gray-900 bg-opacity-60 flex items-center justify-center px-4">
			<div class="bg-white rounded-3xl shadow-xl max-w-md w-full p-6">
				<div class="in-display text-3xl font-bold text-gray-900">Apply with Internly</div>
				<p class="mt-3 text-gray-600 leading-7">You need a student account to apply, save internships, and track your applications.</p>
				<div class="mt-6 space-y-3">
					<inertia-link :href="route('register')" class="in-btn in-btn-primary in-btn-block">Create student account</inertia-link>
					<inertia-link :href="route('login')" class="in-btn in-btn-dark in-btn-block">Login</inertia-link>
					<button @click="showAuthPrompt = false" class="in-btn in-btn-light in-btn-block">Keep browsing</button>
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
	components: { MainLayout, PublicLayout, InternshipHeader, DeleteModal, skills },
	props: { internship: { type: Object, required: true } },
	data() { return { showAuthPrompt: false } },
	computed: {
		companyInitials() { return (this.internship.company.name || 'IN').split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase() }
	},
}
</script>
