<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'

// Navbar scroll state
const scrolled = ref(false)
onMounted(() => {
    window.addEventListener('scroll', () => {
        scrolled.value = window.scrollY > 20
    })
})

// Documentation sections
const docsSections = [
    { title: "Getting Started", description: "Learn how to set up your hosting account, add domains, and configure DNS records." },
    { title: "Managing Domains", description: "Steps to add, edit, and remove domains, including registrar info and expiry tracking." },
    { title: "SSL Certificates", description: "Monitor SSL status, expiration dates, and renew certificates." },
    { title: "Server Management", description: "Track servers, uptime, and hosting account configurations." },
    { title: "Activity Logs", description: "View the history of actions and changes made in your account." },
    { title: "Monitoring", description: "Set up uptime monitoring and alerts for your domains and servers." }
]
</script>

<template>
    <div
        class="relative min-h-screen bg-gradient-to-br from-sky-500 via-blue-600 to-indigo-800 text-white overflow-hidden">

        <!-- Background Glow -->
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-purple-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-blue-400/30 rounded-full blur-3xl"></div>

        <!-- Navbar Glass -->
        <!-- Navbar Glass -->

        <div :class="{ 'bg-white/10 backdrop-blur-xl shadow-lg': scrolled }" class="sticky top-0 z-50 transition-all">

            <div class="max-w-7xl mx-auto flex justify-between items-center py-3 px-6">

                <!-- Logo -->
                <div class="text-2xl font-bold tracking-wide">
                    Hosting Manager
                </div>

                <!-- Navbar Links -->
                <div class="flex items-center gap-3">

                    <Link href="/"
                        class="px-4 py-2 rounded-lg bg-white/20 backdrop-blur-md border border-white/30 hover:bg-white/30 transition">
                        Welcome
                    </Link>

                    <Link href="/doc"
                        class="px-4 py-2 rounded-lg bg-white/20 backdrop-blur-md border border-white/30 hover:bg-white/30 transition">
                        Docs
                    </Link>

                    <Link href="/login"
                        class="px-4 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-600 transition font-semibold">
                        Login
                    </Link>

                </div>

            </div>

        </div>


        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-6 py-24 relative z-10">
            <h1 class="text-5xl font-bold leading-tight mb-8 text-center">Documentation</h1>
            <p class="text-white/80 text-lg mb-12 text-center">
                Learn how to manage your hosting, domains, SSL, servers, and monitoring using our centralized dashboard.
            </p>

            <!-- Docs Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="section in docsSections" :key="section.title"
                    class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-6 shadow-lg hover:scale-105 hover:shadow-2xl transition transform flex flex-col gap-3">

                    <div class="text-3xl">📄</div>
                    <h2 class="text-xl font-semibold">{{ section.title }}</h2>
                    <p class="text-white/70 text-sm">{{ section.description }}</p>
                    <a href="#"
                        class="text-sky-300 hover:text-sky-400 font-semibold transition flex items-center gap-1">
                        Read More ➡️
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center pb-10 text-white/60 relative z-10">
            © 2026 Hosting Manager
        </div>

    </div>
</template>
