<template>
    <div>
        <div class="mb-7">
            <div class="in-pill"><span class="in-pill-dot"></span> Create workspace</div>
            <h1 class="in-display mt-4 text-3xl font-bold text-gray-900">Create your Internly account</h1>
            <p class="mt-2 text-sm text-gray-600 leading-6">Choose your role so Internly can set up the right dashboard.</p>
        </div>

        <breeze-validation-errors class="mb-4" />

        <form spellcheck="false" @submit.prevent="submit" enctype="multipart/form-data" class="space-y-5">
            <div>
                <breeze-label value="I am joining as" class="in-label" />
                <div class="mt-2 grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <button type="button" @click="form.account_type = 'student'" :class="accountTypeClass('student')">
                        <span class="text-2xl">🎓</span>
                        <span class="font-bold">Student</span>
                        <span class="text-xs text-gray-500">Find and apply to internships.</span>
                    </button>
                    <button type="button" @click="form.account_type = 'company'" :class="accountTypeClass('company')">
                        <span class="text-2xl">🏢</span>
                        <span class="font-bold">Company</span>
                        <span class="text-xs text-gray-500">Post internships and review candidates.</span>
                    </button>
                </div>
            </div>

            <div>
                <breeze-label for="name" :value="form.account_type === 'company' ? 'Company name' : 'Full name'" class="in-label" />
                <breeze-input id="name" type="text" class="mt-1" v-model="form.name" required autofocus autocomplete="name" />
            </div>

            <div>
                <breeze-label for="email" value="Email" class="in-label" />
                <breeze-input id="email" type="email" class="mt-1" v-model="form.email" required autocomplete="username" />
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <breeze-label for="password" value="Password" class="in-label" />
                    <breeze-input id="password" type="password" class="mt-1" v-model="form.password" required autocomplete="new-password" />
                </div>
                <div>
                    <breeze-label for="password_confirmation" value="Confirm password" class="in-label" />
                    <breeze-input id="password_confirmation" type="password" class="mt-1" v-model="form.password_confirmation" required autocomplete="new-password" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <breeze-label for="city_id" value="City" class="in-label" />
                    <select id="city_id" v-model="form.city_id" class="in-select mt-1" required>
                        <option :value="null" disabled>Select city</option>
                        <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                    </select>
                </div>
                <div>
                    <breeze-label for="phone_number" value="Phone number" class="in-label" />
                    <breeze-input id="phone_number" type="text" class="mt-1" v-model="form.phone_number" autocomplete="tel" />
                </div>
            </div>

            <div v-if="form.account_type === 'student'">
                <breeze-label for="field_id" value="Field of study" class="in-label" />
                <select id="field_id" v-model="form.field_id" class="in-select mt-1" required>
                    <option :value="null" disabled>Select field</option>
                    <option v-for="field in fields" :key="field.id" :value="field.id">{{ field.name }}</option>
                </select>
            </div>

            <div v-if="form.account_type === 'company'" class="rounded-3xl border border-blue-100 bg-blue-50 p-5 space-y-4">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wide text-blue-900">Company onboarding</h2>
                    <p class="mt-1 text-sm text-blue-800 leading-6">Complete your public company profile before posting roles.</p>
                </div>
                <div>
                    <breeze-label for="company_logo" value="Company logo" class="in-label" />
                    <input id="company_logo" type="file" accept="image/*" @change="handleLogo" class="mt-1 block w-full text-sm text-gray-700" required />
                </div>
                <div>
                    <breeze-label for="website" value="Website" class="in-label" />
                    <breeze-input id="website" type="url" class="mt-1" v-model="form.website" required placeholder="https://company.com" />
                </div>
                <div>
                    <breeze-label for="linkedin_profile_url" value="LinkedIn page" class="in-label" />
                    <breeze-input id="linkedin_profile_url" type="url" class="mt-1" v-model="form.linkedin_profile_url" placeholder="https://linkedin.com/company/example" />
                </div>
            </div>

            <div>
                <breeze-label for="about" :value="form.account_type === 'company' ? 'About your company' : 'Short bio (optional)'" class="in-label" />
                <textarea id="about" v-model="form.about" :required="form.account_type === 'company'" rows="5" class="in-textarea mt-1" :placeholder="form.account_type === 'company' ? 'What do you build, what is your culture like, and why should students apply?' : 'Tell companies a little about yourself.'"></textarea>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
                <inertia-link :href="route('login')" class="text-sm font-bold text-blue-700 hover:text-blue-800">Already registered?</inertia-link>
                <breeze-button class="sm:ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{ form.account_type === 'company' ? 'Complete onboarding' : 'Create account' }}
                </breeze-button>
            </div>
        </form>
    </div>
</template>

<script>
    import BreezeButton from '@/Components/Breeze/Button'
    import BreezeGuestLayout from '@/Layouts/Guest'
    import BreezeInput from '@/Components/Breeze/Input'
    import BreezeLabel from '@/Components/Breeze/Label'
    import BreezeValidationErrors from '@/Components/ValidationErrors'

    export default {
        layout: BreezeGuestLayout,
        components: { BreezeButton, BreezeInput, BreezeLabel, BreezeValidationErrors },
        props: { cities: Array, fields: Array },
        data() {
            return { form: this.$inertia.form({ account_type: 'student', name: '', email: '', password: '', password_confirmation: '', phone_number: '', linkedin_profile_url: '', city_id: null, field_id: null, website: '', about: '', company_logo: null }) }
        },
        methods: {
            accountTypeClass(type) {
                const active = this.form.account_type === type
                return ['flex flex-col items-start gap-1 rounded-2xl border p-4 text-left transition', active ? 'border-blue-500 bg-white ring-4 ring-blue-50' : 'border-gray-200 bg-gray-50 hover:bg-white']
            },
            handleLogo(event) { this.form.company_logo = event.target.files[0] },
            submit() {
                if (this.form.account_type === 'student') { this.form.website = ''; this.form.company_logo = null } else { this.form.field_id = null }
                this.form.post(this.route('register'), { forceFormData: true, onFinish: () => this.form.reset('password', 'password_confirmation') })
            }
        }
    }
</script>
