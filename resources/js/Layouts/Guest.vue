<template>
	<div class="in-auth-grid">
		<aside class="in-auth-brand">
			<div>
				<inertia-link href="/">
					<brand-logo dark tagline="Internships, without the chaos" />
				</inertia-link>
			</div>
			<div class="max-w-lg">
				<div class="in-pill bg-white bg-opacity-10 border-white border-opacity-20 text-blue-100">
					<span class="in-pill-dot"></span>
					Built for students and companies
				</div>
				<h1 class="in-display mt-6 text-5xl font-bold leading-tight text-white">Find roles, apply faster, and keep every internship conversation in one place.</h1>
				<p class="mt-6 text-blue-100 leading-8">Internly turns internship discovery, applications, saved roles, and recruiter messages into one focused workspace.</p>
			</div>
			<div class="grid grid-cols-3 gap-3 text-center">
				<div class="rounded-2xl border border-white border-opacity-10 p-4"><b class="block text-2xl text-white">500+</b><span class="text-xs text-blue-200">students</span></div>
				<div class="rounded-2xl border border-white border-opacity-10 p-4"><b class="block text-2xl text-white">120+</b><span class="text-xs text-blue-200">companies</span></div>
				<div class="rounded-2xl border border-white border-opacity-10 p-4"><b class="block text-2xl text-white">48h</b><span class="text-xs text-blue-200">avg reply</span></div>
			</div>
		</aside>

		<main class="flex min-h-screen items-center justify-center px-5 py-10">
			<div class="in-auth-card">
				<div class="mb-8 lg:hidden">
					<inertia-link href="/">
						<brand-logo tagline="Find internships faster" />
					</inertia-link>
				</div>
				<div class="in-card-soft p-6 sm:p-8">
					<slot />
				</div>
			</div>
		</main>
	</div>
</template>

<script>
	export default {}
</script>
