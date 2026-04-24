<template>
    <div class="text-center py-12">
        <h1 class="text-6xl font-bold text-muted-foreground mb-4">404</h1>
        <h2 class="text-2xl font-semibold mb-2">Page Not Found</h2>
        <p class="text-muted-foreground mb-6">The page you are looking for doesn't exist.</p>
        <Button as-child>
            <router-link to="/">Go Home</router-link>
        </Button>
    </div>
</template>

<script setup>
import { Button } from '@/components/ui/button'
</script>