<script setup>
import { h } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import AppShell from '@/Layouts/AppShell.vue';

defineOptions({
	layout: (_h, page) => h(AppShell, { active: 'students' }, () => page),
});

const props = defineProps({
	student: { type: Object, required: true },
	fields: { type: Array, default: () => [] },
	cities: { type: Array, default: () => [] },
});

const icons = {
	chevron: '<svg viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
};

const form = useForm({
	name: props.student.name,
	email: props.student.email,
	phone_number: props.student.phone_number,
	city_id: props.student.city_id ?? props.student.city?.id ?? null,
	field_id: props.student.field_id ?? props.student.field?.id ?? null,
	about: props.student.about,
});

const submit = () => form.put(route('students.update', props.student.id));

const destroy = () => {
	if (confirm('Delete this student and everything attached to them? This cannot be undone.')) {
		router.delete(route('students.destroy', props.student.id));
	}
};
</script>

<template>
	<div class="px-10 pt-7 pb-14 w-full max-w-[860px]">
		<div class="flex items-center gap-2 text-[13.5px] text-muted font-medium mb-[22px] [&_svg]:w-3.5 [&_svg]:h-3.5 [&_svg]:text-muted-2">
			<Link class="hover:text-blue-700" :href="route('students.index')">Students</Link>
			<span class="contents" v-html="icons.chevron"></span>
			<span class="text-ink-700 font-semibold">{{ student.name }}</span>
		</div>

		<div class="mb-6">
			<span class="block font-display text-[12.5px] font-semibold tracking-[.18em] uppercase text-blue-600 mb-2">Catalog</span>
			<h1 class="font-display text-[32px] font-semibold tracking-[-.02em]">Edit student</h1>
		</div>

		<form class="bg-white border border-line rounded-[18px]" @submit.prevent="submit">
			<div class="px-8 py-[26px]">
				<div class="grid grid-cols-2 gap-4 max-[560px]:grid-cols-1">
					<div class="mb-4">
						<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Full name</label>
						<input v-model="form.name" class="fld" type="text">
						<div v-if="form.errors.name" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.name }}</div>
					</div>
					<div class="mb-4">
						<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Email</label>
						<input v-model="form.email" class="fld" type="email">
						<div v-if="form.errors.email" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.email }}</div>
					</div>
				</div>
				<div class="grid grid-cols-2 gap-4 max-[560px]:grid-cols-1">
					<div class="mb-4">
						<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Phone</label>
						<input v-model="form.phone_number" class="fld" type="tel">
						<div v-if="form.errors.phone_number" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.phone_number }}</div>
					</div>
					<div class="mb-4">
						<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">City</label>
						<select v-model="form.city_id" class="fld">
							<option :value="null">—</option>
							<option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
						</select>
					</div>
				</div>
				<div class="mb-4">
					<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">Field of study</label>
					<select v-model="form.field_id" class="fld">
						<option :value="null">—</option>
						<option v-for="field in fields" :key="field.id" :value="field.id">{{ field.name }}</option>
					</select>
					<div v-if="form.errors.field_id" class="text-xs text-[#dc2626] mt-[7px]">{{ form.errors.field_id }}</div>
				</div>
				<div>
					<label class="block text-[13px] font-semibold mb-[7px] text-ink-700">About</label>
					<textarea v-model="form.about" class="fld"></textarea>
				</div>
			</div>
			<div class="px-8 py-4 border-t border-line-2 flex items-center gap-2.5 bg-white rounded-b-[18px]">
				<button class="cbtn !px-[18px] !py-2.5 bg-[#dc2626] text-white hover:bg-[#b91c1c]" type="button" @click="destroy">Delete</button>
				<div class="flex-1"></div>
				<Link class="cbtn bg-white text-ink border border-line hover:border-blue-300 hover:text-blue-700" :href="route('students.show', student.id)">Cancel</Link>
				<button class="cbtn bg-blue-600 text-white hover:bg-blue-700" type="submit" :disabled="form.processing">Save changes</button>
			</div>
		</form>
	</div>
</template>
