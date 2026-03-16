<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { router, usePage, Link } from '@inertiajs/vue3'
import userIcon from '@/Assets/icon/cat.jpg'

const dropdownOpen = ref(false)
const page = usePage()
const user = page.props.auth.user || { name: 'User', email: '' }

function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value
}

function logout() {
  router.post('/logout')
}

// إغلاق Dropdown عند الضغط خارجها
function handleClickOutside(event) {
  const dropdown = document.getElementById('user-dropdown')
  if (dropdown && !dropdown.contains(event.target)) {
    dropdownOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<template>
  <!-- Navbar -->
  <div
    class="sticky top-0 z-50 backdrop-blur-xl bg-white/10 border-b border-white/20 px-6 py-4 flex justify-between items-center">

    <!-- Logo -->
    <h1 class="text-xl font-bold text-white">Dashboard</h1>

    <!-- User Dropdown -->
    <div class="relative" id="user-dropdown">

      <!-- Dropdown Button -->
      <button @click="toggleDropdown"
        class="flex items-center gap-3 bg-white/10 hover:bg-white/20 px-3 py-2 rounded-lg transition">

        <!-- Avatar -->
        <img :src="userIcon" class="w-9 h-9 rounded-full border border-white/30 object-cover" />

        <!-- Name -->
        <span class="text-white font-medium">{{ user.name }}</span>

        <!-- Arrow -->
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
      </button>

      <!-- Dropdown Menu -->
      <div v-if="dropdownOpen"
        class="absolute right-0 mt-2 w-56 bg-white/10 backdrop-blur-xl border border-white/20 rounded-lg shadow-xl z-50 overflow-hidden">

        <!-- User Info -->
        <div class="px-4 py-3 border-b border-white/20">
          <p class="text-white font-semibold">{{ user.name }}</p>
          <p class="text-white/70 text-sm truncate">{{ user.email }}</p>
        </div>

        <!-- Menu Items -->
        <div class="flex flex-col divide-y divide-white/10">

          <!-- Profile Link -->
          <Link href="/profile" class="w-full text-left px-4 py-2 text-white hover:bg-white/20 transition">
            Profile
          </Link>


          <!-- Logout -->
          <button @click="logout" class="w-full text-left px-4 py-2 text-white hover:bg-red-500/50 transition">
            Logout
          </button>

        </div>

      </div>

    </div>

  </div>
</template>