<template>
	<component :is="currentUser ? 'main-layout' : 'public-layout'" title="Internship detail" subtitle="Role" max-width-class="">
		<template v-if="currentUser" #description>Review the role, company details, and apply when ready.</template>
		<div :class="currentUser ? '' : 'wrap section'">
			<div class="detail-grid">
				<main class="detail-main">
					<section class="detail-head card">
						<div class="detail-logo" :style="logoStyle">{{ companyInitials }}</div>
						<div><div class="tags"><span class="tag">{{ internship.field.name }}</span><span v-if="internship.application" class="tag" style="background:#dcfce7;color:#047857">Applied</span></div><h1>{{ internship.title }}</h1><p>{{ internship.company.name }} · {{ internship.city.name }} · {{ workType }}</p></div>
					</section>
					<section class="detail-section card"><h2>Role overview</h2><p class="pd-desc whitespace-pre-line">{{ internship.description }}</p></section>
					<section class="detail-section card"><h2>What you'll do</h2><ul class="nice-list"><li v-for="item in responsibilities" :key="item">{{ item }}</li></ul></section>
					<section class="detail-section card"><h2>Requirements</h2><ul class="nice-list"><li v-for="item in requirements" :key="item">{{ item }}</li></ul></section>
					<section class="detail-section card"><h2>Skills & expertise</h2><div class="tags"><span v-for="skill in skills" :key="skill" class="tag">{{ skill }}</span></div></section>
				</main>
				<aside class="detail-aside">
					<div class="apply-card card">
						<div class="pay"><b>{{ payLabel }}</b><span>{{ duration }} · Closing {{ internship.closing_at }}</span></div>
						<template v-if="currentUser && currentUser.userable_type === 'student'"><inertia-link v-if="internship.application" :href="route('applications.show', internship.application)" class="btn btn-primary btn-lg btn-block">Applied on {{ internship.application.created_at }}</inertia-link><inertia-link v-else :href="route('applications.create', internship)" class="btn btn-primary btn-lg btn-block">Apply now</inertia-link><button @click="toggleLike(internship)" class="btn btn-ghost btn-block">{{ internship.liked ? 'Saved' : 'Save role' }}</button></template>
						<template v-else-if="!currentUser"><inertia-link :href="route('login')" class="btn btn-primary btn-lg btn-block">Log in to apply</inertia-link><inertia-link :href="route('register')" class="btn btn-ghost btn-block">Create account</inertia-link></template>
						<template v-else><inertia-link :href="route('internships.applications.index', internship)" class="btn btn-primary btn-lg btn-block">View applications</inertia-link><inertia-link :href="route('internships.edit', internship)" class="btn btn-ghost btn-block">Edit role</inertia-link></template>
					</div>
					<div class="company-card card"><h3>Company</h3><div class="company-row"><div class="detail-logo small" :style="logoStyle">{{ companyInitials }}</div><div><b>{{ internship.company.name }}</b><span>{{ internship.company.email }}</span></div></div><p v-if="internship.company.about">{{ internship.company.about }}</p><a v-if="internship.company.website" :href="internship.company.website" target="_blank" class="btn-link">Visit website</a></div>
				</aside>
			</div>
		</div>
	</component>
</template>
<script>
import MainLayout from '@/Layouts/Main'; import PublicLayout from '@/Layouts/Public'; import Like from '@/mixins/like';
export default { mixins: [Like], components: { MainLayout, PublicLayout }, props: { internship: Object }, computed: { companyInitials(){return (this.internship.company.name||'IN').split(' ').slice(0,2).map(w=>w[0]).join('').toUpperCase()}, logoStyle(){return 'background:linear-gradient(140deg,#3b82f6,#1d4ed8)'}, workType(){return ['Remote','Hybrid','On-site'][this.internship.id%3]}, duration(){return ['8 weeks','12 weeks','16 weeks','3–6 months'][this.internship.id%4]}, payLabel(){return ['$24/hr','$28/hr','2,000 DT/mo','Unpaid'][this.internship.id%4]}, skills(){return this.internship.skills?.length ? this.internship.skills.map(s=>s.name||s) : ['Laravel','Vue','SQL','Teamwork']}, responsibilities(){return ['Build production-ready features with the engineering team','Collaborate with product and design on user-facing workflows','Write clean, documented code and participate in reviews']}, requirements(){return ['Student or recent graduate in a relevant field','Comfortable with the core tools listed for this role','Curious, reliable, and ready to learn fast']} } }
</script>
