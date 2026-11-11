<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/vue3'

// Navbar scroll state
const scrolled = ref(false)

const handleScroll = () => {
    scrolled.value = window.scrollY > 20
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
})

// إلغاء الاستماع للحدث عند مغادرة الصفحة لتجنب مشاكل الأداء
onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
})

// مصفوفة كروت الإحصائيات (لتنظيف الـ HTML)
const stats = [
    { icon: '🌐', label: 'Domains', count: 24, rotate: 'hover:rotate-1' },
    { icon: '💾', label: 'Hosting', count: 18, rotate: 'hover:-rotate-1' },
    { icon: '🔒', label: 'SSL Certificates', count: 20, rotate: 'hover:rotate-1' },
    { icon: '⚠️', label: 'Down Monitors', count: 2, rotate: 'hover:-rotate-1' },
]

// مصفوفة الميزات
const features = [
    { icon: '🌐', title: 'Domain Management', desc: 'Track domains, registrars and expiration dates.' },
    { icon: '🧭', title: 'DNS Records', desc: 'Edit and manage DNS records for your domains.' },
    { icon: '🔒', title: 'SSL Monitoring', desc: 'Track SSL expiration and status.' },
    { icon: '💻', title: 'Hosting Accounts', desc: 'Manage hosting accounts and usage.' },
    { icon: '🖥️', title: 'Server Tracking', desc: 'Manage servers and infrastructure.' },
    { icon: '📡', title: 'Uptime Monitoring', desc: 'Monitor website uptime and downtime events.' },
]
</script>

<template>
    <div class="relative min-h-screen bg-gradient-to-br from-sky-500 via-blue-600 to-indigo-800 text-white overflow-hidden selection:bg-white selection:text-blue-600">

        <!-- Background Glow -->
        <div class="absolute top-0 left-0 w-[400px] h-[400px] bg-purple-500/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-blue-400/30 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Navbar Glass -->
        <div :class="{ 'bg-white/10 backdrop-blur-xl shadow-lg border-b border-white/10': scrolled }" class="sticky top-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto flex justify-between items-center py-4 px-6">
                <!-- Logo -->
                <div class="text-2xl font-bold tracking-wide flex items-center gap-2">
                    <span class="text-3xl">🚀</span> Hosting Manager
                </div>

                <!-- Navbar Links -->
                <div class="flex items-center gap-3">
                    <Link href="/" class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 transition">
                        Welcome
                    </Link>
                    <Link href="/doc" class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 transition">
                        Docs
                    </Link>
                    <Link href="/login" class="px-4 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-600 transition font-semibold shadow-md">
                        Login
                    </Link>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center px-6 py-20 relative z-10">
            <div class="space-y-6">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight tracking-tight">
                    Manage Your Infrastructure <span class="bg-gradient-to-r from-cyan-200 to-white bg-clip-text text-transparent">From One Place</span>
                </h1>
                <p class="text-white/80 text-base md:text-lg leading-relaxed">
                    A centralized platform to manage domains, hosting accounts, DNS records, SSL certificates, servers, and uptime monitoring seamlessly.
                </p>
                <div class="flex gap-4">
                    <Link href="/login" class="px-6 py-3 rounded-xl bg-white/20 backdrop-blur-md border border-white/30 hover:bg-white/30 transition font-medium">
                        Go To Dashboard →
                    </Link>
                </div>
            </div>

            <!-- Glass Dashboard Cards with v-for -->
            <div class="grid grid-cols-2 gap-4">
                <div 
                    v-for="(stat, index) in stats" 
                    :key="index"
                    :class="stat.rotate"
                    class="bg-white/10 backdrop-blur-xl border border-white/20 p-5 rounded-2xl hover:scale-105 transition-all duration-300 flex flex-col items-start gap-2 shadow-lg"
                >
                    <div class="text-3xl">{{ stat.icon }}</div>
                    <p class="text-xs text-white/70 font-medium uppercase tracking-wider">{{ stat.label }}</p>
                    <p class="text-3xl font-extrabold">{{ stat.count }}</p>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="max-w-7xl mx-auto px-6 pb-20 relative z-10">
            <h2 class="text-3xl font-bold text-center mb-12">System Features</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div 
                    v-for="(feature, index) in features" 
                    :key="index"
                    class="bg-white/10 backdrop-blur-xl border border-white/20 p-6 rounded-2xl hover:bg-white/20 transition-all duration-300 flex flex-col gap-2 shadow-sm hover:shadow-md"
                >
                    <div class="text-3xl mb-2">{{ feature.icon }}</div>
                    <h3 class="text-xl font-semibold">{{ feature.title }}</h3>
                    <p class="text-white/70 text-sm leading-relaxed">{{ feature.desc }}</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center pb-8 text-white/60 relative z-10 text-sm">
            © 2026 Hosting Manager. All rights reserved.
        </div>
    </div>
</template>