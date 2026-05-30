<template>
	<div class="min-h-screen in-shell flex flex-col">
		<header class="in-public-header">
			<div class="in-wrap in-public-nav">
				<inertia-link href="/" class="flex items-center">
					<brand-logo tagline="Find internships faster" />
				</inertia-link>

				<nav class="in-public-links">
					<inertia-link :href="route('internships.index')" class="hover:text-blue-700">Internships</inertia-link>
					<inertia-link :href="route('blog.index')" class="hover:text-blue-700">Blog</inertia-link>
					<inertia-link href="/about" class="hover:text-blue-700">About</inertia-link>
					<inertia-link href="/contact" class="hover:text-blue-700">Contact</inertia-link>
				</nav>

				<div class="flex items-center gap-3">
					<inertia-link v-if="!currentUser" :href="route('login')" class="hidden sm:inline-flex font-bold text-sm text-gray-700 hover:text-blue-700">Login</inertia-link>
					<inertia-link v-if="!currentUser" :href="route('register')" class="in-btn in-btn-primary text-sm">Create account</inertia-link>
					<inertia-link v-else :href="route('dashboard')" class="in-btn in-btn-dark text-sm">Dashboard</inertia-link>
				</div>
			</div>
		</header>

		<main class="flex-1">
			<slot />
		</main>

		<footer class="in-navy">
			<div class="in-wrap py-12">
				<div class="grid md:grid-cols-4 gap-8">
					<div class="md:col-span-2">
						<brand-logo dark />
						<p class="mt-4 text-sm leading-7 text-blue-100 max-w-md">A modern internship platform helping students discover roles and companies manage candidates without friction.</p>
					</div>
					<div>
						<h4 class="text-white text-sm font-bold uppercase tracking-wide">Platform</h4>
						<div class="mt-4 space-y-2 text-sm text-blue-100">
							<inertia-link :href="route('internships.index')" class="block hover:text-white">Browse internships</inertia-link>
							<inertia-link :href="route('blog.index')" class="block hover:text-white">Blog</inertia-link>
							<inertia-link href="/about" class="block hover:text-white">About</inertia-link>
						</div>
					</div>
					<div>
						<h4 class="text-white text-sm font-bold uppercase tracking-wide">Account</h4>
						<div class="mt-4 space-y-2 text-sm text-blue-100">
							<inertia-link :href="route('login')" class="block hover:text-white">Login</inertia-link>
							<inertia-link :href="route('register')" class="block hover:text-white">Create account</inertia-link>
							<inertia-link href="/contact" class="block hover:text-white">Contact</inertia-link>
						</div>
					</div>
				</div>
				<div class="mt-10 pt-6 border-t border-white border-opacity-10 text-xs text-blue-200 flex flex-col sm:flex-row justify-between gap-3">
					<span>© 2026 Internly. Internship discovery for Tunisia and beyond.</span>
					<span>Built for students · companies · career teams</span>
				</div>
			</div>
		</footer>
	</div>
</template>
