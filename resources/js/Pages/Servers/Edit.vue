<script setup>
import { useForm } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const props = defineProps({
  servers: {
    type: Object,
    required: true
  }
})

const form = useForm({
  name: props.servers.name || '',
  ip_address: props.servers.ip_address || '',
  provider: props.servers.provider || '',
  location: props.servers.location || '',
  status: props.servers.status || 'online'
})

function submit() {
  form.patch(`/servers/${props.servers.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      console.log('Server updated successfully')
    }
  })
}
</script>

<template>
<DashboardLayout>

<div class="p-8">

  <h1 class="text-2xl font-bold text-white mb-6">
    Edit Server
  </h1>

  <form
    @submit.prevent="submit"
    class="max-w-xl p-8 rounded-2xl shadow-2xl
           backdrop-blur-xl
           bg-gradient-to-br from-sky-600/20 via-blue-500/20 to-indigo-600/20
           border border-white/20 space-y-6"
  >

    <!-- Name -->
    <div>
      <label class="text-white/80 text-sm">Server Name</label>
      <input
        type="text"
        v-model="form.name"
        class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400"
      />
    </div>

    <!-- IP -->
    <div>
      <label class="text-white/80 text-sm">IP Address</label>
      <input
        type="text"
        v-model="form.ip_address"
        class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400"
      />
    </div>

    <!-- Provider -->
    <div>
      <label class="text-white/80 text-sm">Provider</label>
      <input
        type="text"
        v-model="form.provider"
        class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400"
      />
    </div>

    <!-- Location -->
    <div>
      <label class="text-white/80 text-sm">Location</label>
      <input
        type="text"
        v-model="form.location"
        class="w-full mt-2 p-3 rounded-lg
               bg-white/20 border border-white/30
               text-white placeholder-white/60
               focus:outline-none focus:ring-2 focus:ring-sky-400"
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
      >
        <option value="online" class="text-black">Online</option>
        <option value="offline" class="text-black">Offline</option>
      </select>
    </div>

    <!-- Button -->
    <button
      type="submit"
      class="w-full py-3 rounded-lg
             bg-gradient-to-r from-sky-500 to-blue-600
             hover:from-sky-600 hover:to-blue-700
             text-white font-semibold shadow-lg transition"
    >
      Update Server
    </button>

  </form>

</div>

</DashboardLayout>
</template>