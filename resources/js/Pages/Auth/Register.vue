<script setup>
import { computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AuthSplit from '@/Layouts/AuthSplit.vue';

defineOptions({
	layout: (_h, page) => page, // full-screen page, no workspace chrome
});

defineProps({
	cities: { type: Array, default: () => [] },
	fields: { type: Array, default: () => [] },
});

const icons = {
	arrow: '<svg viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	student: '<svg viewBox="0 0 24 24" fill="none"><path d="M3 8l9-4 9 4-9 4-9-4z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M7 10v5c0 1 2.2 2.5 5 2.5s5-1.5 5-2.5v-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	company: '<svg viewBox="0 0 24 24" fill="none"><path d="M3 21V8l7-4 7 4v13M9 21v-6h2v6M3 21h18M14 9h3v3h-3zM14 14h3v3h-3z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
};

const form = useForm({
	account_type: 'student',
	name: '',
	email: '',
	password: '',
	password_confirmation: '',
	phone_number: '',
	city_id: null,
	field_id: null,
	about: '',
	website: '',
	company_logo: null,
	terms: false,
});

const isCompany = computed(() => form.account_type === 'company');

const submit = () => {
	form.post(route('register'), {
		onFinish: () => form.reset('password', 'password_confirmation'),
	});
};
</script>

<template>
	<AuthSplit
		headline="Start your internship journey the right way."
		copy="Create one profile and apply to hundreds of verified internships — or post roles and meet great candidates."
		:bullets="[
			'Apply to roles with one click',
			'Track every application in real time',
			'Message recruiters directly',
		]"
	>
		<div class="flex justify-between items-center text-sm text-muted mb-[34px] [&_a]:text-blue-700 [&_a]:font-semibold">
			<Link :href="route('home')">← Back to home</Link>
			<span>Already registered? <Link :href="route('login')">Log in</Link></span>
		</div>

		<h1 class="font-display text-[30px] font-semibold mb-2">Create your account</h1>
		<p class="text-muted text-[15.5px] mb-7">Tell us who you are so we can set up the right workspace.</p>

		<form @submit.prevent="submit">
			<span class="block text-[13.5px] font-semibold text-ink mb-[9px]">I am joining as</span>
			<div class="grid grid-cols-2 gap-3 mb-6">
				<div
					v-for="role in ['student', 'company']"
					:key="role"
					class="border-[1.5px] rounded-[14px] p-4 cursor-pointer transition-all bg-white hover:border-blue-300"
					:class="form.account_type === role ? 'border-blue-600 bg-blue-50' : 'border-line'"
					@click="form.account_type = role"
				>
					<div class="w-[38px] h-[38px] rounded-[10px] grid place-items-center mb-3 border [&_svg]:w-[19px] [&_svg]:h-[19px]" :class="form.account_type === role ? 'bg-blue-600 text-white border-blue-600' : 'bg-white border-line text-blue-700'" v-html="role === 'student' ? icons.student : icons.company"></div>
					<b class="text-[15px] font-display block mb-0.5">{{ role === 'student' ? 'Student' : 'Company' }}</b>
					<span class="text-[12.5px] text-muted leading-[1.4]">{{ role === 'student' ? 'Find and apply to internships.' : 'Post roles & hire interns.' }}</span>
				</div>
			</div>

			<div class="mb-4">
				<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">{{ isCompany ? 'Company name' : 'Full name' }}</label>
				<input v-model="form.name" class="fld" type="text" :placeholder="isCompany ? 'Acme Inc.' : 'Jordan Lee'" required>
				<div v-if="form.errors.name" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.name }}</div>
			</div>

			<div class="mb-4">
				<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Email</label>
				<input v-model="form.email" class="fld" type="email" :placeholder="isCompany ? 'careers@acme.com' : 'you@university.edu'" required>
				<div v-if="form.errors.email" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.email }}</div>
			</div>

			<div class="grid grid-cols-2 gap-3.5">
				<div class="mb-4">
					<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Password</label>
					<input v-model="form.password" class="fld" type="password" placeholder="••••••••" required autocomplete="new-password">
					<div v-if="form.errors.password" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.password }}</div>
				</div>
				<div class="mb-4">
					<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Confirm password</label>
					<input v-model="form.password_confirmation" class="fld" type="password" placeholder="••••••••" required autocomplete="new-password">
				</div>
			</div>

			<div class="grid grid-cols-2 gap-3.5">
				<div class="mb-4">
					<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">City</label>
					<select v-model="form.city_id" class="fld">
						<option :value="null" disabled>Select city</option>
						<option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
					</select>
					<div v-if="form.errors.city_id" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.city_id }}</div>
				</div>
				<div class="mb-4">
					<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Phone number</label>
					<input v-model="form.phone_number" class="fld" type="tel" placeholder="+216 00 000 000">
					<div v-if="form.errors.phone_number" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.phone_number }}</div>
				</div>
			</div>

			<!-- student fields -->
			<template v-if="!isCompany">
				<div class="mb-4">
					<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Field of study</label>
					<select v-model="form.field_id" class="fld">
						<option :value="null" disabled>Select field</option>
						<option v-for="field in fields" :key="field.id" :value="field.id">{{ field.name }}</option>
					</select>
					<div v-if="form.errors.field_id" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.field_id }}</div>
				</div>
				<div class="mb-4">
					<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Short bio <span class="text-muted-2 font-medium">(optional)</span></label>
					<textarea v-model="form.about" class="fld resize-y min-h-[92px]" placeholder="Tell companies a little about yourself."></textarea>
				</div>
			</template>

			<!-- company fields -->
			<template v-else>
				<div class="mb-4">
					<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Website</label>
					<input v-model="form.website" class="fld" type="url" placeholder="https://acme.com">
					<div v-if="form.errors.website" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.website }}</div>
				</div>
				<div class="mb-4">
					<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">About the company</label>
					<textarea v-model="form.about" class="fld resize-y min-h-[92px]" placeholder="What do you build, and what will interns work on?"></textarea>
					<div v-if="form.errors.about" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.about }}</div>
				</div>
				<div class="mb-4">
					<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Company logo</label>
					<input class="fld !py-[9px]" type="file" accept="image/*" @input="form.company_logo = $event.target.files[0]">
					<div v-if="form.errors.company_logo" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.company_logo }}</div>
				</div>
			</template>

			<label class="flex items-start gap-2.5 my-1.5 mb-[22px] text-[13px] text-muted leading-[1.5] [&_a]:text-blue-700 [&_a]:font-semibold">
				<input v-model="form.terms" class="ck mt-px" type="checkbox" required>
				<span>I agree to Internly's <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</span>
			</label>

			<div class="flex items-center justify-between gap-4 mt-1">
				<span class="text-sm text-muted">Already have an account? <Link class="text-blue-700 font-semibold" :href="route('login')">Log in</Link></span>
				<button class="inline-flex items-center gap-2.5 font-semibold text-base px-7 py-4 rounded-[13px] bg-blue-600 text-white hover:bg-blue-700 transition-colors [&_svg]:w-[17px] [&_svg]:h-[17px]" type="submit" :disabled="form.processing">
					Create account <span class="contents" v-html="icons.arrow"></span>
				</button>
			</div>
		</form>

		<template #stats>
			<div><b>1k+</b><span>Students</span></div>
			<div><b>250+</b><span>Open roles</span></div>
			<div><b>100+</b><span>Companies</span></div>
		</template>
	</AuthSplit>
</template>
