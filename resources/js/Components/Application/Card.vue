<template>
	<inertia-link :href="route('applications.show', application)" class="arow">
		<div class="logo2" :style="logoStyle">{{ initials(targetName) }}</div>
		<div class="info"><b>{{ title }}</b><span>{{ subtitle }}</span></div>
		<span class="status" :class="statusClass"><span class="d"></span>{{ statusLabel }}</span>
		<div class="when">{{ application.created_at }}</div>
		<div class="go"><icon name="sort-descending" /></div>
	</inertia-link>
</template>
<script>
export default { props:{application:Object}, computed:{ targetName(){return this.currentUser.userable_type==='company'?this.application.student.name:this.application.company.name}, title(){return this.currentUser.userable_type==='company'?this.application.student.name:this.application.internship.title}, subtitle(){return this.currentUser.userable_type==='company'?this.application.student.email:`${this.application.company.name} · ${this.application.internship.city.name}`}, statusClass(){return this.application.status===true?'interview':(this.application.status===false?'submitted':'review')}, statusLabel(){return this.application.status===true?'Interview':(this.application.status===false?'Closed':'In review')}, logoStyle(){return 'background:linear-gradient(140deg,#3b82f6,#1d4ed8)'}}, methods:{initials(n){return (n||'IN').split(' ').slice(0,2).map(w=>w[0]).join('').toUpperCase()}} }
</script>
