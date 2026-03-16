<script setup>
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps({
    email: String,
    token: String
})

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: ''
})

function submit() {
    form.post(route('password.update'))
}
</script>

<template>
    <div class="relative min-h-screen flex items-center justify-center
            bg-gradient-to-br from-sky-700 via-blue-700 to-indigo-800">

        <div class="w-full max-w-md p-8 rounded-2xl backdrop-blur-xl
            bg-white/10 border border-white/20 shadow-2xl">

            <h1 class="text-2xl font-bold text-white mb-6 text-center">
                Reset Password
            </h1>

            <form @submit.prevent="submit" class="space-y-5">

                <div>
                    <label class="text-white/80 text-sm">Email</label>
                    <input type="email" v-model="form.email"
                        class="w-full mt-2 p-3 rounded-lg bg-white/20 border border-white/30 text-white" />
                </div>

                <div>
                    <label class="text-white/80 text-sm">New Password</label>
                    <input type="password" v-model="form.password"
                        class="w-full mt-2 p-3 rounded-lg bg-white/20 border border-white/30 text-white" />
                    <p v-if="form.errors.password" class="text-red-400 text-sm">
                        {{ form.errors.password }}
                    </p>
                </div>

                <div>
                    <label class="text-white/80 text-sm">Confirm Password</label>
                    <input type="password" v-model="form.password_confirmation"
                        class="w-full mt-2 p-3 rounded-lg bg-white/20 border border-white/30 text-white" />
                </div>

                <button class="w-full py-3 rounded-lg
bg-gradient-to-r from-sky-500 to-blue-600
text-white font-semibold">
                    Reset Password
                </button>

            </form>
        </div>
    </div>
</template>