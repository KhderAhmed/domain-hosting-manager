<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div class="w-64 min-h-screen backdrop-blur-xl bg-white/10 border-r border-white/20 text-white p-6">
        <h2 class="text-2xl font-bold mb-10 text-sky-300">Domain Manager</h2>

        <nav class="space-y-3">
            <Link href="/dashboard" class="block hover:bg-white/10 p-2 rounded-lg transition flex items-center gap-2">
                🏠 Dashboard
            </Link>
            <Link href="/domains" class="block hover:bg-white/10 p-2 rounded-lg transition flex items-center gap-2">
                🌐 Domains
            </Link>
            <Link href="/servers" class="block hover:bg-white/10 p-2 rounded-lg transition flex items-center gap-2">
                🖥️ Servers
            </Link>
            <Link href="/ssl" class="block hover:bg-white/10 p-2 rounded-lg transition flex items-center gap-2">
                🔒 SSL
            </Link>
            <Link href="/dns" class="block hover:bg-white/10 p-2 rounded-lg transition flex items-center gap-2">
                🧭 DNS
            </Link>
            <Link href="/hosting" class="block hover:bg-white/10 p-2 rounded-lg transition flex items-center gap-2">
                💻 Hosting
            </Link>
            <Link href="/activity-logs"
                class="block hover:bg-white/10 p-2 rounded-lg transition flex items-center gap-2">
                📜 Activity Logs
            </Link>
            <Link href="/monitor" class="block hover:bg-white/10 p-2 rounded-lg transition flex items-center gap-2">
                📡 Monitor
            </Link>
        </nav>
    </div>
</template>