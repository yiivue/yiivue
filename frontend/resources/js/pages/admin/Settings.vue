<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">Settings</h1>
        <Card>
            <CardHeader>
                <CardTitle>Preferences</CardTitle>
                <CardDescription>Configure your application settings</CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="saveSettings" class="space-y-6">
                    <div class="flex items-center justify-between p-4 rounded-xl bg-muted/30">
                        <div class="space-y-0.5">
                            <Label for="notifications" class="text-base font-semibold">Email Notifications</Label>
                            <p class="text-sm text-muted-foreground tracking-tight">Receive email updates about your account activity.</p>
                        </div>
                        <Switch id="notifications" v-model="settings.notifications" />
                    </div>
                    
                    <div class="pt-4">
                        <Button type="submit" class="bg-[#FF2D20] hover:bg-[#e0261b] text-white px-8 h-11 font-bold uppercase text-xs tracking-widest rounded-xl shadow-lg shadow-[#FF2D20]/20">
                            Save Preferences
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card'
import { Label } from '@/components/ui/label'
import { Switch } from '@/components/ui/switch'
import { Button } from '@/components/ui/button'

const settings = reactive({
    notifications: true,
})

const saveSettings = () => {
    // API call to save settings
    console.log('Saving settings', settings)
}
</script>