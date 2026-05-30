<template>
	<div class="in-role-card">
		<div class="in-role-grid">
			<div>
				<div class="flex items-start gap-3">
					<div class="in-logo-tile">{{ companyInitials }}</div>
					<div class="min-w-0 flex-1">
						<div class="flex flex-wrap items-center gap-2">
							<span class="in-tag in-tag-blue">{{ internship.field.name }}</span>
							<span v-if="internship.application" class="in-tag in-tag-green">Applied</span>
							<span v-if="isFresh" class="in-tag">New</span>
						</div>
						<inertia-link :href="route('internships.show', internship)" class="in-role-title block mt-3 hover:text-blue-700">
							{{ truncateTitle ? internship.title : truncate(internship.title, 70) }}
						</inertia-link>
						<div class="in-role-meta mt-3">
							<span>{{ internship.company.name }}</span>
							<span>•</span>
							<span>{{ internship.city.name }}</span>
							<span>•</span>
							<span>{{ internship.work_type || workType }}</span>
							<span>•</span>
							<span>Closes {{ internship.closing_at }}</span>
						</div>
					</div>
				</div>
				<p class="mt-5 text-gray-600 leading-7">{{ truncate(internship.description, full ? 300 : 180) }}</p>
				<div class="mt-5 flex flex-wrap gap-2">
					<span v-for="skill in visibleSkills" :key="skill" class="in-tag">{{ skill }}</span>
				</div>
			</div>

			<div class="in-role-aside">
				<div class="text-xs font-bold uppercase tracking-widest text-gray-400">Compensation</div>
				<div class="mt-2 text-lg font-extrabold text-gray-900">{{ payLabel }}</div>
				<div class="mt-4 text-sm text-gray-500">Posted {{ internship.created_at }}</div>
				<div class="mt-5 flex lg:flex-col gap-2 justify-end">
					<inertia-link :href="route('internships.show', internship)" class="in-btn in-btn-primary text-sm">View role</inertia-link>
					<button v-if="isStudent" type="button" @click="toggleLike(internship)" class="in-btn in-btn-ghost text-sm">
						{{ internship.liked ? 'Saved' : 'Save' }}
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Like from '@/Mixins/Like'

export default {
	mixins: [Like],
	props: {
		internship: Object,
		full: { type: Boolean, default: true },
		truncateTitle: { type: Boolean, default: false },
	},
	computed: {
		isStudent() { return this.currentUser && this.currentUser.userable_type === 'student' },
		companyInitials() {
			return (this.internship.company.name || 'IN').split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase()
		},
		isFresh() { return /hour|minute|second|day/i.test(this.internship.created_at || '') },
		workType() {
			const types = ['Hybrid', 'Remote', 'On-site']
			return types[this.internship.id % types.length]
		},
		payLabel() {
			if (this.internship.pay_label) return this.internship.pay_label
			const options = ['800 DT/mo', '25 DT/hr', 'Unpaid · Credit']
			return options[this.internship.id % options.length]
		},
		visibleSkills() {
			if (this.internship.skills && this.internship.skills.length) return this.internship.skills.slice(0, 4).map(s => s.name || s)
			const fallback = {
				'Software Engineering': ['APIs', 'Git', 'Testing'],
				'Web Development': ['Laravel', 'Vue', 'Tailwind'],
				'Data Science & AI': ['Python', 'SQL', 'ML'],
				'UI/UX Design': ['Figma', 'Research', 'Prototyping'],
				'Cybersecurity': ['Linux', 'OWASP', 'Networking'],
			}
			return fallback[this.internship.field.name] || ['Teamwork', 'Problem solving', 'Communication']
		}
	}
}
</script>
