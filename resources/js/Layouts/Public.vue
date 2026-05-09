<template>
	<div class="min-h-screen bg-gray-50 text-gray-900 flex flex-col">
		<header class="bg-white/95 backdrop-blur border-b border-gray-200">
			<div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
				<inertia-link href="/" class="flex items-center space-x-3">
					<div class="h-10 w-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-sm">
						<icon name="briefcase" class="h-5 w-5" />
					</div>
					<div>
						<div class="text-xl font-extrabold tracking-tight">Internly</div>
						<div class="text-xs text-gray-500 uppercase tracking-wide">Find internships faster</div>
					</div>
				</inertia-link>

				<nav class="hidden md:flex items-center space-x-7 text-sm font-semibold text-gray-600">
					<inertia-link :href="route('internships.index')" class="hover:text-gray-900">Internships</inertia-link>
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
					<div class="font-semibold text-gray-800">Internly</div>
					<div class="mt-1">Public internship discovery for students. Simple hiring workflows for companies.</div>
				</div>
				<div class="flex items-center gap-6">
					<inertia-link :href="route('internships.index')" class="hover:text-gray-800">Browse internships</inertia-link>
					<inertia-link href="/about" class="hover:text-gray-800">About</inertia-link>
					<inertia-link href="/contact" class="hover:text-gray-800">Contact</inertia-link>
				</div>
			</div>
		</footer>
	</div>
</template>
