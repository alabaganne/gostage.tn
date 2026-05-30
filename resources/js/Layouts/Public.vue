<template>
	<div>
		<header class="site-header">
			<div class="wrap nav">
				<inertia-link class="brand" :href="route('home')"><brand-logo /></inertia-link>
				<nav class="nav-links">
					<inertia-link :href="route('internships.index')">Browse internships</inertia-link>
					<inertia-link :href="route('blog.index')">Blog</inertia-link>
					<inertia-link href="/#how">How it works</inertia-link>
					<inertia-link href="/#faq">FAQ</inertia-link>
				</nav>
				<div class="nav-cta">
					<inertia-link v-if="!currentUser" class="login" :href="route('login')">Log in</inertia-link>
					<inertia-link v-if="!currentUser" class="btn btn-primary" :href="route('register')">Create account</inertia-link>
					<inertia-link v-else class="btn btn-primary" :href="route('dashboard')">Dashboard</inertia-link>
				</div>
			</div>
		</header>
		<slot />
		<footer class="site-footer">
			<div class="wrap">
				<div class="cols">
					<div>
						<brand-logo dark />
						<p style="max-width:320px;margin-top:18px;color:#9aa6bd;font-size:14.5px;line-height:1.7">Internly connects ambitious students with verified companies hiring interns across engineering, design, data, product, and growth.</p>
					</div>
					<div><h5>Platform</h5><inertia-link :href="route('internships.index')">Browse internships</inertia-link><inertia-link :href="route('register')">Create account</inertia-link><inertia-link :href="route('login')">Log in</inertia-link></div>
					<div><h5>Resources</h5><inertia-link :href="route('blog.index')">Blog</inertia-link><inertia-link href="/#how">How it works</inertia-link><inertia-link href="/#faq">FAQ</inertia-link></div>
					<div><h5>Company</h5><inertia-link href="/about">About</inertia-link><inertia-link href="/contact">Contact</inertia-link></div>
				</div>
				<div class="foot-bottom"><span>© 2026 Internly. All rights reserved.</span><span>Built for students · companies · career teams</span></div>
			</div>
		</footer>
	</div>
</template>
