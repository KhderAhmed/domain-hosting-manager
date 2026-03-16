<script setup>
import { useForm } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const props = defineProps({
  domains: Array
})

const form = useForm({
  domain_id: '',
  issuer: '',
  valid_from: '',
  valid_to: '',
  status: 'valid'
})

function submit() {
  form.post('/ssl')
}
</script>

<template>
<DashboardLayout>

<div class="p-8">

  <h1 class="text-2xl font-bold text-white mb-6">
    Add SSL Certificate
  </h1>

  <form
    @submit.prevent="submit"
    class="max-w-xl p-8 rounded-2xl shadow-2xl
           backdrop-blur-xl
           bg-gradient-to-br from-sky-600/20 via-blue-500/20 to-indigo-600/20
           border border-white/20 space-y-6"
  >

    <!-- Domain -->
    <div>
      <label class="text-white/80 text-sm">Domain</label>
      <select
        v-model="form.domain_id"
        class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white
               focus:outline-none focus:ring-2 focus:ring-sky-400"
        required
      >
        <option value="" class="text-black">Select Domain</option>

        <option
          v-for="domain in domains"
          :key="domain.id"
          :value="domain.id"
          class="text-black"
        >
          {{ domain.domain_name }}
        </option>

      </select>
    </div>

    <!-- Issuer -->
    <div>
      <label class="text-white/80 text-sm">Issuer</label>
      <input
        type="text"
        v-model="form.issuer"
        placeholder="Let's Encrypt"
        class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400"
        required
      />
    </div>

    <!-- Valid From -->
    <div>
      <label class="text-white/80 text-sm">Valid From</label>
      <input
        type="date"
        v-model="form.valid_from"
        class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white
               focus:outline-none focus:ring-2 focus:ring-sky-400"
        required
      />
    </div>

    <!-- Valid To -->
    <div>
      <label class="text-white/80 text-sm">Valid To</label>
      <input
        type="date"
        v-model="form.valid_to"
        class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white
               focus:outline-none focus:ring-2 focus:ring-sky-400"
        required
      />
    </div>

    <!-- Status -->
    <div>
      <label class="text-white/80 text-sm">Status</label>
      <select
        v-model="form.status"
        class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white
               focus:outline-none focus:ring-2 focus:ring-sky-400"
        required
      >
        <option value="valid" class="text-black">Valid</option>
        <option value="expired" class="text-black">Expired</option>
      </select>
    </div>

    <!-- Button -->
    <button
      class="w-full py-3 rounded-lg
             bg-gradient-to-r from-sky-500 to-blue-600
             hover:from-sky-600 hover:to-blue-700
             text-white font-semibold shadow-lg transition"
    >
      Save SSL Certificate
    </button>

  </form>

</div>

</DashboardLayout>
</template>