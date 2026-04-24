<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">Dashboard Home</h1>
        <p class="text-muted-foreground">Welcome back, {{ userName }}!</p>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 mt-6">
            <Card>
                <CardHeader>
                    <CardTitle>Total Users</CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="text-3xl font-bold">1,234</p>
                </CardContent>
            </Card>
            <Card>
                <CardHeader>
                    <CardTitle>Revenue</CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="text-3xl font-bold">$12,345</p>
                </CardContent>
            </Card>
            <Card>
                <CardHeader>
                    <CardTitle>Active Sessions</CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="text-3xl font-bold">42</p>
                </CardContent>
            </Card>
        </div>
    </div>
</template>

<script setup>
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
import { computed } from 'vue'

// Example: get user name from auth store
const userName = computed(() => 'John Doe')
</script>