<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

defineProps({
    logs: Array
})
</script>

<template>
    <DashboardLayout>

        <div class="p-8">

            <h1 class="text-2xl font-bold text-white mb-8">
                Activity Logs
            </h1>

            <div class="rounded-2xl shadow-2xl
                backdrop-blur-xl
                bg-gradient-to-br from-sky-600/20 via-blue-500/20 to-indigo-600/20
                border border-white/20 overflow-hidden">

                <table class="w-full text-left text-white">

                    <thead class="bg-white/10 text-white/80">
                        <tr>
                            <th class="p-4">User</th>
                            <th class="p-4">Action</th>
                            <th class="p-4">Subject Type</th>
                            <th class="p-4">Subject ID</th>
                            <th class="p-4">Date</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr v-for="log in logs" :key="log.id"
                            class="border-t border-white/10 hover:bg-white/5 transition">

                            <td class="p-4 font-medium">
                                {{ log.user?.name || 'System' }}
                            </td>

                            <td class="p-4 capitalize">

                                <span class="px-3 py-1 rounded-full text-sm font-semibold" :class="log.action === 'create'
                                        ? 'bg-green-500/20 text-green-400'
                                        : log.action === 'update'
                                            ? 'bg-yellow-500/20 text-yellow-400'
                                            : log.action === 'delete'
                                                ? 'bg-red-500/20 text-red-400'
                                                : 'bg-blue-500/20 text-blue-400'
                                    ">
                                    {{ log.action }}
                                </span>

                            </td>

                            <td class="p-4 text-white/80">
                                {{ log.subject_type }}
                            </td>

                            <td class="p-4">
                                {{ log.subject_id }}
                            </td>

                            <td class="p-4 text-white/70">
                                {{ new Date(log.created_at).toLocaleString() }}
                            </td>

                        </tr>

                        <tr v-if="logs.length === 0">

                            <td colspan="5" class="p-6 text-center text-white/60">
                                No activity logs found.
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </DashboardLayout>
</template>