<script setup>
import { Link, router } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const props = defineProps({
    servers: {
        type: Array,
        required: true
    }
})

// حذف سيرفر
function remove(id) {
    if (confirm('Are you sure you want to delete this record?')) {
        router.delete(`/servers/${id}`, {
            preserveScroll: true,
            onSuccess: () => {
                alert('Server record deleted successfully.')
            },
            onError: (errors) => {
                console.error(errors)
                alert('Failed to delete the server record.')
            }
        })
    }
}
</script>

<template>
    <DashboardLayout>

        <div class="p-6 rounded-2xl shadow-2xl backdrop-blur-xl
            bg-gradient-to-br from-sky-600/20 via-blue-500/20 to-indigo-600/20">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">
                    Servers
                </h1>

                <Link href="/servers/create" class="bg-gradient-to-r from-sky-500 to-blue-600
             hover:from-sky-600 hover:to-blue-700
             text-white px-4 py-2 rounded-lg shadow-md transition">
                    Add Server
                </Link>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left rounded-xl overflow-hidden">

                    <thead class="bg-white/20 backdrop-blur-md text-white/90">
                        <tr>
                            <th class="p-3">Name</th>
                            <th class="p-3">IP Address</th>
                            <th class="p-3">Provider</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr v-for="server in servers" :key="server.id"
                            class="border-b border-white/10 hover:bg-white/10 transition">

                            <td class="p-3 text-white">
                                {{ server.name }}
                            </td>

                            <td class="p-3 text-white/80">
                                {{ server.ip_address }}
                            </td>

                            <td class="p-3 text-white/80">
                                {{ server.provider }}
                            </td>

                            <td class="p-3">
                                <span :class="server.status === 'online'
                                    ? 'text-green-400 font-semibold'
                                    : 'text-red-400 font-semibold'">
                                    {{ server.status }}
                                </span>
                            </td>

                            <td class="p-3 space-x-2">

                                <Link :href="`/servers/${server.id}/usage`" class="bg-blue-500 hover:bg-blue-600
                     text-white px-3 py-1 rounded-lg transition">
                                    Usage
                                </Link>

                                <Link :href="`/servers/${server.id}/edit`" class="bg-yellow-500 hover:bg-yellow-600
                     text-white px-3 py-1 rounded-lg transition">
                                    Edit
                                </Link>

                                <button @click="remove(server.id)" class="bg-red-600 hover:bg-red-700
                     text-white px-3 py-1 rounded-lg transition">
                                    Delete
                                </button>

                            </td>

                        </tr>

                        <tr v-if="servers.length === 0">
                            <td colspan="5" class="p-4 text-center text-white/60">
                                No Server records found
                            </td>
                        </tr>

                    </tbody>

                </table>
            </div>

        </div>

    </DashboardLayout>
</template>