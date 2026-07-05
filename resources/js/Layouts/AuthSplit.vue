<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
	headline: { type: String, required: true },
	copy: { type: String, required: true },
	bullets: { type: Array, default: () => [] },
});

const logo = '<svg viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
const check = '<svg viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
</script>

<template>
	<div class="grid grid-cols-[1fr_1.15fr] h-screen max-[900px]:grid-cols-1 font-body text-ink bg-paper antialiased leading-[1.55]">
		<!-- LEFT -->
		<aside class="relative overflow-hidden bg-navy-900 text-[#c6d2e8] px-[52px] py-[46px] flex flex-col max-[900px]:hidden">
			<div class="absolute inset-0 bg-[radial-gradient(640px_360px_at_20%_-10%,rgba(59,130,246,.32),transparent_65%)]"></div>
			<div class="absolute inset-0 [background-image:linear-gradient(rgba(255,255,255,.045)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.045)_1px,transparent_1px)] [background-size:46px_46px] [mask-image:radial-gradient(560px_460px_at_30%_40%,#000,transparent_80%)] [-webkit-mask-image:radial-gradient(560px_460px_at_30%_40%,#000,transparent_80%)]"></div>
			<Link class="relative z-[1] flex items-center gap-[11px]" :href="route('home')">
				<span class="w-[38px] h-[38px] rounded-[11px] bg-gradient-to-br from-blue-400 to-blue-700 grid place-items-center text-white [&_svg]:w-[21px] [&_svg]:h-[21px]" v-html="logo"></span>
				<span><b class="block font-display text-[19px] font-semibold tracking-tight text-white">Internly</b><small class="block text-[10px] tracking-[.16em] text-[#7c89a3] font-semibold -mt-0.5">INTERNSHIP PLATFORM</small></span>
			</Link>
			<div class="relative z-[1] mt-auto">
				<h2 class="font-display text-white text-[34px] leading-[1.12] mb-[18px] max-w-[420px]">{{ headline }}</h2>
				<p class="text-base text-[#9fb0ce] max-w-[380px] leading-[1.6]">{{ copy }}</p>
				<ul v-if="bullets.length" class="list-none mt-[34px] mb-auto flex flex-col gap-4 [&_li]:flex [&_li]:items-center [&_li]:gap-[13px] [&_li]:text-[15px] [&_li]:text-[#dbe5f5] [&_li]:font-medium [&_.c]:w-[30px] [&_.c]:h-[30px] [&_.c]:rounded-[9px] [&_.c]:bg-white/10 [&_.c]:grid [&_.c]:place-items-center [&_.c]:text-white [&_.c]:shrink-0 [&_svg]:w-[15px] [&_svg]:h-[15px]">
					<li v-for="bullet in bullets" :key="bullet"><span class="c" v-html="check"></span> {{ bullet }}</li>
				</ul>
			</div>
			<div class="relative z-[1] flex gap-[34px] pt-[30px] border-t border-white/10 mt-[30px] [&_b]:font-display [&_b]:text-[26px] [&_b]:text-white [&_b]:block [&_span]:text-[13px] [&_span]:text-[#7c89a3]">
				<slot name="stats" />
			</div>
		</aside>

		<!-- RIGHT -->
		<main class="overflow-y-auto flex justify-center px-10 py-[42px]">
			<div class="w-full max-w-[430px] m-auto">
				<slot />
			</div>
		</main>
	</div>
</template>
