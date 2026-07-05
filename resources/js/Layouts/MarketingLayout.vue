<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

defineProps({
	active: { type: String, default: '' }, // 'browse' | 'blog' | 'about' | 'contact'
	solid: { type: Boolean, default: false }, // opaque header (no blur) for form-heavy pages
});

const logo = '<svg viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';

const nav = [
	{ id: 'browse', label: 'Browse internships', route: 'internships.index' },
	{ id: 'blog', label: 'Blog', route: 'blog.index' },
	{ id: 'about', label: 'About', route: 'about' },
	{ id: 'contact', label: 'Contact', route: 'contact' },
];

const page = usePage();
const user = computed(() => page.props.auth?.user);
</script>

<template>
	<header class="sticky top-0 z-[60] border-b border-line" :class="solid ? 'bg-white' : 'bg-white/[.82] backdrop-blur-[14px]'">
		<div class="max-w-wrap mx-auto px-7 flex items-center justify-between h-[74px]">
			<Link class="flex items-center gap-[11px]" :href="route('home')">
				<span class="w-[38px] h-[38px] rounded-[11px] bg-gradient-to-br from-blue-400 to-blue-700 grid place-items-center text-white shadow-[0_8px_18px_-8px_rgba(37,99,235,.8)] [&_svg]:w-[21px] [&_svg]:h-[21px]" v-html="logo"></span>
				<span><b class="block font-display text-[19px] font-semibold tracking-tight">Internly</b><small class="block text-[10px] tracking-[.16em] text-muted-2 font-semibold -mt-0.5">INTERNSHIP PLATFORM</small></span>
			</Link>
			<nav class="flex items-center gap-[34px] max-[920px]:hidden">
				<Link
					v-for="item in nav"
					:key="item.id"
					class="text-[14.5px] font-medium hover:text-blue-700 transition-colors"
					:class="item.id === active ? 'text-blue-700' : 'text-ink-700'"
					:href="route(item.route)"
				>{{ item.label }}</Link>
			</nav>
			<div class="flex items-center gap-3.5">
				<template v-if="user">
					<Link class="inline-flex items-center gap-2.5 font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-blue-600 text-white shadow-cta hover:bg-blue-700 hover:-translate-y-px transition-all" :href="route('dashboard')">Go to dashboard</Link>
				</template>
				<template v-else>
					<Link class="text-[14.5px] font-semibold text-ink max-[920px]:hidden" :href="route('login')">Log in</Link>
					<Link class="inline-flex items-center gap-2.5 font-semibold text-[15px] px-[22px] py-[13px] rounded-[12px] bg-blue-600 text-white shadow-cta hover:bg-blue-700 hover:-translate-y-px transition-all" :href="route('register')">Create account</Link>
				</template>
			</div>
		</div>
	</header>

	<slot />

	<footer class="bg-navy-900 text-[#aeb9cf] pt-[78px] pb-[34px]">
		<div class="max-w-wrap mx-auto px-7">
			<div class="grid grid-cols-[1.6fr_1fr_1fr_1fr] gap-10 max-[820px]:grid-cols-2 max-[820px]:gap-8">
				<div>
					<Link class="flex items-center gap-[11px] mb-[18px]" :href="route('home')">
						<span class="w-[38px] h-[38px] rounded-[11px] bg-gradient-to-br from-blue-400 to-blue-700 grid place-items-center text-white [&_svg]:w-[21px] [&_svg]:h-[21px]" v-html="logo"></span>
						<span><b class="block font-display text-[19px] font-semibold tracking-tight text-white">Internly</b><small class="block text-[10px] tracking-[.16em] text-[#7c89a3] font-semibold -mt-0.5">INTERNSHIP PLATFORM</small></span>
					</Link>
					<p class="max-w-[300px] text-sm leading-[1.6] text-[#9aa6bd]">Where ambitious students and great companies find each other. Discover, apply, and get hired — all in one place.</p>
					<div class="flex gap-2.5 mt-[22px] [&_a]:w-9 [&_a]:h-9 [&_a]:rounded-[9px] [&_a]:bg-white/[.06] [&_a]:grid [&_a]:place-items-center [&_a:hover]:bg-blue-600 [&_svg]:w-[17px] [&_svg]:h-[17px]">
						<a href="#"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 5.8a8 8 0 01-2.4.7 4 4 0 001.8-2.2c-.8.5-1.7.8-2.6 1a4 4 0 00-6.8 3.6A11.4 11.4 0 013 4.8a4 4 0 001.2 5.3c-.6 0-1.2-.2-1.7-.5a4 4 0 003.2 4 4 4 0 01-1.8.1 4 4 0 003.7 2.8A8 8 0 012 18.3a11.3 11.3 0 006.1 1.8c7.4 0 11.5-6.2 11.5-11.5v-.5A8 8 0 0022 5.8z"/></svg></a>
						<a href="#"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zM8.3 18.3H5.7V10h2.6v8.3zM7 8.8a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm11.3 9.5h-2.6v-4c0-1-.4-1.7-1.3-1.7-.7 0-1.1.5-1.3 1-.1.2-.1.4-.1.7v4h-2.6V10h2.6v1.1c.3-.5 1-1.3 2.4-1.3 1.7 0 3 1.2 3 3.6v4.9z"/></svg></a>
						<a href="#"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 00-3.2 19.5c.5.1.7-.2.7-.5v-1.7c-2.8.6-3.4-1.3-3.4-1.3-.5-1.2-1.1-1.5-1.1-1.5-.9-.6.1-.6.1-.6 1 .1 1.5 1 1.5 1 .9 1.5 2.3 1.1 2.9.8.1-.6.3-1.1.6-1.3-2.2-.3-4.6-1.1-4.6-5 0-1.1.4-2 1-2.7-.1-.3-.4-1.3.1-2.6 0 0 .8-.3 2.7 1a9.3 9.3 0 015 0c1.9-1.3 2.7-1 2.7-1 .5 1.3.2 2.3.1 2.6.6.7 1 1.6 1 2.7 0 3.9-2.3 4.7-4.6 5 .4.3.7.9.7 1.8v2.7c0 .3.2.6.7.5A10 10 0 0012 2z"/></svg></a>
					</div>
				</div>
				<div class="[&_a]:block [&_a]:text-[#9aa6bd] [&_a]:text-sm [&_a]:py-1.5 [&_a:hover]:text-white">
					<h5 class="font-display text-white text-sm tracking-[.04em] mb-[18px] font-semibold">For students</h5>
					<Link :href="route('internships.index')">Browse internships</Link>
					<Link :href="route('register')">Create profile</Link>
					<a href="#">Career resources</a>
					<Link :href="route('blog.index')">Blog</Link>
				</div>
				<div class="[&_a]:block [&_a]:text-[#9aa6bd] [&_a]:text-sm [&_a]:py-1.5 [&_a:hover]:text-white">
					<h5 class="font-display text-white text-sm tracking-[.04em] mb-[18px] font-semibold">For companies</h5>
					<Link :href="route('register')">Post a role</Link>
					<a href="#">Pricing</a>
					<a href="#">Hiring guide</a>
					<Link :href="route('contact')">Book a demo</Link>
				</div>
				<div class="[&_a]:block [&_a]:text-[#9aa6bd] [&_a]:text-sm [&_a]:py-1.5 [&_a:hover]:text-white">
					<h5 class="font-display text-white text-sm tracking-[.04em] mb-[18px] font-semibold">Company</h5>
					<Link :href="route('about')">About</Link>
					<Link :href="route('contact')">Contact</Link>
					<a href="#">Privacy</a>
					<a href="#">Terms</a>
				</div>
			</div>
			<div class="flex justify-between items-center mt-[54px] pt-[26px] border-t border-white/[.09] text-[13px] text-[#7c89a3] max-[820px]:flex-col max-[820px]:gap-3.5">
				<span>© 2026 Internly. All rights reserved.</span>
				<span>Made for students, by people who remember being one.</span>
			</div>
		</div>
	</footer>
</template>
