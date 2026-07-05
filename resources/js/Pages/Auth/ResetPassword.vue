<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthSplit from '@/Layouts/AuthSplit.vue';

defineOptions({
	layout: (_h, page) => page,
});

const props = defineProps({
	email: String,
	token: String,
});

const form = useForm({
	token: props.token,
	email: props.email,
	password: '',
	password_confirmation: '',
});

const submit = () =>
	form.post(route('password.update'), {
		onFinish: () => form.reset('password', 'password_confirmation'),
	});
</script>

<template>
	<AuthSplit
		headline="Choose a new password."
		copy="Pick something strong that you don't use anywhere else — then you're right back in."
		:bullets="['At least 8 characters', 'You will stay logged in after resetting', 'All your data is exactly as you left it']"
	>
		<h1 class="font-display text-[30px] font-semibold mb-2">Reset password</h1>
		<p class="text-muted text-[15.5px] mb-[30px]">Set a new password for <b class="text-ink-700 font-semibold">{{ email }}</b>.</p>

		<form @submit.prevent="submit">
			<div class="mb-[18px]">
				<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Email</label>
				<input v-model="form.email" class="fld !py-[13px]" type="email" required autocomplete="username">
				<div v-if="form.errors.email" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.email }}</div>
			</div>

			<div class="mb-[18px]">
				<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">New password</label>
				<input v-model="form.password" class="fld !py-[13px]" type="password" placeholder="••••••••" required autofocus autocomplete="new-password">
				<div v-if="form.errors.password" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.password }}</div>
			</div>

			<div class="mb-6">
				<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Confirm password</label>
				<input v-model="form.password_confirmation" class="fld !py-[13px]" type="password" placeholder="••••••••" required autocomplete="new-password">
			</div>

			<button class="w-full justify-center inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-blue-600 text-white hover:bg-blue-700 transition-colors" type="submit" :disabled="form.processing">
				Reset password
			</button>
		</form>

		<template #stats>
			<div><b>1k+</b><span>Students</span></div>
			<div><b>250+</b><span>Open roles</span></div>
			<div><b>100+</b><span>Companies</span></div>
		</template>
	</AuthSplit>
</template>
