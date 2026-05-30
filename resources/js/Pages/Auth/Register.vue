<template>
    <div>
        <div class="ftop">
            <inertia-link :href="route('home')">← Back to home</inertia-link>
            <span>Already registered? <inertia-link :href="route('login')">Log in</inertia-link></span>
        </div>

        <h1>Create your account</h1>
        <p class="lede">Tell us who you are so we can set up the right workspace.</p>

        <breeze-validation-errors class="auth-errors" />

        <form spellcheck="false" @submit.prevent="submit" enctype="multipart/form-data">
            <span class="label">I am joining as</span>
            <div class="roles">
                <button type="button" :class="roleClass('student')" data-role="student" @click="setRole('student')">
                    <div class="ri">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M3 8l9-4 9 4-9 4-9-4z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M7 10v5c0 1 2.2 2.5 5 2.5s5-1.5 5-2.5v-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <b>Student</b>
                    <span>Find and apply to internships.</span>
                </button>
                <button type="button" :class="roleClass('company')" data-role="company" @click="setRole('company')">
                    <div class="ri">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M3 21V8l7-4 7 4v13M9 21v-6h2v6M3 21h18M14 9h3v3h-3zM14 14h3v3h-3z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <b>Company</b>
                    <span>Post roles &amp; hire interns.</span>
                </button>
            </div>

            <div class="field">
                <label for="name">{{ form.account_type === 'company' ? 'Company name' : 'Full name' }}</label>
                <input id="name" type="text" v-model="form.name" required autofocus autocomplete="name" :placeholder="form.account_type === 'company' ? 'Acme Inc.' : 'Jordan Lee'">
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" v-model="form.email" required autocomplete="username" placeholder="you@university.edu">
            </div>

            <div class="frow">
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" v-model="form.password" required autocomplete="new-password" placeholder="••••••••">
                </div>
                <div class="field">
                    <label for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" type="password" v-model="form.password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                </div>
            </div>

            <div class="frow">
                <div class="field">
                    <label for="city_id">City</label>
                    <select id="city_id" v-model="form.city_id" required>
                        <option :value="null" disabled>Select city</option>
                        <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                    </select>
                </div>
                <div class="field">
                    <label for="phone_number">Phone number <span class="optional">(optional)</span></label>
                    <input id="phone_number" type="tel" v-model="form.phone_number" autocomplete="tel" placeholder="+216 50 101 959">
                </div>
            </div>

            <div v-if="form.account_type === 'student'" class="student-only">
                <div class="field">
                    <label for="field_id">Field of study</label>
                    <select id="field_id" v-model="form.field_id" required>
                        <option :value="null" disabled>Select field</option>
                        <option v-for="field in fields" :key="field.id" :value="field.id">{{ field.name }}</option>
                    </select>
                </div>
                <div class="field">
                    <label for="about">Short bio <span class="optional">(optional)</span></label>
                    <textarea id="about" v-model="form.about" placeholder="Tell companies a little about yourself."></textarea>
                </div>
            </div>

            <div v-if="form.account_type === 'company'" class="company-only company-box">
                <div class="frow">
                    <div class="field">
                        <label for="website">Website</label>
                        <input id="website" type="url" v-model="form.website" required placeholder="https://acme.com">
                    </div>
                    <div class="field">
                        <label for="linkedin_profile_url">LinkedIn page <span class="optional">(optional)</span></label>
                        <input id="linkedin_profile_url" type="url" v-model="form.linkedin_profile_url" placeholder="https://linkedin.com/company/acme">
                    </div>
                </div>
                <div class="field">
                    <label for="company_logo">Company logo</label>
                    <input id="company_logo" type="file" accept="image/*" @change="handleLogo" required>
                    <div class="hint">PNG or JPG, up to 2MB.</div>
                </div>
                <div class="field">
                    <label for="company_about">About your company</label>
                    <textarea id="company_about" v-model="form.about" required placeholder="What do you build, what is your culture like, and why should students apply?"></textarea>
                </div>
            </div>

            <label class="terms">
                <input type="checkbox" v-model="acceptedTerms">
                <span>I agree to Internly's <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</span>
            </label>

            <div class="submitrow">
                <span class="alt">Already have an account? <inertia-link :href="route('login')">Log in</inertia-link></span>
                <button class="btn btn-primary btn-lg" type="submit" :disabled="form.processing || !acceptedTerms">
                    {{ form.account_type === 'company' ? 'Complete onboarding' : 'Create account' }}
                    <svg viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>

            <div class="divider">or sign up with</div>
            <div class="oauth">
                <button type="button" disabled><svg viewBox="0 0 24 24"><path fill="#4285F4" d="M22.5 12.2c0-.7-.1-1.4-.2-2H12v3.9h5.9a5 5 0 01-2.2 3.3v2.7h3.6c2.1-1.9 3.2-4.8 3.2-7.9z"/><path fill="#34A853" d="M12 23c2.9 0 5.4-1 7.2-2.6l-3.6-2.7c-1 .7-2.3 1.1-3.6 1.1-2.8 0-5.1-1.9-6-4.4H2.3v2.8A11 11 0 0012 23z"/><path fill="#FBBC05" d="M6 14.4a6.6 6.6 0 010-4.2V7.4H2.3a11 11 0 000 9.8z"/><path fill="#EA4335" d="M12 5.5c1.6 0 3 .5 4.1 1.6l3.1-3.1A11 11 0 002.3 7.4L6 10.2C6.9 7.7 9.2 5.5 12 5.5z"/></svg> Google</button>
                <button type="button" disabled><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zM8.3 18.3H5.7V10h2.6v8.3zM7 8.8a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm11.3 9.5h-2.6v-4c0-1-.4-1.7-1.3-1.7-.7 0-1.1.5-1.3 1v4.7h-2.6V10h2.6v1.1c.3-.5 1-1.3 2.4-1.3 1.7 0 3 1.2 3 3.6z"/></svg> LinkedIn</button>
            </div>
        </form>
    </div>
</template>

<script>
    import BreezeGuestLayout from '@/Layouts/Guest'
    import BreezeValidationErrors from '@/Components/ValidationErrors'

    export default {
        layout: BreezeGuestLayout,
        components: { BreezeValidationErrors },
        props: { cities: Array, fields: Array },
        data() {
            return {
                acceptedTerms: true,
                form: this.$inertia.form({
                    account_type: 'student',
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    phone_number: '',
                    linkedin_profile_url: '',
                    city_id: null,
                    field_id: null,
                    website: '',
                    about: '',
                    company_logo: null,
                })
            }
        },
        methods: {
            setRole(type) {
                this.form.account_type = type
                if (type === 'student') {
                    this.form.website = ''
                    this.form.linkedin_profile_url = ''
                    this.form.company_logo = null
                } else {
                    this.form.field_id = null
                }
            },
            roleClass(type) {
                return ['role', this.form.account_type === type ? 'sel' : '']
            },
            handleLogo(event) {
                this.form.company_logo = event.target.files[0]
            },
            submit() {
                if (!this.acceptedTerms) return
                if (this.form.account_type === 'student') {
                    this.form.website = ''
                    this.form.linkedin_profile_url = ''
                    this.form.company_logo = null
                } else {
                    this.form.field_id = null
                }

                this.form.post(this.route('register'), {
                    forceFormData: true,
                    onFinish: () => this.form.reset('password', 'password_confirmation')
                })
            }
        }
    }
</script>

<style scoped>
.auth-errors {
    margin-bottom: 18px;
    border: 1px solid #fecaca;
    background: #fff5f5;
    border-radius: 14px;
    padding: 14px 16px;
}
.role {
    text-align: left;
}
.optional {
    color: var(--muted-2);
    font-weight: 500;
}
.company-box {
    display: block;
    padding: 18px;
    margin: 2px 0 18px;
    border: 1px solid var(--blue-100);
    border-radius: 18px;
    background: var(--blue-50);
}
.terms input {
    margin-top: 2px;
}
.btn:disabled,
.oauth button:disabled {
    cursor: not-allowed;
    opacity: .58;
}
@media (max-width: 620px) {
    .frow,
    .roles,
    .oauth {
        grid-template-columns: 1fr;
    }
    .submitrow {
        align-items: stretch;
        flex-direction: column;
    }
    .submitrow .btn {
        justify-content: center;
        width: 100%;
    }
}
</style>
