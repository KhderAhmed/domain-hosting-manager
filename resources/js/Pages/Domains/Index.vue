<script setup>
import { Link, router } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const props = defineProps({
  domains: {
    type: Array,
    required: true
  }
})

// دالة حذف دومين
function remove(id) {
  if (confirm('Are you sure you want to delete this record?')) {
    router.delete(`/domains/${id}`, {
      preserveScroll: true,
      onSuccess: () => alert('Domain record deleted successfully.'),
      onError: (errors) => { console.error(errors); alert('Failed to delete the record.') }
    })
  }
}
</script>

<template>
<DashboardLayout>
  <div class="p-6 backdrop-blur-xl bg-gradient-to-tr from-sky-600/20 via-blue-500/20 to-indigo-600/20 rounded-2xl shadow-2xl">

    <!-- العنوان وزر الإضافة -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-white drop-shadow-md">Domains</h1>
      <Link href="/domains/create" 
            class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300">
        Add Domain
      </Link>
    </div>

    <!-- الجدول -->
    <div class="overflow-x-auto">
      <table class="w-full text-left rounded-xl overflow-hidden shadow-inner">
        <thead class="bg-white/20 backdrop-blur-md text-white/80">
          <tr>
            <th class="p-3 font-medium">Domain</th>
            <th class="p-3 font-medium">Registrar</th>
            <th class="p-3 font-medium">Expiry</th>
            <th class="p-3 font-medium">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="domain in domains" :key="domain.id" 
              class="hover:bg-white/10 transition-all duration-200 cursor-pointer">
            <td class="p-3 text-white">{{ domain.domain_name }}</td>
            <td class="p-3 text-white/80">{{ domain.registrar }}</td>
            <td class="p-3 text-white/80">{{ domain.expiry_date }}</td>
            <td class="p-3 space-x-2">
              <Link :href="`/domains/${domain.id}/edit`" 
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg shadow-md transition duration-300">
                Edit
              </Link>
              <button @click="remove(domain.id)" 
                      class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg shadow-md transition duration-300">
                Delete
              </button>
            </td>
          </tr>

          <tr v-if="domains.length === 0">
            <td colspan="4" class="p-3 text-center text-white/50 italic">
              No domain records found.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</DashboardLayout>
</template>
