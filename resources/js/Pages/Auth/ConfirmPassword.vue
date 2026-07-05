<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthSplit from '@/Layouts/AuthSplit.vue';

defineOptions({
	layout: (_h, page) => page,
});

const form = useForm({ password: '' });

const submit = () =>
	form.post(route('password.confirm'), {
		onFinish: () => form.reset(),
	});
</script>

<template>
	<AuthSplit
		headline="Just making sure it's you."
		copy="You're entering a secure area of the app, so we need your password one more time."
		:bullets="['Your session stays active', 'This only takes a second']"
	>
		<h1 class="font-display text-[30px] font-semibold mb-2">Confirm password</h1>
		<p class="text-muted text-[15.5px] mb-[30px]">This is a secure area of your account. Please confirm your password before continuing.</p>

		<form @submit.prevent="submit">
			<div class="mb-6">
				<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Password</label>
				<input v-model="form.password" class="fld !py-[13px]" type="password" placeholder="••••••••" required autofocus autocomplete="current-password">
				<div v-if="form.errors.password" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.password }}</div>
			</div>

			<button class="w-full justify-center inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-blue-600 text-white hover:bg-blue-700 transition-colors" type="submit" :disabled="form.processing">
				Confirm
			</button>
		</form>

		<template #stats>
			<div><b>1k+</b><span>Students</span></div>
			<div><b>250+</b><span>Open roles</span></div>
			<div><b>100+</b><span>Companies</span></div>
		</template>
	</AuthSplit>
</template>
