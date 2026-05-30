<template>
    <div>
        <div class="mb-7">
            <div class="in-pill"><span class="in-pill-dot"></span> Welcome back</div>
            <h1 class="in-display mt-4 text-3xl font-bold text-gray-900">Sign in to Internly</h1>
            <p class="mt-2 text-sm text-gray-600 leading-6">Continue to your internship dashboard, saved roles, messages, and applications.</p>
        </div>

        <breeze-validation-errors class="mb-4" />
        <div v-if="status" class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 font-medium text-sm text-green-700">{{ status }}</div>

        <div class="mb-5 rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3 text-xs text-blue-900 leading-relaxed">
            <strong>Demo accounts:</strong><br>
            Admin: <strong>admin@example.com</strong> / <strong>password</strong><br>
            Company: <strong>company@example.com</strong> / <strong>password</strong><br>
            Student: <strong>student@example.com</strong> / <strong>password</strong>
        </div>

        <form spellcheck="false" autocomplete="off" @submit.prevent="submit" class="space-y-5">
            <div>
                <breeze-label for="email" value="Email" class="in-label" />
                <breeze-input id="email" type="email" class="mt-1" v-model="form.email" required autofocus />
            </div>

            <div>
                <breeze-label for="password" value="Password" class="in-label" />
                <breeze-input id="password" type="password" class="mt-1" v-model="form.password" required />
            </div>

            <div class="flex items-center justify-between gap-4">
                <label class="flex items-center">
                    <breeze-checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                <inertia-link v-if="canResetPassword" :href="route('password.request')" class="text-sm font-bold text-blue-700 hover:text-blue-800">Forgot password?</inertia-link>
            </div>

            <breeze-button class="in-btn-block" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Log in</breeze-button>

            <div class="relative py-2 text-center text-xs font-bold uppercase tracking-widest text-gray-400">
                <span class="bg-white px-3 relative z-10">or</span>
                <div class="absolute left-0 right-0 top-1/2 border-t border-gray-100"></div>
            </div>

            <div class="grid sm:grid-cols-2 gap-3">
                <button type="button" class="in-btn in-btn-ghost">Continue with Google</button>
                <button type="button" class="in-btn in-btn-ghost">Continue with LinkedIn</button>
            </div>

            <p class="pt-2 text-center text-sm text-gray-600">
                New to Internly?
                <inertia-link :href="route('register')" class="font-bold text-blue-700 hover:text-blue-800">Create an account</inertia-link>
            </p>
        </form>
    </div>
</template>

<script>
    import BreezeButton from '@/Components/Breeze/Button'
    import BreezeGuestLayout from "@/Layouts/Guest"
    import BreezeInput from '@/Components/Breeze/Input'
    import BreezeCheckbox from '@/Components/Breeze/Checkbox'
    import BreezeLabel from '@/Components/Breeze/Label'
    import BreezeValidationErrors from '@/Components/ValidationErrors'

    export default {
        layout: BreezeGuestLayout,
        components: { BreezeButton, BreezeInput, BreezeCheckbox, BreezeLabel, BreezeValidationErrors },
        props: { auth: Object, canResetPassword: Boolean, errors: Object, status: String },
        data() {
            return { form: this.$inertia.form({ email: 'admin@example.com', password: 'password', remember: false }) }
        },
        methods: {
            submit() {
                this.form.transform(data => ({ ...data, remember: this.form.remember ? 'on' : '' }))
                    .post(this.route('login'), { onFinish: () => this.form.reset('password') })
            }
        }
    }
</script>
