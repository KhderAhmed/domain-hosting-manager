<script setup>
import { Link, router } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

defineProps({
    accounts: Array
})

function remove(id) {
    if (confirm('Delete hosting account?')) {
        router.delete(`/hosting/${id}`)
    }
}
</script>

<template>
    <DashboardLayout>

        <div class="p-8">

            <div class="flex justify-between items-center mb-8">

                <h1 class="text-2xl font-bold text-white">
                    Hosting Accounts
                </h1>

                <Link href="/hosting/create" class="px-4 py-2 rounded-lg
                   bg-gradient-to-r from-sky-500 to-blue-600
                   hover:from-sky-600 hover:to-blue-700
                   text-white font-semibold shadow transition">
                    Add Hosting
                </Link>

            </div>

            <!-- Table -->

            <div class="rounded-2xl shadow-2xl
                backdrop-blur-xl
                bg-gradient-to-br from-sky-600/20 via-blue-500/20 to-indigo-600/20
                border border-white/20 overflow-hidden">

                <table class="w-full text-left text-white">

                    <thead class="bg-white/10 text-white/80">

                        <tr>

                            <th class="p-4">Domain</th>
                            <th class="p-4">Server</th>
                            <th class="p-4">Panel</th>
                            <th class="p-4">Disk</th>
                            <th class="p-4">Bandwidth</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr v-for="acc in accounts" :key="acc.id"
                            class="border-t border-white/10 hover:bg-white/5 transition">

                            <td class="p-4 font-medium">
                                {{ acc.domain.domain_name }}
                            </td>

                            <td class="p-4">
                                {{ acc.server.name }}
                            </td>

                            <td class="p-4">
                                {{ acc.panel }}
                            </td>

                            <td class="p-4">
                                {{ acc.disk_usage }} MB
                            </td>

                            <td class="p-4">
                                {{ acc.bandwidth_usage }} MB
                            </td>

                            <td class="p-4">

                                <span class="px-3 py-1 rounded-full text-sm font-semibold" :class="acc.status == 'active'
                                    ? 'bg-green-500/20 text-green-400'
                                    : 'bg-red-500/20 text-red-400'">

                                    {{ acc.status }}

                                </span>

                            </td>

                            <td class="p-4 space-x-2">

                                <Link :href="`/hosting/${acc.id}/edit`" class="px-3 py-1 rounded
                                   bg-yellow-500 hover:bg-yellow-600
                                   text-white text-sm">
                                    Edit
                                </Link>

                                <button @click="remove(acc.id)" class="px-3 py-1 rounded
                                   bg-red-600 hover:bg-red-700
                                   text-white text-sm">
                                    Delete
                                </button>

                            </td>

                        </tr>

                        <tr v-if="accounts.length === 0">

                            <td colspan="7" class="p-6 text-center text-white/60">

                                No hosting accounts found.

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </DashboardLayout>
</template>