<template>
  <public-layout>
    <section class="bg-white overflow-hidden">
      <div class="in-wrap in-section in-hero-grid">
        <div>
          <div class="in-pill"><span class="in-pill-dot"></span> Public internship platform for Tunisia</div>
          <h1 class="in-hero-title in-display mt-7">Discover internships. Apply with confidence.</h1>
          <p class="in-hero-lead mt-6">Internly connects students with internship opportunities from trusted companies, then keeps applications, saved roles, and recruiter conversations in one clean workspace.</p>
          <div class="mt-8 flex flex-col sm:flex-row gap-3">
            <inertia-link :href="route('internships.index')" class="in-btn in-btn-primary">Browse internships</inertia-link>
            <inertia-link :href="route('register')" class="in-btn in-btn-ghost">Create free account</inertia-link>
          </div>
          <div class="mt-10 grid grid-cols-3 gap-4 max-w-xl">
            <div v-for="stat in stats" :key="stat.label" class="in-card p-4">
              <div class="in-heading text-2xl font-bold">{{ stat.value }}</div>
              <div class="mt-1 text-xs font-bold uppercase tracking-wide text-gray-500">{{ stat.label }}</div>
            </div>
          </div>
        </div>

        <div class="in-board">
          <div class="in-board-top">
            <div>
              <div class="text-xs uppercase tracking-widest text-blue-200">Live board</div>
              <div class="in-heading text-xl font-bold">Featured internships</div>
            </div>
            <span class="in-tag in-tag-blue">Updated today</span>
          </div>
          <div v-for="role in featuredRoles" :key="role.title" class="in-board-row">
            <div class="in-logo-tile">{{ role.company[0] }}</div>
            <div class="min-w-0 flex-1">
              <div class="font-bold text-gray-900">{{ role.title }}</div>
              <div class="mt-1 text-sm text-gray-500">{{ role.company }} · {{ role.city }} · {{ role.type }}</div>
              <div class="mt-3 flex flex-wrap gap-2">
                <span v-for="tag in role.tags" :key="tag" class="in-tag">{{ tag }}</span>
              </div>
            </div>
            <div class="hidden sm:block text-right">
              <div class="font-bold text-blue-700">{{ role.pay }}</div>
              <div class="text-xs text-gray-500 mt-1">{{ role.deadline }}</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="in-section in-navy">
      <div class="in-wrap">
        <div class="max-w-2xl">
          <div class="text-blue-300 text-sm font-bold uppercase tracking-widest">How it works</div>
          <h2 class="in-display mt-4 text-4xl md:text-5xl font-bold">A focused workflow from search to offer.</h2>
        </div>
        <div class="mt-10 grid md:grid-cols-3 gap-5">
          <div v-for="step in steps" :key="step.title" class="rounded-3xl border border-white border-opacity-10 p-6 bg-white bg-opacity-5">
            <div class="h-11 w-11 rounded-2xl bg-blue-600 text-white grid place-items-center font-bold">{{ step.no }}</div>
            <h3 class="mt-5 text-xl font-bold">{{ step.title }}</h3>
            <p class="mt-3 text-blue-100 leading-7">{{ step.text }}</p>
          </div>
        </div>
      </div>
    </section>

    <section class="in-section">
      <div class="in-wrap">
        <div class="grid lg:grid-cols-2 gap-6">
          <div class="in-card p-7">
            <div class="in-pill">For students</div>
            <h2 class="in-display mt-5 text-4xl font-bold">Less guessing. More momentum.</h2>
            <div class="mt-6 space-y-4">
              <div v-for="item in studentBenefits" :key="item" class="flex gap-3">
                <div class="mt-1 h-6 w-6 rounded-lg bg-blue-50 text-blue-700 grid place-items-center text-sm font-bold">✓</div>
                <p class="text-gray-600 leading-7">{{ item }}</p>
              </div>
            </div>
          </div>
          <div class="in-card p-7 bg-blue-600 text-white border-blue-600">
            <div class="inline-flex rounded-full bg-white bg-opacity-15 px-3 py-1 text-sm font-bold">For companies</div>
            <h2 class="in-display mt-5 text-4xl font-bold text-white">Post roles and review candidates faster.</h2>
            <div class="mt-6 space-y-4">
              <div v-for="item in companyBenefits" :key="item" class="flex gap-3">
                <div class="mt-1 h-6 w-6 rounded-lg bg-white text-blue-700 grid place-items-center text-sm font-bold">✓</div>
                <p class="text-blue-50 leading-7">{{ item }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="in-section bg-white">
      <div class="in-wrap">
        <div class="max-w-2xl">
          <div class="text-blue-700 text-sm font-bold uppercase tracking-widest">FAQ</div>
          <h2 class="in-display mt-4 text-4xl font-bold">Questions students ask before applying.</h2>
        </div>
        <div class="mt-8 grid md:grid-cols-2 gap-4">
          <div v-for="faq in faqs" :key="faq.q" class="in-faq-item">
            <h3 class="font-bold text-gray-900">{{ faq.q }}</h3>
            <p class="mt-3 text-gray-600 leading-7">{{ faq.a }}</p>
          </div>
        </div>
      </div>
    </section>

    <section class="in-section">
      <div class="in-wrap">
        <div class="in-navy rounded-3xl p-8 md:p-12 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
          <div class="max-w-2xl">
            <h2 class="in-display text-4xl font-bold text-white">Ready to find your next internship?</h2>
            <p class="mt-4 text-blue-100 leading-7">Browse public listings now, then create an account when you're ready to save roles and apply.</p>
          </div>
          <div class="flex flex-col sm:flex-row gap-3">
            <inertia-link :href="route('internships.index')" class="in-btn bg-white text-gray-900">Browse roles</inertia-link>
            <inertia-link :href="route('register')" class="in-btn in-btn-primary">Join Internly</inertia-link>
          </div>
        </div>
      </div>
    </section>
  </public-layout>
</template>

<script>
import PublicLayout from '@/Layouts/Public'

export default {
  components: { PublicLayout },
  data() {
    return {
      stats: [
        { value: '500+', label: 'Students' },
        { value: '120+', label: 'Companies' },
        { value: '48h', label: 'Avg reply' },
      ],
      featuredRoles: [
        { title: 'Frontend Developer Intern', company: 'Expensya', city: 'Tunis', type: 'Hybrid', pay: '900 DT/mo', deadline: 'Closes Jun 28', tags: ['Vue', 'UX', 'SaaS'] },
        { title: 'Data Science Intern', company: 'Keyrus', city: 'Ariana', type: 'On-site', pay: 'Academic credit', deadline: 'Closes Jul 03', tags: ['Python', 'BI', 'ML'] },
        { title: 'Mobile Engineer Intern', company: 'Satoripop', city: 'Sousse', type: 'Remote', pay: '750 DT/mo', deadline: 'Closes Jul 15', tags: ['React Native', 'API'] },
      ],
      steps: [
        { no: '01', title: 'Discover', text: 'Search by field, city, company, or keyword and find roles that match your skills.' },
        { no: '02', title: 'Apply', text: 'Submit your application with your profile, cover letter, and attachments.' },
        { no: '03', title: 'Track', text: 'Follow application status and keep recruiter messages in one dashboard.' },
      ],
      studentBenefits: ['Save internships and return later.', 'Track every application from submitted to interview.', 'Message companies without losing context.'],
      companyBenefits: ['Publish internships in minutes.', 'Review applicants from one clean pipeline.', 'Contact students and keep decisions organized.'],
      faqs: [
        { q: 'Is Internly free for students?', a: 'Yes. Students can browse internships, create a profile, save roles, and apply for free.' },
        { q: 'Can companies post internships?', a: 'Yes. Company accounts include profile onboarding and internship posting tools.' },
        { q: 'Do I need an account to browse?', a: 'No. Public internship pages are visible. You only need an account to apply or save roles.' },
        { q: 'Is this only for tech internships?', a: 'No. The current catalog includes software, design, data, marketing, finance, and business roles.' },
      ],
    }
  },
}
</script>
