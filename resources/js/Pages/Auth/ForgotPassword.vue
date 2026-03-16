<script setup>
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const form = useForm({
  email: ''
})

function submit() {
  form.post(route('password.email'), {
    onSuccess: () => alert('We sent you a password reset link! Check your email.'),
    onError: () => console.log(form.errors)
  })
}
</script>

<template>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-sky-700 via-blue-700 to-indigo-800">
  <div class="w-full max-w-md p-8 rounded-2xl bg-white/10 border border-white/20 shadow-2xl">
    <h1 class="text-2xl font-bold text-white mb-6 text-center">Forgot Password</h1>

    <form @submit.prevent="submit" class="space-y-5">

      <div class="relative">
        <label class="text-white/80 text-sm">Email</label>
        <input type="email" v-model="form.email" placeholder="email@example.com"
               class="w-full mt-2 p-3 pl-10 rounded-lg bg-white/20 border border-white/30
                      text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-sky-400" />
        <span class="absolute left-3 top-[38px] text-white/70 text-lg">📧</span>
        <p v-if="form.errors.email" class="text-red-400 text-sm mt-1">{{ form.errors.email }}</p>
      </div>

      <button class="w-full py-3 rounded-lg bg-gradient-to-r from-sky-500 to-blue-600
                     hover:from-sky-600 hover:to-blue-700 text-white font-semibold shadow-lg shadow-sky-500/50 hover:shadow-xl hover:shadow-sky-500/70 transition">
        Send Password Reset Link
      </button>

    </form>
  </div>
</div>
</template>