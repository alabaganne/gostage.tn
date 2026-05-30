<template>
	<div class="auth">
		<aside class="brandside">
			<inertia-link class="brand" :href="route('home')"><brand-logo dark /></inertia-link>
			<div class="mid">
				<h2>Start your internship journey the right way.</h2>
				<p class="sub">Create one profile and apply to hundreds of verified internships — or post roles and meet great candidates.</p>
				<ul class="bvals">
					<li v-for="item in values" :key="item"><span class="c">✓</span>{{ item }}</li>
				</ul>
			</div>
			<div class="bstat"><div><b>1k+</b><span>Students</span></div><div><b>250+</b><span>Open roles</span></div><div><b>100+</b><span>Companies</span></div></div>
		</aside>
		<main class="formside">
			<div class="formwrap"><slot /></div>
		</main>
	</div>
</template>

<script>
export default {
	data() { return { values: ['Apply to roles with one click', 'Track every application in real time', 'Message recruiters directly'] } }
}
</script>
