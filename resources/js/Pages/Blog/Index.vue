<template>
	<public-layout>
		<section class="bg-white border-b border-gray-100">
			<div class="in-wrap py-16 lg:py-20">
				<div class="max-w-3xl">
					<div class="in-pill"><span class="in-pill-dot"></span> Internly Blog</div>
					<h1 class="in-display mt-6 text-4xl md:text-6xl font-bold tracking-tight text-gray-900 leading-tight">Internship guides for students and companies</h1>
					<p class="mt-6 text-lg text-gray-600 leading-8">Practical resources about finding internships, applying better, hiring students, and managing applications with less friction.</p>
				</div>
			</div>
		</section>

		<section class="in-wrap py-14">
			<div class="grid md:grid-cols-2 gap-6">
				<article v-for="post in posts" :key="post.slug" class="in-card p-7 hover:border-blue-200 transition">
					<div class="flex items-center justify-between gap-4 text-sm">
						<span class="in-tag in-tag-blue">{{ post.category }}</span>
						<span class="text-gray-500">{{ post.read_time }}</span>
					</div>
					<h2 class="in-display mt-5 text-2xl font-bold text-gray-900 leading-tight">
						<inertia-link :href="route('blog.show', post.slug)" class="hover:text-blue-700">{{ post.title }}</inertia-link>
					</h2>
					<p class="mt-4 text-gray-600 leading-7">{{ post.excerpt }}</p>
					<div class="mt-6 flex items-center justify-between gap-4">
						<span class="text-sm text-gray-500">{{ formatDate(post.published_at) }}</span>
						<inertia-link :href="route('blog.show', post.slug)" class="font-bold text-blue-700 hover:text-blue-800">Read guide →</inertia-link>
					</div>
				</article>
			</div>
		</section>

		<section class="in-wrap pb-16">
			<div class="in-navy rounded-3xl p-8 md:p-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
				<div>
					<h2 class="in-display text-2xl md:text-3xl font-bold text-white">Ready to explore internships?</h2>
					<p class="mt-3 text-blue-100 leading-7">Browse public internship listings and apply through Internly.</p>
				</div>
				<inertia-link :href="route('internships.index')" class="in-btn bg-white text-gray-900">Browse internships</inertia-link>
			</div>
		</section>
	</public-layout>
</template>

<script>
import PublicLayout from '@/Layouts/Public'

export default {
	components: { PublicLayout },
	props: { posts: { type: Array, required: true } },
	methods: {
		formatDate(date) { return new Date(date).toLocaleDateString('en', { month: 'short', day: 'numeric', year: 'numeric' }) }
	}
}
</script>
