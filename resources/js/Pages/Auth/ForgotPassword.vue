<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AuthSplit from '@/Layouts/AuthSplit.vue';

defineOptions({
	layout: (_h, page) => page,
});

defineProps({
	status: String,
});

const form = useForm({ email: '' });
const submit = () => form.post(route('password.email'));
</script>

<template>
	<AuthSplit
		headline="Locked out? It happens."
		copy="Tell us the email on your account and we'll send you a link to choose a new password."
		:bullets="['The link expires after 60 minutes', 'Your applications stay untouched', 'You can request a new link any time']"
	>
		<div class="flex justify-between items-center text-sm text-muted mb-[46px] [&_a]:text-blue-700 [&_a]:font-semibold">
			<Link :href="route('login')">← Back to log in</Link>
		</div>

		<h1 class="font-display text-[30px] font-semibold mb-2">Forgot your password?</h1>
		<p class="text-muted text-[15.5px] mb-[30px]">No problem. Enter your email and we'll send you a reset link.</p>

		<div v-if="status" class="mb-4 text-sm font-semibold text-[#047857]">{{ status }}</div>

		<form @submit.prevent="submit">
			<div class="mb-6">
				<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Email</label>
				<input v-model="form.email" class="fld !py-[13px]" type="email" placeholder="you@university.edu" required autofocus>
				<div v-if="form.errors.email" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.email }}</div>
			</div>

			<button class="w-full justify-center inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-blue-600 text-white hover:bg-blue-700 transition-colors" type="submit" :disabled="form.processing">
				Email password reset link
			</button>
		</form>

		<template #stats>
			<div><b>1k+</b><span>Students</span></div>
			<div><b>250+</b><span>Open roles</span></div>
			<div><b>100+</b><span>Companies</span></div>
		</template>
	</AuthSplit>
</template>
