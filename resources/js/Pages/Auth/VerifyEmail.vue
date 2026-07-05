<script setup>
import { computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AuthSplit from '@/Layouts/AuthSplit.vue';

defineOptions({
	layout: (_h, page) => page,
});

const props = defineProps({
	status: String,
});

const form = useForm({});
const submit = () => form.post(route('verification.send'));

const linkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
	<AuthSplit
		headline="One quick check."
		copy="Verifying your email keeps your account secure and makes sure application updates reach you."
		:bullets="['Check your spam folder too', 'The link works once', 'You can resend any time']"
	>
		<h1 class="font-display text-[30px] font-semibold mb-2">Verify your email</h1>
		<p class="text-muted text-[15.5px] mb-[30px]">Thanks for signing up! Click the link in the email we just sent you. Didn't get it? We'll gladly send another.</p>

		<div v-if="linkSent" class="mb-4 text-sm font-semibold text-[#047857]">A new verification link has been sent to your email address.</div>

		<form @submit.prevent="submit">
			<button class="w-full justify-center inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-blue-600 text-white hover:bg-blue-700 transition-colors" type="submit" :disabled="form.processing">
				Resend verification email
			</button>
		</form>

		<p class="text-center text-sm text-muted mt-[22px]">
			<Link class="text-blue-700 font-semibold" :href="route('logout')" method="post" as="button">Log out</Link>
		</p>

		<template #stats>
			<div><b>1k+</b><span>Students</span></div>
			<div><b>250+</b><span>Open roles</span></div>
			<div><b>100+</b><span>Companies</span></div>
		</template>
	</AuthSplit>
</template>
