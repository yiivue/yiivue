<template>
  <div
    class="min-h-[calc(100vh-10rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background glow -->
    <div
      class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl h-96 bg-[#185b8f]/5 blur-[120px] -z-10 rounded-full">
    </div>

    <div class="max-w-md w-full space-y-8 animate-fade-in">
      <div class="text-center">
        <router-link to="/" class="inline-flex items-center gap-2 mb-6 group">
          <div
            class="size-12 rounded-2xl bg-[#185b8f] flex items-center justify-center text-white shadow-lg shadow-[#185b8f]/20 group-hover:scale-105 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
            </svg>
          </div>
        </router-link>
        <h2 class="text-3xl font-black tracking-tight text-gray-900  uppercase">
          Create <span class="text-[#7cb342]">Account</span>.
        </h2>
        <p class="mt-2 text-sm text-gray-500 ">
          Join YiiVue to manage your personnel efficiently.
        </p>
      </div>

      <div
        class="bg-white  p-8 rounded-3xl border border-gray-100  shadow-2xl shadow-gray-200/50 ">
        <form @submit.prevent="handleRegister" class="space-y-5">
          <div class="space-y-2">
            <Label for="username" class="text-xs font-bold uppercase tracking-wider text-gray-500">Username</Label>
            <Input id="username" type="text" v-model="username" placeholder="johndoe" required
              class="h-11 rounded-xl border-gray-200  bg-gray-50/50  focus:ring-[#185b8f] focus:border-[#185b8f] transition-all" />
          </div>

          <div class="space-y-2">
            <Label for="email" class="text-xs font-bold uppercase tracking-wider text-gray-500">Email Address</Label>
            <Input id="email" type="email" v-model="email" placeholder="name@example.com" required
              class="h-11 rounded-xl border-gray-200  bg-gray-50/50  focus:ring-[#185b8f] focus:border-[#185b8f] transition-all" />
          </div>

          <div class="space-y-2">
            <Label for="password" class="text-xs font-bold uppercase tracking-wider text-gray-500">Password</Label>
            <Input id="password" type="password" v-model="password" placeholder="••••••••" required
              class="h-11 rounded-xl border-gray-200  bg-gray-50/50  focus:ring-[#185b8f] focus:border-[#185b8f] transition-all" />
          </div>
          <div class="space-y-2">
            <Label for="password_confirmation"
              class="text-xs font-bold uppercase tracking-wider text-gray-500">Confirm</Label>
            <Input id="password_confirmation" type="password" v-model="passwordConfirmation" placeholder="••••••••"
              required
              class="h-11 rounded-xl border-gray-200  bg-gray-50/50  focus:ring-[#185b8f] focus:border-[#185b8f] transition-all" />
          </div>

          <p v-if="errorMessage"
            class="text-sm font-medium text-red-500 bg-red-50  p-3 rounded-lg border border-red-100 ">
            {{ errorMessage }}
          </p>

           <Button type="submit"
            class="w-full h-12 rounded-xl bg-[#1b75bb] hover:bg-[#185b8f] text-white font-bold uppercase tracking-widest text-xs shadow-lg shadow-[#185b8f]/20 transition-all hover:-translate-y-0.5"
            :disabled="isSubmitting">
            {{ isSubmitting ? 'Creating Account...' : 'Register Now' }}
          </Button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100  text-center">
          <p class="text-sm text-gray-500 ">
            Already have an account?
            <router-link to="/register" class="font-bold text-[#185b8f] hover:underline">Sign In</router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { register, setAuthSession } from '@/lib/auth'

const username = ref('')
const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')
const errorMessage = ref('')
const isSubmitting = ref(false)
const router = useRouter()

const handleRegister = async () => {
  errorMessage.value = ''

  if (password.value !== passwordConfirmation.value) {
    errorMessage.value = 'Passwords do not match.'
    return
  }

  isSubmitting.value = true

  try {
    const response = await register({
      username: username.value.trim(),
      email: email.value.trim(),
      password: password.value,
    })

    setAuthSession(response)
    await router.push('/dashboard')
  } catch (error) {
    errorMessage.value = error instanceof Error ? error.message : 'Unable to register.'
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(10px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.6s ease-out forwards;
}
</style>
