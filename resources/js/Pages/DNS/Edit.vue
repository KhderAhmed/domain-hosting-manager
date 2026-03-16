<script setup>
import { useForm } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const props = defineProps({
  dns: {
    type: Object,
    required: true
  },
  domains: {
    type: Array,
    required: true
  }
})

const form = useForm({
  domain_id: props.dns.domain_id || '',
  type: props.dns.type || '',
  name: props.dns.name || '',
  value: props.dns.value || '',
  ttl: props.dns.ttl || 3600
})

function submit() {
  form.patch(`/dns/${props.dns.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      console.log('DNS record updated successfully')
    }
  })
}
</script>

<template>
  <DashboardLayout>

    <div class="p-8">

      <h1 class="text-2xl font-bold text-white mb-6">
        Edit DNS Record
      </h1>

      <form @submit.prevent="submit" class="max-w-xl p-8 rounded-2xl shadow-2xl
           backdrop-blur-xl
           bg-gradient-to-br from-sky-600/20 via-blue-500/20 to-indigo-600/20
           border border-white/20 space-y-6">

        <!-- Domain -->
        <div>
          <label class="text-white/80 text-sm">Domain</label>
          <select v-model="form.domain_id" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white
               focus:outline-none focus:ring-2 focus:ring-sky-400" required>
            <option value="" disabled class="text-black">Select Domain</option>
            <option v-for="domain in domains" :key="domain.id" :value="domain.id" class="text-black">
              {{ domain.domain_name }}
            </option>
          </select>
        </div>

        <!-- Type -->
        <div>
          <label class="text-white/80 text-sm">Record Type</label>
          <input type="text" v-model="form.type" placeholder="A / CNAME / MX" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400" required />
        </div>

        <!-- Name -->
        <div>
          <label class="text-white/80 text-sm">Name</label>
          <input type="text" v-model="form.name" placeholder="@ or www" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400" required />
        </div>

        <!-- Value -->
        <div>
          <label class="text-white/80 text-sm">Value</label>
          <input type="text" v-model="form.value" placeholder="IP or target" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400" required />
        </div>

        <!-- TTL -->
        <div>
          <label class="text-white/80 text-sm">TTL</label>
          <input type="number" v-model="form.ttl" class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white
               focus:outline-none focus:ring-2 focus:ring-sky-400" required />
        </div>

        <!-- Button -->
        <button type="submit" class="w-full py-3 rounded-lg
             bg-gradient-to-r from-sky-500 to-blue-600
             hover:from-sky-600 hover:to-blue-700
             text-white font-semibold shadow-lg transition">
          Update DNS Record
        </button>

      </form>

    </div>

  </DashboardLayout>
</template>