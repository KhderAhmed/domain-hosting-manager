<script setup>
import { useForm } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const form = useForm({
    domain_name: '',
    registrar: '',
    expiry_date: ''
})

function submit() {
    form.post('/domains')
}
</script>

<template>
    <DashboardLayout>

        <div class="p-8">

            <h1 class="text-2xl font-bold text-white mb-6">
                Add Domain
            </h1>

            <form @submit.prevent="submit" class="max-w-xl p-8 rounded-2xl shadow-2xl
           backdrop-blur-xl
           bg-gradient-to-br from-sky-500/20 via-blue-500/20 to-indigo-600/20
           border border-white/20 space-y-6">

                <!-- Domain -->
                <div>
                    <label class="text-white/80 text-sm">Domain</label>
                    <input v-model="form.domain_name" placeholder="example.com" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400" />
                </div>

                <!-- Registrar -->
                <div>
                    <label class="text-white/80 text-sm">Registrar</label>
                    <input v-model="form.registrar" placeholder="Namecheap / GoDaddy" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400" />
                </div>

                <!-- Expiry -->
                <div>
                    <label class="text-white/80 text-sm">Expiry Date</label>
                    <input type="date" v-model="form.expiry_date" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white
               focus:outline-none focus:ring-2 focus:ring-sky-400" />
                </div>

                <!-- Button -->
                <button class="w-full py-3 rounded-lg
             bg-gradient-to-r from-sky-500 to-blue-600
             hover:from-sky-600 hover:to-blue-700
             text-white font-semibold shadow-lg transition">
                    Save Domain
                </button>

            </form>

        </div>

    </DashboardLayout>
</template>