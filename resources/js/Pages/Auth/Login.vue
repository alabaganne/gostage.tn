<template>
	<div>
		<div class="ftop"><inertia-link :href="route('home')">← Back to home</inertia-link><span>New here? <inertia-link :href="route('register')">Create account</inertia-link></span></div>
		<h1>Log in to Internly</h1><p class="lede">Continue to your dashboard, applications, messages, and saved roles.</p>
		<breeze-validation-errors class="mb-4" />
		<div class="panel" style="padding:14px 16px;margin-bottom:18px;background:var(--blue-50);color:var(--blue-700);font-size:13px;border-color:var(--blue-100)"><b>Demo:</b> admin@example.com, company@example.com, student@example.com · password</div>
		<form @submit.prevent="submit">
			<div class="field"><label>Email</label><breeze-input type="email" v-model="form.email" required autofocus placeholder="you@university.edu" /></div>
			<div class="field"><label>Password</label><breeze-input type="password" v-model="form.password" required placeholder="••••••••" /></div>
			<label class="terms"><breeze-checkbox name="remember" v-model:checked="form.remember" /> Remember me <inertia-link v-if="canResetPassword" :href="route('password.request')" style="margin-left:auto">Forgot password?</inertia-link></label>
			<div class="submitrow"><span class="alt">No account? <inertia-link :href="route('register')">Create one</inertia-link></span><button class="btn btn-primary btn-lg" :disabled="form.processing">Log in <icon name="sort-descending" /></button></div>
			<div class="divider">or continue with</div><div class="oauth"><button type="button">Google</button><button type="button">LinkedIn</button></div>
		</form>
	</div>
</template>
<script>
import BreezeGuestLayout from '@/Layouts/Guest'; import BreezeInput from '@/Components/Breeze/Input'; import BreezeCheckbox from '@/Components/Breeze/Checkbox'; import BreezeValidationErrors from '@/Components/ValidationErrors'
export default { layout: BreezeGuestLayout, components: { BreezeInput, BreezeCheckbox, BreezeValidationErrors }, props: { canResetPassword: Boolean, status: String }, data() { return { form: this.$inertia.form({ email: 'student@example.com', password: 'password', remember: false }) } }, methods: { submit() { this.form.transform(data => ({ ...data, remember: this.form.remember ? 'on' : '' })).post(this.route('login'), { onFinish: () => this.form.reset('password') }) } } }
</script>
