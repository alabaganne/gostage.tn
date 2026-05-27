<template>
	<div class="min-h-screen bg-gray-50 text-gray-900 flex flex-col">
		<header class="bg-white/95 backdrop-blur border-b border-gray-200">
			<div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
				<inertia-link href="/" class="flex items-center">
					<brand-logo tagline="Find internships faster" />
				</inertia-link>

				<nav class="hidden md:flex items-center space-x-7 text-sm font-semibold text-gray-600">
					<inertia-link :href="route('internships.index')" class="hover:text-gray-900">Internships</inertia-link>
					<inertia-link :href="route('blog.index')" class="hover:text-gray-900">Blog</inertia-link>
					<inertia-link href="/about" class="hover:text-gray-900">About</inertia-link>
					<inertia-link href="/contact" class="hover:text-gray-900">Contact</inertia-link>
					<inertia-link v-if="!currentUser" :href="route('login')" class="hover:text-gray-900">Login</inertia-link>
					<inertia-link v-if="!currentUser" :href="route('register')" class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 transition">Create account</inertia-link>
					<inertia-link v-else :href="route('dashboard')" class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 transition">Dashboard</inertia-link>
				</nav>
			</div>
		</header>

		<main class="flex-1">
			<slot />
		</main>

		<footer class="border-t border-gray-200 bg-white">
			<div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 text-sm text-gray-500">
				<div>
					<brand-logo size="sm" />
					<div class="mt-2">Public internship discovery for students. Simple hiring workflows for companies.</div>
				</div>
				<div class="flex items-center gap-6">
					<inertia-link :href="route('internships.index')" class="hover:text-gray-800">Browse internships</inertia-link>
					<inertia-link :href="route('blog.index')" class="hover:text-gray-800">Blog</inertia-link>
					<inertia-link href="/about" class="hover:text-gray-800">About</inertia-link>
					<inertia-link href="/contact" class="hover:text-gray-800">Contact</inertia-link>
				</div>
			</div>
		</footer>
	</div>
</template>
