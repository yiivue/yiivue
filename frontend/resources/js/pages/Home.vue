<template>
  <div class="relative overflow-hidden bg-white  min-h-screen">
    <!-- Geometric Background Elements (Laravel Style) -->
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden -z-10">
      <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] bg-[#1b75bb]/5 blur-[120px] rounded-full"></div>
      <div class="absolute top-[20%] -left-[10%] w-[40%] h-[40%] bg-[#7cb342]/5 blur-[100px] rounded-full"></div>
    </div>

    <!-- Hero Section -->
    <div class="container mx-auto px-6 pt-10 pb-32">
      <div class="max-w-5xl mx-auto text-left">

        <h1 class="text-6xl md:text-8xl font-black tracking-tight text-[#111827]  mb-8 leading-[1.1]">
          The Fast, Secure <br />
          <span class="text-[#1b75bb]">PHP YiiVue Framework.</span>
        </h1>

        <p class="text-xl md:text-2xl text-gray-600 mb-12 max-w-3xl leading-relaxed">
          The ultimate single-page application boilerplate for Personnel Management.
          Engineered with <strong>Yii2</strong> for industrial-grade stability and <strong>Vue 3</strong> for a seamless
          user experience.
        </p>

        <div class="flex flex-col sm:flex-row justify-start gap-6 mb-20">
          <Button size="lg"
            class="bg-[#1b75bb] hover:bg-[#185b8f] text-white rounded-xl px-10 h-14 text-lg font-bold shadow-xl shadow-[#185b8f]/20 transition-all hover:-translate-y-1"
            as-child>
            <router-link to="/register">Explore Dashboard</router-link>
          </Button>
          <Button size="lg" variant="outline"
            class="rounded-xl px-10 h-14 text-lg font-bold border-gray-200  transition-all hover:bg-gray-50  hover:-translate-y-1"
            as-child>
            <a href="https://yiivue.zcreations.xyz/" target="_blank" rel="noopener noreferrer">Setup Guide</a>
          </Button>
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
