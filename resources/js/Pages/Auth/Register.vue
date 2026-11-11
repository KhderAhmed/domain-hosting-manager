<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

function submit() {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
<div class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-sky-700 via-blue-700 to-indigo-800 overflow-hidden px-4 py-8">

    <!-- Glow background -->
    <div class="absolute w-72 h-72 bg-blue-400/30 rounded-full blur-3xl -top-16 -right-16 pointer-events-none"></div>
    <div class="absolute w-72 h-72 bg-purple-500/30 rounded-full blur-3xl -bottom-16 -left-16 pointer-events-none"></div>

    <!-- Register Card -->
    <div class="relative w-full max-w-md p-8 rounded-2xl backdrop-blur-xl bg-white/10 border border-white/20 shadow-2xl animate-fadeIn">

        <div class="text-center mb-6">
            <h1 class="text-3xl font-extrabold text-white tracking-wide">Create Account</h1>
            <p class="text-white/70 text-sm mt-1">Join Hosting Manager to control your infrastructure</p>
        </div>

        <form @submit.prevent="submit" class="space-y-4">

            <!-- Name -->
            <div class="relative">
                <label class="text-white/80 text-sm font-medium">Full Name</label>
                <div class="relative mt-1">
                    <input 
                        type="text" 
                        v-model="form.name" 
                        placeholder="John Doe"
                        class="w-full p-3 pl-11 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:bg-white/20 transition" 
                    />
                    <span class="absolute left-3.5 top-3.5 text-lg">👤</span>
                </div>
                <div v-if="form.errors.name" class="text-rose-300 text-xs mt-1 font-medium">
                    {{ form.errors.name }}
                </div>
            </div>

            <!-- Email -->
            <div class="relative">
                <label class="text-white/80 text-sm font-medium">Email Address</label>
                <div class="relative mt-1">
                    <input 
                        type="email" 
                        v-model="form.email" 
                        placeholder="email@example.com"
                        class="w-full p-3 pl-11 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:bg-white/20 transition" 
                    />
                    <span class="absolute left-3.5 top-3.5 text-lg">📧</span>
                </div>
                <div v-if="form.errors.email" class="text-rose-300 text-xs mt-1 font-medium">
                    {{ form.errors.email }}
                </div>
            </div>

            <!-- Password -->
            <div class="relative">
                <label class="text-white/80 text-sm font-medium">Password</label>
                <div class="relative mt-1">
                    <input 
                        type="password" 
                        v-model="form.password" 
                        placeholder="••••••••"
                        class="w-full p-3 pl-11 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:bg-white/20 transition" 
                    />
                    <span class="absolute left-3.5 top-3.5 text-lg">🔒</span>
                </div>
                <div v-if="form.errors.password" class="text-rose-300 text-xs mt-1 font-medium">
                    {{ form.errors.password }}
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="relative">
                <label class="text-white/80 text-sm font-medium">Confirm Password</label>
                <div class="relative mt-1">
                    <input 
                        type="password" 
                        v-model="form.password_confirmation" 
                        placeholder="••••••••"
                        class="w-full p-3 pl-11 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:bg-white/20 transition" 
                    />
                    <span class="absolute left-3.5 top-3.5 text-lg">🔐</span>
                </div>
            </div>

            <!-- Button -->
            <button 
                type="submit"
                :disabled="form.processing"
                class="w-full py-3 mt-2 rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-semibold shadow-lg shadow-sky-500/40 hover:shadow-xl hover:shadow-sky-500/60 transition duration-300 disabled:opacity-50 flex items-center justify-center gap-2">
                <svg v-if="form.processing" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ form.processing ? 'Creating Account...' : 'Register' }}</span>
            </button>

            <!-- Login link -->
            <div class="text-center mt-4 text-sm text-white/70">
                Already have an account? 
                <a href="/login" class="text-white font-semibold underline hover:text-sky-300 transition">Sign in</a>
            </div>

        </form>
    </div>

</div>
</template>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.8s ease-out;
}
</style>