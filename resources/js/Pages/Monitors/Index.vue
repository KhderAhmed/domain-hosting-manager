<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

defineProps({
    monitors: Array,
    upCount: Number,
    downCount: Number
})
</script>

<template>
    <DashboardLayout>

        <div class="p-8">

            <h1 class="text-2xl font-bold text-white mb-8">
                Domain Monitoring Dashboard
            </h1>

            <!-- Summary Cards -->
            <div class="grid grid-cols-2 gap-6 mb-8">

                <div class="p-6 rounded-2xl shadow-xl
                    bg-gradient-to-br from-green-500/20 to-emerald-600/20
                    backdrop-blur-xl border border-white/20">

                    <p class="text-white/70 text-sm">
                        Up Monitors
                    </p>

                    <h2 class="text-3xl font-bold text-green-400 mt-2">
                        {{ upCount }}
                    </h2>

                </div>


                <div class="p-6 rounded-2xl shadow-xl
                    bg-gradient-to-br from-red-500/20 to-pink-600/20
                    backdrop-blur-xl border border-white/20">

                    <p class="text-white/70 text-sm">
                        Down Monitors
                    </p>

                    <h2 class="text-3xl font-bold text-red-400 mt-2">
                        {{ downCount }}
                    </h2>

                </div>

            </div>


            <!-- Monitors Table -->

            <div class="rounded-2xl shadow-2xl
                backdrop-blur-xl
                bg-gradient-to-br from-sky-600/20 via-blue-500/20 to-indigo-600/20
                border border-white/20 overflow-hidden">

                <table class="w-full text-left text-white">

                    <thead class="bg-white/10 text-white/80">
                        <tr>
                            <th class="p-4">Domain</th>
                            <th class="p-4">Interval</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Last Checked</th>
                            <th class="p-4">Down Count</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr v-for="m in monitors" :key="m.id"
                            class="border-t border-white/10 hover:bg-white/5 transition">

                            <td class="p-4 font-medium">
                                {{ m.domain.domain_name }}
                            </td>

                            <td class="p-4">
                                {{ m.interval }} min
                            </td>

                            <td class="p-4">

                                <span class="px-3 py-1 rounded-full text-sm font-semibold" :class="m.logs[0]?.status == 'up'
                                    ? 'bg-green-500/20 text-green-400'
                                    : 'bg-red-500/20 text-red-400'">
                                    {{ m.logs[0]?.status || '—' }}
                                </span>

                            </td>

                            <td class="p-4 text-white/70">

                                {{ m.logs[0]?.created_at
                                    ? new Date(m.logs[0].created_at).toLocaleString()
                                : '—' }}

                            </td>

                            <td class="p-4">
                                {{m.logs.filter(l => l.status == 'down').length}}
                            </td>

                        </tr>

                        <tr v-if="monitors.length === 0">

                            <td colspan="5" class="p-6 text-center text-white/60">

                                No monitors found.

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </DashboardLayout>
</template>