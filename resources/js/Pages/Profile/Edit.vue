<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const props = defineProps({
  user: { type: Object, default: () => ({ id: null, name: '', email: '' }) },
  auth: { type: Object, default: () => ({ user: { name: 'User', email: '' } }) }
})

const authUser = props.auth.user || { name:'User', email:'' }

const dropdownOpen = ref(false)
function toggleDropdown() { dropdownOpen.value = !dropdownOpen.value }
function logout() { router.post(route('logout')) }

function handleClickOutside(event) {
  const dropdown = document.getElementById('user-dropdown')
  if (dropdown && !dropdown.contains(event.target)) dropdownOpen.value = false
}

onMounted(() => document.addEventListener('click', handleClickOutside))
onBeforeUnmount(() => document.removeEventListener('click', handleClickOutside))

// Form باستخدام useForm من Inertia
const form = useForm({
  name: props.user.name,
  email: props.user.email,
  current_password: '',
  password: '',
  password_confirmation: ''
})

// دالة لتحديث البيانات
function submitForm() {
  form.put(route('profile.update'), {
    preserveScroll: true,
    onSuccess: () => {
      console.log('Profile updated successfully')
    }
  })
}
</script>

<template>
  <DashboardLayout :auth="props.auth">

    <!-- Edit Profile Form -->
    <div class="max-w-2xl mx-auto p-6">
      <h1 class="text-2xl font-bold mb-6">Edit Profile</h1>

      <!-- رسالة النجاح -->
      <div v-if="$page.props.flash?.success" class="mb-4 p-3 bg-green-500/30 text-green-700 rounded">
        {{ $page.props.flash.success }}
      </div>

      <form @submit.prevent="submitForm" class="space-y-4">
        <div>
          <label class="block text-white mb-1">Name</label>
          <input type="text" v-model="form.name" class="w-full p-2 rounded bg-white/10 border border-white/30 text-white"/>
          <p v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</p>
        </div>

        <div>
          <label class="block text-white mb-1">E-Mail</label>
          <input type="email" v-model="form.email" class="w-full p-2 rounded bg-white/10 border border-white/30 text-white"/>
          <p v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</p>
        </div>

        <div>
          <label class="block text-white mb-1">Current Password</label>
          <input type="password" v-model="form.current_password" class="w-full p-2 rounded bg-white/10 border border-white/30 text-white"/>
          <p v-if="form.errors.current_password" class="text-red-500 text-sm">{{ form.errors.current_password }}</p>
        </div>

        <div>
          <label class="block text-white mb-1">New Password</label>
          <input type="password" v-model="form.password" class="w-full p-2 rounded bg-white/10 border border-white/30 text-white"/>
          <p v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</p>
        </div>

        <div>
          <label class="block text-white mb-1">Confirm New Password</label>
          <input type="password" v-model="form.password_confirmation" class="w-full p-2 rounded bg-white/10 border border-white/30 text-white"/>
          <p v-if="form.errors.password_confirmation" class="text-red-500 text-sm">{{ form.errors.password_confirmation }}</p>
        </div>

        <div>
          <button type="submit" class="px-5 py-2 bg-indigo-500 hover:bg-indigo-600 rounded text-white font-semibold">
            Save Changes
          </button>
        </div>
      </form>
    </div>

  </DashboardLayout>
</template>