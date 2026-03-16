<script setup>
import Sidebar from '../Components/Sidebar.vue'
import Navbar from '../Components/Navbar.vue'
</script>

<template>
<div class="flex min-h-screen bg-gradient-to-br from-sky-600 via-blue-700 to-indigo-800">
  <Sidebar />
  <div class="flex-1">
    <Navbar />
    <div class="p-8">
      <slot />
    </div>
  </div>
</div>
</template>