<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        <div class="w-64 bg-indigo-700 text-white">

            <div class="p-6 font-bold text-xl">
                Domain Manager
            </div>

            <nav class="space-y-2 px-4">

                <Link href="/dashboard" class="block p-2 hover:bg-indigo-600 rounded">
                    Dashboard
                </Link>

                <Link href="/domains" class="block p-2 hover:bg-indigo-600 rounded">
                    Domains
                </Link>

                <Link href="/hosting" class="block p-2 hover:bg-indigo-600 rounded">
                    Hosting
                </Link>

                <Link href="/servers" class="block p-2 hover:bg-indigo-600 rounded">
                    Servers
                </Link>

                <Link href="/invoices" class="block p-2 hover:bg-indigo-600 rounded">
                    Invoices
                </Link>

                <Link href="/tickets" class="block p-2 hover:bg-indigo-600 rounded">
                    Support
                </Link>

            </nav>
        </div>

        <!-- Content -->
        <div class="flex-1 p-8">

            <slot />

        </div>

    </div>
</template>