<script setup>
import DashboardLayout from '../Layouts/DashboardLayout.vue'
import StatCard from '../Components/StatCard.vue'

const props = defineProps({
  stats: {
    type: Object,
    default: () => ({
      domains: 24,
      servers: 12,
      expiring: 3,
      down: 1
    })
  }
})
</script>

<template>
<DashboardLayout>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <StatCard title="Domains" :value="stats.domains" color="bg-sky-500"/>
    <StatCard title="Servers" :value="stats.servers" color="bg-blue-500"/>
    <StatCard title="Expiring" :value="stats.expiring" color="bg-indigo-500"/>
    <StatCard title="Down" :value="stats.down" color="bg-red-500"/>
  </div>
</DashboardLayout>
</template>