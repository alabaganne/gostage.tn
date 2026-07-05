<script setup>
import { h, ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AuthSplit from '@/Layouts/AuthSplit.vue';

defineOptions({
	layout: (_h, page) => page, // full-screen page, no workspace chrome
});

defineProps({
	canResetPassword: Boolean,
	status: String,
});

const icons = {
	arrow: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	eye: '<svg viewBox="0 0 24 24" fill="none"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>',
	eyeOff: '<svg viewBox="0 0 24 24" fill="none"><path d="M3 3l18 18M10.6 10.6a3 3 0 004.2 4.2M9.4 5.2A9.8 9.8 0 0112 5c6.5 0 10 7 10 7a17 17 0 01-3.2 4M6.1 6.1A17 17 0 002 12s3.5 7 10 7a9.7 9.7 0 004-.8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
};

// Demo credentials stay prefilled so reviewers can log straight in.
const form = useForm({
	email: 'student@example.com',
	password: 'password',
	remember: true,
});

const showPassword = ref(false);

const submit = () => {
	form.transform((data) => ({ ...data, remember: data.remember ? 'on' : '' })).post(route('login'), {
		onFinish: () => form.reset('password'),
	});
};
</script>

<template>
	<AuthSplit
		headline="Welcome back. Your next role is waiting."
		copy="Log in to pick up where you left off — track applications, message recruiters, and discover new internships."
		:bullets="[
			'Open roles from real companies, updated daily',
			'One profile, unlimited applications',
			'Real-time status on every role',
		]"
	>
		<div class="flex justify-between items-center text-sm text-muted mb-[46px] [&_a]:text-blue-700 [&_a]:font-semibold">
			<Link :href="route('home')">← Back to home</Link>
			<span>New here? <Link :href="route('register')">Create account</Link></span>
		</div>

		<h1 class="font-display text-[30px] font-semibold mb-2">Log in to Internly</h1>
		<p class="text-muted text-[15.5px] mb-[30px]">Enter your details to access your workspace.</p>

		<div v-if="status" class="mb-4 text-sm font-semibold text-[#047857]">{{ status }}</div>

		<form @submit.prevent="submit">
			<div class="mb-[18px]">
				<div class="flex items-center justify-between mb-[7px]"><label class="block text-[13px] font-semibold text-ink-700">Email</label></div>
				<input v-model="form.email" class="fld !py-[13px]" type="email" placeholder="you@university.edu" required autofocus autocomplete="username">
				<div v-if="form.errors.email" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.email }}</div>
			</div>

			<div class="mb-[18px]">
				<div class="flex items-center justify-between mb-[7px]">
					<label class="block text-[13px] font-semibold text-ink-700">Password</label>
					<Link v-if="canResetPassword" class="text-[12.5px] text-blue-700 font-semibold" :href="route('password.request')">Forgot password?</Link>
				</div>
				<div class="relative">
					<input v-model="form.password" class="fld !py-[13px]" :type="showPassword ? 'text' : 'password'" placeholder="••••••••" required autocomplete="current-password">
					<button class="absolute right-1.5 top-1/2 -translate-y-1/2 w-[34px] h-[34px] border-0 bg-transparent text-muted-2 cursor-pointer grid place-items-center hover:text-ink-700 [&_svg]:w-[19px] [&_svg]:h-[19px]" type="button" aria-label="Show password" @click="showPassword = !showPassword" v-html="showPassword ? icons.eyeOff : icons.eye"></button>
				</div>
				<div v-if="form.errors.password" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.password }}</div>
			</div>

			<div class="flex items-center justify-between my-1 mb-6">
				<label class="flex items-center gap-[9px] text-[13.5px] text-ink-700 cursor-pointer"><input v-model="form.remember" class="ck" type="checkbox"> Remember me</label>
			</div>

			<button class="w-full justify-center inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-blue-600 text-white hover:bg-blue-700 transition-colors [&_svg]:w-[17px] [&_svg]:h-[17px]" type="submit" :disabled="form.processing">
				Log in <span class="contents" v-html="icons.arrow"></span>
			</button>

			<p class="text-center text-sm text-muted mt-[22px]">Don't have an account? <Link class="text-blue-700 font-semibold" :href="route('register')">Create one free</Link></p>
		</form>

		<template #stats>
			<div><b>1k+</b><span>Students</span></div>
			<div><b>250+</b><span>Open roles</span></div>
			<div><b>100+</b><span>Companies</span></div>
		</template>
	</AuthSplit>
</template>
