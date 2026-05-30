<template>
	<main-layout subtitle="Overview" title="Welcome back, Ala 👋">
		<template #description>Here's what's happening with your internship search.</template>
		<div class="stats">
			<div v-for="card in cards" :key="card.label" v-show="card.show" class="scard"><div class="row"><div class="ic" :style="card.style"><icon :name="card.icon" /></div><span class="delta up">{{ card.delta }}</span></div><div class="lab">{{ card.label }}</div><div class="num">{{ card.value }}</div><inertia-link :href="card.link">View all <icon name="sort-descending" /></inertia-link></div>
		</div>
		<div class="cols2">
			<section class="panel"><div class="panel-head"><div><h3>Recent applications</h3><p>Track the status of every role you've applied to.</p></div><inertia-link :href="route('applications.index')">View all</inertia-link></div><div v-if="applications && applications.length"><application-card v-for="application in applications" :key="application.id" :application="application" /></div><div v-else class="p-6">No records found.</div></section>
			<div style="display:flex;flex-direction:column;gap:16px"><section class="panel prog-card"><h3>Profile completeness</h3><p>Complete your profile to improve role matching.</p><div class="bar"><i></i></div><div class="pct"><b>72%</b><span>Almost there</span></div><ul class="todo"><li><span class="c done">✓</span><span class="muted">Basic info added</span></li><li><span class="c done">✓</span><span class="muted">Field selected</span></li><li><span class="c todo2"></span>Upload CV</li></ul></section><section class="panel"><div class="panel-head"><div><h3>Recommended roles</h3><p>Based on your profile.</p></div></div><div class="rec"><inertia-link :href="route('internships.index')" class="recitem"><span class="logo2" style="background:linear-gradient(140deg,#3b82f6,#1d4ed8)">At</span><div><b>Software Engineering Intern</b><span>Atlas Cloud · Remote</span></div><span class="match">92%</span></inertia-link></div></section></div>
		</div>
	</main-layout>
</template>
<script>
import MainLayout from '@/Layouts/Main'; import ApplicationCard from '@/Components/Application/Card';
export default { components:{MainLayout,ApplicationCard}, props:{internships_count:Number,students_count:Number,companies_count:Number,applications_count:Number,applications:Array}, data(){return {cards:[{label:'Open internships',value:this.internships_count,icon:'briefcase',link:route('internships.index'),show:true,delta:'+8',style:'background:linear-gradient(140deg,#3b82f6,#1d4ed8)'},{label:'Companies hiring',value:this.companies_count,icon:'office-building',link:route('companies.index'),show:true,delta:'+2',style:'background:linear-gradient(140deg,#6366f1,#4338ca)'},{label:'My applications',value:this.applications_count,icon:'folder',link:route('applications.index'),show:['student','company'].includes(this.currentUser.userable_type),delta:'2 active',style:'background:linear-gradient(140deg,#f59e0b,#d97706)'},{label:'Students',value:this.students_count,icon:'user-group',link:route('students.index'),show:this.currentUser.is_admin,delta:'+4',style:'background:linear-gradient(140deg,#10b981,#047857)'}]}} }
</script>
