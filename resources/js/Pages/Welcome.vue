```vue
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
</script>

<template>
    <div
        class="relative min-h-screen bg-gradient-to-br from-sky-500 via-blue-600 to-indigo-800 text-white overflow-hidden">

        <!-- Background Glow -->
        <div class="absolute top-0 left-0 w-[400px] h-[400px] bg-purple-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-blue-400/30 rounded-full blur-3xl"></div>

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
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-6 items-center px-6 py-16 relative z-10">
            <div class="space-y-4">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">Manage Your Hosting Infrastructure From One
                    Dashboard</h1>
                <p class="text-white/80 text-base md:text-lg">A centralized platform to manage domains, hosting
                    accounts, DNS records, SSL certificates, servers and uptime monitoring.</p>
                <div class="flex gap-3">
                    <Link href="/login"
                        class="px-5 py-2 rounded-lg bg-white/20 backdrop-blur-md border border-white/30 hover:bg-white/30 transition">
                        Go To Dashboard
                    </Link>
                </div>
            </div>

            <!-- Glass Dashboard Cards with Icons -->
            <div class="grid grid-cols-2 gap-3">
                <div
                    class="bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-2xl hover:scale-105 hover:rotate-1 transition-transform duration-300 flex flex-col items-start gap-1">
                    <div class="text-2xl">🌐</div>
                    <p class="text-xs text-white/70">Domains</p>
                    <p class="text-2xl font-bold">24</p>
                </div>
                <div
                    class="bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-2xl hover:scale-105 hover:-rotate-1 transition-transform duration-300 flex flex-col items-start gap-1">
                    <div class="text-2xl">💾</div>
                    <p class="text-xs text-white/70">Hosting</p>
                    <p class="text-2xl font-bold">18</p>
                </div>
                <div
                    class="bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-2xl hover:scale-105 hover:rotate-1 transition-transform duration-300 flex flex-col items-start gap-1">
                    <div class="text-2xl">🔒</div>
                    <p class="text-xs text-white/70">SSL Certificates</p>
                    <p class="text-2xl font-bold">20</p>
                </div>
                <div
                    class="bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-2xl hover:scale-105 hover:-rotate-1 transition-transform duration-300 flex flex-col items-start gap-1">
                    <div class="text-2xl">⚠️</div>
                    <p class="text-xs text-white/70">Down Monitors</p>
                    <p class="text-2xl font-bold">2</p>
                </div>
            </div>
        </div>

        <!-- Features Section with Icons -->
        <div class="max-w-7xl mx-auto px-6 pb-16 relative z-10">
            <h2 class="text-3xl font-bold text-center mb-8">System Features</h2>
            <div class="grid md:grid-cols-3 gap-4">
                <div
                    class="bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-xl hover:bg-white/20 transition flex flex-col gap-1">
                    <div class="text-2xl">🌐</div>
                    <h3 class="text-lg font-semibold">Domain Management</h3>
                    <p class="text-white/70 text-sm">Track domains, registrars and expiration dates.</p>
                </div>
                <div
                    class="bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-xl hover:bg-white/20 transition flex flex-col gap-1">
                    <div class="text-2xl">🧭</div>
                    <h3 class="text-lg font-semibold">DNS Records</h3>
                    <p class="text-white/70 text-sm">Edit and manage DNS records for your domains.</p>
                </div>
                <div
                    class="bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-xl hover:bg-white/20 transition flex flex-col gap-1">
                    <div class="text-2xl">🔒</div>
                    <h3 class="text-lg font-semibold">SSL Monitoring</h3>
                    <p class="text-white/70 text-sm">Track SSL expiration and status.</p>
                </div>
                <div
                    class="bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-xl hover:bg-white/20 transition flex flex-col gap-1">
                    <div class="text-2xl">💻</div>
                    <h3 class="text-lg font-semibold">Hosting Accounts</h3>
                    <p class="text-white/70 text-sm">Manage hosting accounts and usage.</p>
                </div>
                <div
                    class="bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-xl hover:bg-white/20 transition flex flex-col gap-1">
                    <div class="text-2xl">🖥️</div>
                    <h3 class="text-lg font-semibold">Server Tracking</h3>
                    <p class="text-white/70 text-sm">Manage servers and infrastructure.</p>
                </div>
                <div
                    class="bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-xl hover:bg-white/20 transition flex flex-col gap-1">
                    <div class="text-2xl">📡</div>
                    <h3 class="text-lg font-semibold">Uptime Monitoring</h3>
                    <p class="text-white/70 text-sm">Monitor website uptime and downtime events.</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center pb-6 text-white/60 relative z-10">
            © 2026 Hosting Manager
        </div>
    </div>
</template>
