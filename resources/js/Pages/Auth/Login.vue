```vue
<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    email: '',
    password: '',
    remember: false
})

function submit() {
    form.post('/login')
}
</script>

<template>
<div class="relative min-h-screen flex items-center justify-center
            bg-gradient-to-br from-sky-700 via-blue-700 to-indigo-800 overflow-hidden">

    <!-- Glow background -->
    <div class="absolute w-64 h-64 bg-blue-400/30 rounded-full blur-3xl -top-16 -right-16"></div>
    <div class="absolute w-64 h-64 bg-purple-500/30 rounded-full blur-3xl -bottom-16 -left-16"></div>

    <!-- Login Card -->
    <div class="relative w-full max-w-md p-8 rounded-2xl backdrop-blur-xl
                bg-white/10 border border-white/20 shadow-2xl animate-fadeIn">

        <h1 class="text-2xl font-bold text-white mb-6 text-center">Login</h1>

        <form @submit.prevent="submit" class="space-y-5">

            <!-- Email -->
            <div class="relative">
                <label class="text-white/80 text-sm">Email</label>
                <input type="email" v-model="form.email" placeholder="email@example.com"
                       class="w-full mt-2 p-3 pl-10 rounded-lg bg-white/20 border border-white/30
                              text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-sky-400" />
                <span class="absolute left-3 top-[38px] text-white/70 text-lg">📧</span>
            </div>

            <!-- Password -->
            <div class="relative">
                <label class="text-white/80 text-sm">Password</label>
                <input type="password" v-model="form.password" placeholder="••••••••"
                       class="w-full mt-2 p-3 pl-10 rounded-lg bg-white/20 border border-white/30
                              text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-sky-400" />
                <span class="absolute left-3 top-[38px] text-white/70 text-lg">🔒</span>
            </div>

            <!-- Remember -->
            <div class="flex items-center space-x-2">
                <input type="checkbox" v-model="form.remember" class="rounded" />
                <span class="text-white/80 text-sm">Remember me</span>
            </div>

            <!-- Button -->
            <button class="w-full py-3 rounded-lg
                           bg-gradient-to-r from-sky-500 to-blue-600
                           hover:from-sky-600 hover:to-blue-700
                           text-white font-semibold shadow-lg shadow-sky-500/50 hover:shadow-xl hover:shadow-sky-500/70
                           transition">
                Login
            </button>
<div class="text-center mt-4">
  <a href="/forgot-password" class="text-white/70 hover:text-white text-sm underline">
    Forgot Password?
  </a>
</div>
        </form>

    </div>

</div>
</template>

<style>
/* Fade-in animation */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
  animation: fadeIn 0.8s ease-out;
}
</style>
```
