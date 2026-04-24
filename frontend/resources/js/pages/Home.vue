<template>
  <div class="relative overflow-hidden bg-white  min-h-screen">
    <!-- Geometric Background Elements (Laravel Style) -->
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden -z-10">
        <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] bg-[#FF2D20]/5 blur-[120px] rounded-full"></div>
        <div class="absolute top-[20%] -left-[10%] w-[40%] h-[40%] bg-[#FF2D20]/5 blur-[100px] rounded-full"></div>
    </div>

    <!-- Hero Section -->
    <div class="container mx-auto px-6 pt-24 pb-32">
      <div class="max-w-5xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#FF2D20]/10 text-[#FF2D20] text-sm font-semibold mb-8 animate-fade-in">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FF2D20] opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#FF2D20]"></span>
          </span>
          Modern YiiVue v2.0
        </div>

        <h1 class="text-6xl md:text-8xl font-black tracking-tight text-[#111827]  mb-8 leading-[1.1]">
          The Fast, Secure <br/>
          <span class="text-[#FF2D20]">PHP YiiVue Framework.</span>
        </h1>
        
        <p class="text-xl md:text-2xl text-gray-600  mb-12 max-w-3xl mx-auto leading-relaxed">
          The ultimate single-page application boilerplate for Personnel Management. 
          Engineered with <strong>Yii2</strong> for industrial-grade stability and <strong>Vue 3</strong> for a seamless user experience.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-6 mb-20">
          <Button size="lg" class="bg-[#FF2D20] hover:bg-[#e0261b] text-white rounded-xl px-10 h-14 text-lg font-bold shadow-xl shadow-[#FF2D20]/20 transition-all hover:-translate-y-1" as-child>
            <router-link to="/register">Explore Dashboard</router-link>
          </Button>
          <Button size="lg" variant="outline" class="rounded-xl px-10 h-14 text-lg font-bold border-gray-200  transition-all hover:bg-gray-50  hover:-translate-y-1" as-child>
            <router-link to="/documentation">Setup Guide</router-link>
          </Button>
        </div>

        <!-- Featured Section (Card Style) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-left">
          <div class="group relative p-8 rounded-3xl border border-gray-100  bg-white  shadow-sm hover:shadow-2xl transition-all duration-300">
            <div class="size-14 rounded-2xl bg-[#FF2D20]/10 flex items-center justify-center text-[#FF2D20] mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <h3 class="text-2xl font-bold mb-3 ">Yii2 Engine</h3>
            <p class="text-gray-600  leading-relaxed">Leverage the power of ActiveRecord, industrial-grade security, and the Gii generator for rapid YiiVue development.</p>
          </div>

          <div class="group relative p-8 rounded-3xl border border-gray-100  bg-white  shadow-sm hover:shadow-2xl transition-all duration-300">
            <div class="size-14 rounded-2xl bg-[#FF2D20]/10 flex items-center justify-center text-[#FF2D20] mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            </div>
            <h3 class="text-2xl font-bold mb-3 ">Vue 3 Reactivity</h3>
            <p class="text-gray-600  leading-relaxed">A modern, component-based frontend powered by Vue 3 (Composition API) and Vite for instant feedback and performance.</p>
          </div>

          <div class="group relative p-8 rounded-3xl border border-gray-100  bg-white  shadow-sm hover:shadow-2xl transition-all duration-300 md:col-span-2 lg:col-span-1">
            <div class="size-14 rounded-2xl bg-[#FF2D20]/10 flex items-center justify-center text-[#FF2D20] mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <h3 class="text-2xl font-bold mb-3 ">Docker First</h3>
            <p class="text-gray-600  leading-relaxed">Pre-configured Docker environment ensures your YiiVue stack works perfectly across all machines and servers.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Button } from '@/components/ui/button'
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
