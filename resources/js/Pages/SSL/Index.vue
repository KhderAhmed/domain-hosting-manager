<script setup>
import { Link, router } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const props = defineProps({
  certs: Array
})

function remove(id) {
  if (confirm('Are you sure you want to delete this SSL certificate?')) {
    router.delete(`/ssl/${id}`, {
      preserveScroll: true,
      onSuccess: () => alert('SSL certificate deleted successfully.'),
      onError: () => alert('Failed to delete SSL certificate.')
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
          SSL Certificates
        </h1>

        <Link href="/ssl/create" class="px-4 py-2 rounded-lg
             bg-gradient-to-r from-sky-500 to-blue-600
             hover:from-sky-600 hover:to-blue-700
             text-white shadow-lg transition">
          Add SSL
        </Link>
      </div>

      <!-- Table -->
      <div class="rounded-2xl overflow-hidden shadow-2xl
              backdrop-blur-xl
              bg-gradient-to-br from-sky-600/10 via-blue-500/10 to-indigo-600/10
              border border-white/20">

        <table class="w-full text-left">

          <thead class="bg-white/10 text-white/80">
            <tr>
              <th class="p-4">Domain</th>
              <th class="p-4">Issuer</th>
              <th class="p-4">Expires</th>
              <th class="p-4">Days Left</th>
              <th class="p-4">Status</th>
              <th class="p-4">Actions</th>
            </tr>
          </thead>

          <tbody>

            <tr v-for="ssl in certs" :key="ssl.id" class="border-t border-white/10 hover:bg-white/10 transition">

              <td class="p-4 text-white">
                {{ ssl.domain?.domain_name }}
              </td>

              <td class="p-4 text-white/80">
                {{ ssl.issuer }}
              </td>

              <td class="p-4 text-white/80">
                {{ ssl.valid_to }}
              </td>

              <td class="p-4 text-white/80">
                {{ ssl.days_left }} days
              </td>

              <td class="p-4">

                <span v-if="ssl.status === 'valid'" class="px-2 py-1 rounded text-sm bg-green-500/20 text-green-300">
                  Valid
                </span>

                <span v-else-if="ssl.status === 'expired'"
                  class="px-2 py-1 rounded text-sm bg-yellow-500/20 text-yellow-300">
                  Expired
                </span>

                <span v-else class="px-2 py-1 rounded text-sm bg-red-500/20 text-red-300">
                  Invalid
                </span>

              </td>

              <td class="p-4 space-x-2">

                <Link :href="`/ssl/${ssl.id}/edit`" class="px-3 py-1 rounded-lg
                     bg-yellow-500 hover:bg-yellow-600
                     text-white text-sm transition">
                  Edit
                </Link>

                <button @click="remove(ssl.id)" class="px-3 py-1 rounded-lg
                     bg-red-600 hover:bg-red-700
                     text-white text-sm transition">
                  Delete
                </button>

              </td>

            </tr>

            <tr v-if="certs.length === 0">
              <td colspan="6" class="p-6 text-center text-white/50">
                No SSL certificates found
              </td>
            </tr>

          </tbody>

        </table>

      </div>

    </div>

  </DashboardLayout>
</template>