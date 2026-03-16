<script setup>
import { useForm } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const form = useForm({
    name: '',
    ip_address: '',
    provider: '',
    location: ''
})

function submit() {
    form.post('/servers')
}
</script>

<template>
    <DashboardLayout>

        <div class="p-8">

            <h1 class="text-2xl font-bold text-white mb-6">
                Add Server
            </h1>

            <form @submit.prevent="submit" class="max-w-xl p-8 rounded-2xl shadow-2xl
           backdrop-blur-xl
           bg-gradient-to-br from-sky-600/20 via-blue-500/20 to-indigo-600/20
           border border-white/20 space-y-6">

                <!-- Server Name -->
                <div>
                    <label class="text-white/80 text-sm">Server Name</label>
                    <input v-model="form.name" placeholder="My Server" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400" />
                </div>

                <!-- IP Address -->
                <div>
                    <label class="text-white/80 text-sm">IP Address</label>
                    <input v-model="form.ip_address" placeholder="192.168.1.1" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400" />
                </div>

                <!-- Provider -->
                <div>
                    <label class="text-white/80 text-sm">Provider</label>
                    <input v-model="form.provider" placeholder="AWS / DigitalOcean" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400" />
                </div>

                <!-- Location -->
                <div>
                    <label class="text-white/80 text-sm">Location</label>
                    <input v-model="form.location" placeholder="Germany / USA" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400" />
                </div>

                <!-- Save Button -->
                <button class="w-full py-3 rounded-lg
             bg-gradient-to-r from-sky-500 to-blue-600
             hover:from-sky-600 hover:to-blue-700
             text-white font-semibold shadow-lg transition">
                    Save Server
                </button>

            </form>

        </div>

    </DashboardLayout>
</template>