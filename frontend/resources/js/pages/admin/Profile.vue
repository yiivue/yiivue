<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">Profile</h1>
        <Card>
            <CardHeader>
                <CardTitle>Edit Profile</CardTitle>
                <CardDescription>Update your personal information</CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="updateProfile" class="space-y-4">
                    <div>
                        <Label for="profile-name">Name</Label>
                        <Input id="profile-name" type="text" v-model="form.name" />
                    </div>
                    <div>
                        <Label for="profile-email">Email</Label>
                        <Input id="profile-email" type="email" v-model="form.email" />
                    </div>
                    <Button type="submit">Save Changes</Button>
                </form>
            </CardContent>
        </Card>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'

const form = reactive({
    name: 'John Doe',
    email: 'john@example.com'
})

const updateProfile = () => {
    // API call to update profile
    console.log('Updating profile', form)
}
</script>