<script setup>
defineProps({
  title: String,
  value: Number,
  color: String
})
</script>

<template>
<div class="relative backdrop-blur-lg bg-white/10 border border-white/20
rounded-2xl p-6 shadow-xl transition transform hover:scale-105 hover:-rotate-1 hover:shadow-2xl flex flex-col">

  <div class="flex justify-between items-center">
    <h3 class="text-sm uppercase text-white/70">{{ title }}</h3>
    <div :class="`w-10 h-10 rounded-lg flex items-center justify-center ${color} text-xl`">
      <span v-if="title==='Domains'">🌐</span>
      <span v-else-if="title==='Servers'">🖥️</span>
      <span v-else-if="title==='Expiring'">⏳</span>
      <span v-else-if="title==='Down'">⚠️</span>
    </div>
  </div>

  <p class="text-3xl font-bold text-white mt-4">{{ value }}</p>
</div>
</template>