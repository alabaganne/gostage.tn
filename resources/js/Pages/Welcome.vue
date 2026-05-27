<template>
  <div class="min-h-screen bg-gray-50 text-gray-900">
    <header class="border-b border-gray-200 bg-white/95 backdrop-blur">
      <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <inertia-link href="/" class="flex items-center">
          <brand-logo tagline="Public internship platform" />
        </inertia-link>

        <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-gray-600">
          <inertia-link :href="route('internships.index')" class="hover:text-gray-900 transition">Browse internships</inertia-link>
          <inertia-link :href="route('blog.index')" class="hover:text-gray-900 transition">Blog</inertia-link>
          <inertia-link href="/about" class="hover:text-gray-900 transition">About</inertia-link>
          <inertia-link href="/contact" class="hover:text-gray-900 transition">Contact</inertia-link>
          <inertia-link :href="route('login')" class="hover:text-gray-900 transition">Login</inertia-link>
          <inertia-link :href="route('register')" class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 transition shadow-sm">
            Create account
          </inertia-link>
        </nav>
      </div>
    </header>

    <section class="max-w-7xl mx-auto px-6 pt-16 pb-12 lg:pt-24 lg:pb-20">
      <div class="max-w-4xl">
        <div>
          <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-medium border border-blue-100">
            Built for students, companies, and career teams
          </div>
          <h1 class="mt-6 text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
            Discover internships, apply faster, and connect with companies.
          </h1>
          <p class="mt-6 text-lg text-gray-600 max-w-2xl leading-8">
            Internly is a public internship board and application workspace. Students can find SEO-visible opportunities on the web, while companies publish roles, review candidates, and manage communication from one focused dashboard.
          </p>

          <div class="mt-8 flex flex-col sm:flex-row gap-4">
            <inertia-link :href="route('internships.index')" class="px-6 py-3 rounded-lg bg-gray-900 text-white font-semibold text-center hover:bg-gray-800 transition shadow-sm">
              Browse internships
            </inertia-link>
            <inertia-link :href="route('register')" class="px-6 py-3 rounded-lg bg-white border border-gray-200 text-gray-800 font-semibold text-center hover:bg-gray-50 transition shadow-sm">
              Create account
            </inertia-link>
          </div>

        </div>

      </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 pb-8 lg:pb-12">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <card v-for="stat in stats" :key="stat.label">
          <div class="p-5 md:p-6 text-center">
            <div class="text-sm text-gray-500 uppercase tracking-wide">{{ stat.label }}</div>
            <div class="mt-2 text-3xl md:text-4xl font-extrabold">{{ stat.value }}</div>
          </div>
        </card>
      </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-8 lg:py-12">
      <div class="grid md:grid-cols-3 gap-6">
        <card v-for="audience in audiences" :key="audience.title">
          <div class="p-6">
            <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-5">
              <icon :name="audience.icon" class="h-6 w-6" />
            </div>
            <h2 class="text-xl font-bold">{{ audience.title }}</h2>
            <p class="mt-3 text-gray-600 leading-7">{{ audience.description }}</p>
          </div>
        </card>
      </div>
    </section>

    <section class="bg-white border-y border-gray-200 mt-8">
      <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="max-w-3xl">
          <div class="text-sm uppercase tracking-wide text-gray-500 font-medium">How it works</div>
          <h2 class="mt-3 text-3xl md:text-4xl font-extrabold tracking-tight">A simple workflow from discovery to decision</h2>
          <p class="mt-4 text-gray-600 text-lg leading-8">Internly keeps the process straightforward: discover opportunities, apply with confidence, and manage communication in one clean experience.</p>
        </div>

        <div class="mt-10 grid md:grid-cols-3 gap-6">
          <card v-for="step in steps" :key="step.number">
            <div class="p-6">
              <div class="h-10 w-10 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm font-bold">{{ step.number }}</div>
              <h3 class="mt-5 text-xl font-bold">{{ step.title }}</h3>
              <p class="mt-3 text-gray-600 leading-7">{{ step.description }}</p>
            </div>
          </card>
        </div>
      </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-16">
      <div class="grid lg:grid-cols-2 gap-6">
        <card title="Why students like it" subtitle="Designed to reduce friction and make applications feel manageable.">
          <div class="p-6 space-y-4">
            <div v-for="item in studentBenefits" :key="item.title" class="flex items-start space-x-4">
              <div class="mt-1 h-9 w-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <icon :name="item.icon" class="h-4 w-4" />
              </div>
              <div>
                <div class="font-semibold">{{ item.title }}</div>
                <div class="text-sm text-gray-600 mt-1 leading-6">{{ item.description }}</div>
              </div>
            </div>
          </div>
        </card>

        <card title="Why companies use it" subtitle="A simpler pipeline for publishing internships and reviewing candidates.">
          <div class="p-6 space-y-4">
            <div v-for="item in companyBenefits" :key="item.title" class="flex items-start space-x-4">
              <div class="mt-1 h-9 w-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <icon :name="item.icon" class="h-4 w-4" />
              </div>
              <div>
                <div class="font-semibold">{{ item.title }}</div>
                <div class="text-sm text-gray-600 mt-1 leading-6">{{ item.description }}</div>
              </div>
            </div>
          </div>
        </card>
      </div>
    </section>

    <section class="bg-white border-y border-gray-200">
      <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
          <div class="max-w-3xl">
            <div class="text-sm uppercase tracking-wide text-gray-500 font-medium">Internship resources</div>
            <h2 class="mt-3 text-3xl md:text-4xl font-extrabold tracking-tight">Guides to help students apply and companies hire.</h2>
            <p class="mt-4 text-gray-600 text-lg leading-8">Read practical SEO-friendly guides about internship search, applications, hiring interns, and choosing the right internship platform.</p>
          </div>
          <inertia-link :href="route('blog.index')" class="px-5 py-3 rounded-xl bg-gray-900 text-white font-semibold text-center hover:bg-gray-800 transition">Visit the blog</inertia-link>
        </div>

        <div class="mt-10 grid md:grid-cols-3 gap-6">
          <card v-for="post in featuredPosts" :key="post.slug">
            <div class="p-6">
              <div class="text-sm text-blue-600 font-semibold">{{ post.category }}</div>
              <h3 class="mt-3 text-xl font-bold leading-tight">
                <inertia-link :href="route('blog.show', post.slug)" class="hover:text-blue-700">{{ post.title }}</inertia-link>
              </h3>
              <p class="mt-3 text-gray-600 leading-7">{{ post.excerpt }}</p>
              <inertia-link :href="route('blog.show', post.slug)" class="inline-block mt-5 font-semibold text-blue-700 hover:text-blue-800">Read guide →</inertia-link>
            </div>
          </card>
        </div>
      </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-20">
      <div class="rounded-3xl bg-gray-900 text-white px-8 py-10 md:px-12 md:py-14 shadow-xl">
        <div class="max-w-3xl">
          <div class="text-sm uppercase tracking-wider text-gray-300 font-medium">Ready to launch?</div>
          <h2 class="mt-3 text-3xl md:text-4xl font-extrabold tracking-tight">Make internships easier to find and easier to manage.</h2>
          <p class="mt-4 text-gray-300 text-lg leading-8">
            Whether you're searching for your next internship or managing opportunities for your company, Internly gives you a clean, focused workspace to move faster.
          </p>
          <div class="mt-8 flex flex-col sm:flex-row gap-4">
            <inertia-link :href="route('internships.index')" class="px-6 py-3 rounded-lg bg-white text-gray-900 font-semibold text-center hover:bg-gray-100 transition">
              Browse public internships
            </inertia-link>
            <inertia-link :href="route('register')" class="px-6 py-3 rounded-lg border border-gray-700 text-white font-semibold text-center hover:bg-gray-800 transition">
              Create account
            </inertia-link>
          </div>
        </div>
      </div>
    </section>

    <footer class="border-t border-gray-200 bg-white">
      <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 text-sm text-gray-500">
        <div>
          <div class="font-semibold text-gray-800">Internly</div>
          <div class="mt-1">A streamlined internship platform for students and companies.</div>
        </div>
        <div class="flex items-center gap-6">
          <inertia-link :href="route('internships.index')" class="hover:text-gray-800">Internships</inertia-link>
          <inertia-link :href="route('blog.index')" class="hover:text-gray-800">Blog</inertia-link>
          <inertia-link href="/about" class="hover:text-gray-800">About</inertia-link>
          <inertia-link href="/contact" class="hover:text-gray-800">Contact</inertia-link>
          <a href="https://www.linkedin.com/in/alabaganne/" target="_blank" class="hover:text-gray-800">Built by Ala Baganne</a>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import EmptyLayout from "@/Layouts/Empty";

export default {
  layout: EmptyLayout,
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
  },
  data() {
    return {
      stats: [
        { label: "Students", value: "1k+" },
        { label: "Companies", value: "100+" },
        { label: "Open roles", value: "250+" },
        { label: "Applications", value: "5k+" },
      ],
      featuredPosts: [
        {
          slug: "how-to-find-an-internship-as-a-student",
          category: "Students",
          title: "How to find an internship as a student",
          excerpt: "A practical guide to finding internships, filtering real opportunities, and applying with a stronger profile.",
        },
        {
          slug: "best-internship-application-tips",
          category: "Students",
          title: "Best internship application tips for students",
          excerpt: "Simple ways to make your internship application clearer, more relevant, and easier for companies to review.",
        },
        {
          slug: "how-companies-can-hire-interns-faster",
          category: "Companies",
          title: "How companies can hire interns faster",
          excerpt: "A hiring workflow for companies that want better internship candidates without a messy application process.",
        },
      ],
      audiences: [
        {
          icon: "user-group",
          title: "For students",
          description: "Find internships that actually match your skills, field, and ambition — then apply through a cleaner, more professional flow.",
        },
        {
          icon: "office-building",
          title: "For companies",
          description: "Publish internship opportunities, review applications faster, and manage candidates from one structured dashboard.",
        },
        {
          icon: "document-text",
          title: "For career teams",
          description: "Support employability initiatives with a platform that makes internships easier to discover, organize, and promote.",
        },
      ],
      steps: [
        {
          number: "01",
          title: "Explore",
          description: "Students browse opportunities by role, company, and field to focus on internships that actually fit their goals.",
        },
        {
          number: "02",
          title: "Apply",
          description: "Applications stay simple and structured, giving candidates a better chance to present themselves clearly.",
        },
        {
          number: "03",
          title: "Connect",
          description: "Companies review applicants, communicate with candidates, and move the process forward from one place.",
        },
      ],
      studentBenefits: [
        {
          icon: "filter",
          title: "Better discovery",
          description: "Browse internships in a way that feels curated instead of chaotic.",
        },
        {
          icon: "document-text",
          title: "Clearer applications",
          description: "Apply with the right information in the right place, without unnecessary complexity.",
        },
        {
          icon: "mail",
          title: "Direct communication",
          description: "Keep conversations and updates closer to the application itself.",
        },
      ],
      companyBenefits: [
        {
          icon: "briefcase",
          title: "Publish opportunities quickly",
          description: "Create and manage internship listings through a clean, lightweight workflow.",
        },
        {
          icon: "folder",
          title: "Review candidates efficiently",
          description: "See applications in one place and spend less time navigating clutter.",
        },
        {
          icon: "office-building",
          title: "Present your brand better",
          description: "Offer candidates a more polished first impression than generic job boards.",
        },
      ],
    };
  },
};
</script>
