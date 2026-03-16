<script setup>
import { useForm } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const props = defineProps({
  domains: {
    type: Object,
    required: true
  }
})

const form = useForm({
  domain_name: props.domains.domain_name || '',
  registrar: props.domains.registrar || '',
  expiry_date: props.domains.expiry_date || '',
})

function submit() {
  form.patch(`/domains/${props.domains.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      console.log('Domain updated successfully')
    }
  })
}
</script>

<template>
  <DashboardLayout>

    <div class="p-8">

      <h1 class="text-2xl font-bold text-white mb-6">
        Edit Domain
      </h1>

      <form @submit.prevent="submit" class="max-w-xl p-8 rounded-2xl shadow-2xl backdrop-blur-xl
           bg-gradient-to-br from-sky-500/20 via-blue-500/20 to-indigo-600/20
           border border-white/20 space-y-6">

        <!-- Domain -->
        <div>
          <label class="text-white/80 text-sm">Domain Name</label>
          <input v-model="form.domain_name" type="text" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400" placeholder="example.com" />
        </div>

        <!-- Registrar -->
        <div>
          <label class="text-white/80 text-sm">Registrar</label>
          <input v-model="form.registrar" type="text" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400" placeholder="Namecheap" />
        </div>

        <!-- Expiry -->
        <div>
          <label class="text-white/80 text-sm">Expiry Date</label>
          <input v-model="form.expiry_date" type="date" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white
               focus:outline-none focus:ring-2 focus:ring-sky-400" />
        </div>

        <!-- Button -->
        <div class="pt-4">
          <button type="submit" class="w-full py-3 rounded-lg
               bg-gradient-to-r from-sky-500 to-blue-600
               hover:from-sky-600 hover:to-blue-700
               text-white font-semibold shadow-lg transition">
            Update Domain
          </button>
        </div>

      </form>

    </div>

  </DashboardLayout>
</template>