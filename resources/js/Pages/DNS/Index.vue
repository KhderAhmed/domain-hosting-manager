<script setup>
import { Link, router } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const props = defineProps({
  records: {
    type: Array,
    required: true
  }
})

function remove(id) {
  if (confirm('Are you sure you want to delete this record?')) {
    router.delete(`/dns/${id}`, {
      preserveScroll: true,
      onSuccess: () => {
        alert('DNS record deleted successfully.')
      },
      onError: (errors) => {
        console.error(errors)
        alert('Failed to delete the DNS record.')
      }
    })
  }
}
</script>

<template>
<DashboardLayout>

<div class="p-8">

  <!-- Title + Button -->
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-white">
      DNS Records
    </h1>

    <Link
      href="/dns/create"
      class="px-4 py-2 rounded-lg
             bg-gradient-to-r from-sky-500 to-blue-600
             hover:from-sky-600 hover:to-blue-700
             text-white shadow-lg transition">
      Add DNS
    </Link>
  </div>

  <!-- Table Container -->
  <div class="rounded-2xl overflow-hidden shadow-2xl
              backdrop-blur-xl
              bg-gradient-to-br from-sky-600/10 via-blue-500/10 to-indigo-600/10
              border border-white/20">

    <table class="w-full text-left">

      <!-- Table Header -->
      <thead class="bg-white/10 text-white/80">
        <tr>
          <th class="p-4">Domain</th>
          <th class="p-4">Type</th>
          <th class="p-4">Name</th>
          <th class="p-4">Value</th>
          <th class="p-4">TTL</th>
          <th class="p-4">Actions</th>
        </tr>
      </thead>

      <!-- Table Body -->
      <tbody>

        <tr
          v-for="record in records"
          :key="record.id"
          class="border-t border-white/10 hover:bg-white/10 transition">

          <td class="p-4 text-white">
            {{ record.domain?.domain_name || '—' }}
          </td>

          <td class="p-4 text-white/80">
            <span class="px-2 py-1 rounded bg-blue-500/20 text-sky-300 text-sm">
              {{ record.type }}
            </span>
          </td>

          <td class="p-4 text-white/80">
            {{ record.name }}
          </td>

          <td class="p-4 text-white/80 break-all">
            {{ record.value }}
          </td>

          <td class="p-4 text-white/80">
            {{ record.ttl }}
          </td>

          <td class="p-4 space-x-2">

            <Link
              :href="`/dns/${record.id}/edit`"
              class="px-3 py-1 rounded-lg
                     bg-yellow-500 hover:bg-yellow-600
                     text-white text-sm transition">
              Edit
            </Link>

            <button
              @click="remove(record.id)"
              class="px-3 py-1 rounded-lg
                     bg-red-600 hover:bg-red-700
                     text-white text-sm transition">
              Delete
            </button>

          </td>
        </tr>

        <!-- Empty -->
        <tr v-if="records.length === 0">
          <td colspan="6" class="p-6 text-center text-white/50">
            No DNS records found
          </td>
        </tr>

      </tbody>

    </table>

  </div>

</div>

</DashboardLayout>
</template>