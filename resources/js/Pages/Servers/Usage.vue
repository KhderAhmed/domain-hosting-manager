<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

defineProps({
    server: Object,
    accounts: Array,
    totalDisk: Number,
    totalBandwidth: Number
})
</script>

<template>
<DashboardLayout>

<div class="p-8">

    <!-- Title -->
    <h1 class="text-2xl font-bold text-white mb-8">
        Server Usage : {{ server.name }}
    </h1>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">

        <!-- Disk -->
        <div class="p-6 rounded-2xl shadow-xl
                    backdrop-blur-xl
                    bg-gradient-to-br from-sky-600/20 via-blue-500/20 to-indigo-600/20
                    border border-white/20">

            <h2 class="text-white/70 text-sm mb-2">
                Total Disk
            </h2>

            <p class="text-3xl font-bold text-white">
                {{ totalDisk }} MB
            </p>

        </div>

        <!-- Bandwidth -->
        <div class="p-6 rounded-2xl shadow-xl
                    backdrop-blur-xl
                    bg-gradient-to-br from-blue-600/20 via-sky-500/20 to-indigo-600/20
                    border border-white/20">

            <h2 class="text-white/70 text-sm mb-2">
                Total Bandwidth
            </h2>

            <p class="text-3xl font-bold text-white">
                {{ totalBandwidth }} MB
            </p>

        </div>

        <!-- Accounts -->
        <div class="p-6 rounded-2xl shadow-xl
                    backdrop-blur-xl
                    bg-gradient-to-br from-indigo-600/20 via-blue-500/20 to-sky-600/20
                    border border-white/20">

            <h2 class="text-white/70 text-sm mb-2">
                Accounts
            </h2>

            <p class="text-3xl font-bold text-white">
                {{ accounts.length }}
            </p>

        </div>

    </div>


    <!-- Accounts Table -->
    <div class="rounded-2xl overflow-hidden shadow-2xl
                backdrop-blur-xl
                bg-gradient-to-br from-sky-600/10 via-blue-500/10 to-indigo-600/10
                border border-white/20">

        <table class="w-full text-left">

            <thead class="bg-white/10 text-white/80">
                <tr>
                    <th class="p-4">Domain</th>
                    <th class="p-4">Disk Usage</th>
                    <th class="p-4">Bandwidth</th>
                </tr>
            </thead>

            <tbody>

                <tr v-for="acc in accounts"
                    :key="acc.id"
                    class="border-t border-white/10 hover:bg-white/10 transition">

                    <td class="p-4 text-white">
                        {{ acc.domain?.domain_name }}
                    </td>

                    <td class="p-4 text-white/80">
                        {{ acc.disk_usage }} MB
                    </td>

                    <td class="p-4 text-white/80">
                        {{ acc.bandwidth_usage }} MB
                    </td>

                </tr>

                <tr v-if="accounts.length === 0">
                    <td colspan="3" class="p-6 text-center text-white/50">
                        No accounts found
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

</DashboardLayout>
</template>