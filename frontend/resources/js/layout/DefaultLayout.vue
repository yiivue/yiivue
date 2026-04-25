<script setup>
import { useRoute } from 'vue-router'
const route = useRoute()

function isLinkActive(path) {
  if (path === '/') return route.path === '/'
  return route.path.startsWith(path)
}
</script>

<template>
  <div
    class="min-h-screen flex flex-col bg-white text-gray-900 selection:bg-[#1b75bb]/30 transition-colors duration-300">
    <!-- Navbar -->
    <header
      class="sticky top-0 z-50 w-full border-b border-gray-100 bg-white/80 backdrop-blur-md">
      <div class="container mx-auto px-6 h-16 flex justify-between items-center">
        <router-link to="/" class="flex items-center gap-2 font-black text-xl tracking-tighter">
          <div
            class="size-8 rounded-lg bg-[#1b75bb] flex items-center justify-center text-white shadow-lg shadow-[#185b8f]/20">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
            </svg>
          </div>
          <span class="hidden sm:block uppercase">YiiVue<span class="text-[#7cb342]">.</span></span>
        </router-link>

        <nav class="hidden md:flex items-center gap-8">
          <router-link to="/login" class="text-xs font-bold uppercase tracking-wider transition-colors"
            :class="isLinkActive('/login') ? 'text-[#1b75bb]' : 'text-gray-500 hover:text-[#1b75bb]'">Login</router-link>
          
          <router-link to="/register"
            class="bg-[#1b75bb] hover:bg-[#185b8f] text-white px-5 py-2 rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-[#185b8f]/20 transition-all hover:-translate-y-0.5"
            :class="isLinkActive('/register') ? 'ring-2 ring-offset-2 ring-[#185b8f]' : ''">Get Started</router-link>
        </nav>

        <div class="md:hidden flex items-center gap-4">
          <a href="https://yiivue.zcreations.xyz/" target="_blank" rel="noopener noreferrer" class="text-xs font-bold uppercase"
            :class="isLinkActive('/documentation') ? 'text-[#1b75bb]' : 'text-gray-500'">Docs</a>
        </div>
      </div>
    </header>

    <!-- Main content: Fixed minimum height to push footer down -->
    <main class="flex-1 flex flex-col">
      <router-view />
    </main>

    <!-- Streamlined Footer -->
    <footer class="border-t border-gray-100 bg-gray-50/50 py-6">
      <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
          <div class="flex items-center gap-4">
            <div class="flex items-center gap-1 font-black text-lg tracking-tighter uppercase">
              YiiVue<span class="text-[#7cb342]">.</span>
            </div>
            <div class="h-4 w-px bg-gray-200 hidden md:block"></div>
            <p class="text-[10px] uppercase font-bold tracking-[0.2em] text-gray-400">
              Yii2 + Vue.js Stack
            </p>
          </div>

          <div class="flex items-center gap-8">
            <p class="text-xs text-gray-500 font-medium">
              &copy; <span class="text-[#7cb342]">{{ new Date().getFullYear() }}</span> <a href="https://www.zcreations.xyz" target="_blank" rel="noopener noreferrer" class="hover:text-[#1b75bb]"> www.zcreations.xyz</a>
            </p>
            <div class="flex gap-4">
              <a href="#" class="text-gray-400 hover:text-[#1b75bb] transition-colors"><svg
                  xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path
                    d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" />
                </svg></a>
              <a href="#" class="text-gray-400 hover:text-[#1b75bb] transition-colors"><svg
                  xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path
                    d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22" />
                </svg></a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>
