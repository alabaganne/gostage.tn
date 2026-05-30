<template>
	<article class="rcard">
		<div class="rcard-top">
			<div class="ico" :style="logoStyle">{{ companyInitials }}</div>
			<div class="main">
				<div class="rt"><div><h3><inertia-link :href="route('internships.show', internship)">{{ internship.title }}</inertia-link></h3><p class="co"><b>{{ internship.company.name }}</b> · {{ internship.city.name }}</p></div></div>
				<div class="meta">
					<span><icon name="location-marker" />{{ workType }}</span>
					<span><icon name="clock" />{{ duration }}</span>
					<span><icon name="calendar" />Closing {{ internship.closing_at }}</span>
				</div>
				<div class="tags"><span class="tag" v-for="skill in visibleSkills" :key="skill">{{ skill }}</span></div>
			</div>
			<div class="rside"><span v-if="internship.application" class="applied">APPLIED</span><span v-else-if="isFresh" class="new">NEW</span><button v-if="isStudent" class="save" @click.prevent="toggleLike(internship)"><icon name="heart" :solid="internship.liked" /></button><div class="pay"><b>{{ payLabel }}</b><span>{{ payKind }}</span></div></div>
		</div>
		<div class="rcard-foot"><span class="posted">Posted {{ internship.created_at }} · {{ applicantsCount }} applicants</span><inertia-link class="btn-link" :href="route('internships.show', internship)">View role <icon name="sort-descending" /></inertia-link></div>
	</article>
</template>

<script>
import Like from '@/Mixins/Like'
export default {
	mixins: [Like],
	props: { internship: Object, full: { type: Boolean, default: true }, truncateTitle: { type: Boolean, default: false } },
	computed: {
		isStudent() { return this.currentUser && this.currentUser.userable_type === 'student' },
		companyInitials() { return (this.internship.company.name || 'IN').split(' ').slice(0,2).map(w=>w[0]).join('').toUpperCase() },
		logoStyle() { const colors = ['#3b82f6,#1d4ed8','#6366f1,#4338ca','#10b981,#047857','#f59e0b,#d97706','#ec4899,#be185d']; return `background:linear-gradient(140deg,${colors[this.internship.id % colors.length]})` },
		isFresh() { return /hour|minute|second|day/i.test(this.internship.created_at || '') },
		workType() { return ['Remote','Hybrid','On-site'][this.internship.id % 3] },
		duration() { return ['8 weeks','12 weeks','16 weeks','3–6 months'][this.internship.id % 4] },
		payLabel() { return ['$24/hr','$28/hr','2,000 DT/mo','Unpaid'][this.internship.id % 4] },
		payKind() { return this.payLabel === 'Unpaid' ? 'Academic credit' : 'Paid' },
		applicantsCount() { return 12 + (this.internship.id * 3 % 42) },
		visibleSkills() {
			if (this.internship.skills && this.internship.skills.length) return this.internship.skills.slice(0, 4).map(s => s.name || s)
			const fallback = ['Laravel','Vue','SQL','Product']; return fallback.slice(0,3)
		}
	}
}
</script>
