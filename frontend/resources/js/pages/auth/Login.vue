<template>
  <div class="min-h-[calc(100vh-10rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl h-96 bg-[#FF2D20]/5 blur-[120px] -z-10 rounded-full"></div>

    <div class="max-w-md w-full space-y-8 animate-fade-in">
      <div class="text-center">
        <router-link to="/" class="inline-flex items-center gap-2 mb-6 group">
          <div class="size-12 rounded-2xl bg-[#FF2D20] flex items-center justify-center text-white shadow-lg shadow-[#FF2D20]/20 group-hover:scale-105 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
          </div>
        </router-link>
        <h2 class="text-3xl font-black tracking-tight text-gray-900  uppercase">
          Welcome <span class="text-[#FF2D20]">Back</span>.
        </h2>
        <p class="mt-2 text-sm text-gray-500 ">
          Sign in to your YiiVue account to continue.
        </p>
      </div>

      <div class="bg-white  p-8 rounded-3xl border border-gray-100  shadow-2xl shadow-gray-200/50 ">
        <form @submit.prevent="handleLogin" class="space-y-6">
          <div class="space-y-2">
            <Label for="email" class="text-xs font-bold uppercase tracking-wider text-gray-500">Email Address</Label>
            <Input 
              id="email" 
              type="email" 
              v-model="email" 
              placeholder="name@example.com"
              required 
              class="h-12 rounded-xl border-gray-200  bg-gray-50/50  focus:ring-[#FF2D20] focus:border-[#FF2D20] transition-all"
            />
          </div>
          
          <div class="space-y-2">
            <div class="flex items-center justify-between">
              <Label for="password" class="text-xs font-bold uppercase tracking-wider text-gray-500">Password</Label>
              <a href="#" class="text-xs font-bold text-[#FF2D20] hover:underline">Forgot password?</a>
            </div>
            <Input 
              id="password" 
              type="password" 
              v-model="password" 
              placeholder="••••••••"
              required 
              class="h-12 rounded-xl border-gray-200  bg-gray-50/50  focus:ring-[#FF2D20] focus:border-[#FF2D20] transition-all"
            />
          </div>

          <p v-if="errorMessage" class="text-sm font-medium text-red-500 bg-red-50  p-3 rounded-lg border border-red-100 ">
            {{ errorMessage }}
          </p>

          <Button type="submit" class="w-full h-12 rounded-xl bg-[#FF2D20] hover:bg-[#e0261b] text-white font-bold uppercase tracking-widest text-xs shadow-lg shadow-[#FF2D20]/20 transition-all hover:-translate-y-0.5" :disabled="isSubmitting">
            {{ isSubmitting ? 'Authenticating...' : 'Sign In' }}
          </Button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100  text-center">
          <p class="text-sm text-gray-500 ">
            Don't have an account?
            <router-link to="/register" class="font-bold text-[#FF2D20] hover:underline">Create Account</router-link>
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
import { login, setAuthSession } from '@/lib/auth'

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const isSubmitting = ref(false)
const router = useRouter()

const handleLogin = async () => {
    errorMessage.value = ''
    isSubmitting.value = true

    try {
        const response = await login({
            email: email.value.trim(),
            password: password.value,
        })

        setAuthSession(response)
        await router.push('/dashboard')
    } catch (error) {
        errorMessage.value = error instanceof Error ? error.message : 'Invalid email or password.'
    } finally {
        isSubmitting.value = false
    }
}
</script>

<style scoped>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 0.6s ease-out forwards;
}
</style>
