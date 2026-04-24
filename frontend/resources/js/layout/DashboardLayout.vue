<template>
    <SidebarProvider class="bg-background text-foreground transition-colors duration-300">
        <AppSidebar />

        <SidebarInset class="bg-background">
            <header
                class="sticky top-0 z-20 flex h-16 shrink-0 items-center justify-between gap-2 border-b bg-background/95 px-4 backdrop-blur border-border">
                <div class="flex items-center gap-2">
                    <SidebarTrigger />
                    <Separator orientation="vertical" class="mr-2 h-4" />

                    <div class="grid gap-0.5">
                        <p class="text-sm font-semibold text-foreground">{{ currentTitle }}</p>
                        <p class="text-xs text-muted-foreground">{{ currentDescription }}</p>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-auto bg-muted/20 p-4 md:p-6">
                <div class="mx-auto flex w-full max-w-6xl flex-col gap-6">
                    <router-view />
                </div>
            </main>
        </SidebarInset>
    </SidebarProvider>
</template>

<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import AppSidebar from "@/components/app/AppSidebar.vue";
import {
    SidebarInset,
    SidebarProvider,
    SidebarTrigger,
} from "@/components/app/sidebar";
import { Separator } from "@/components/ui/separator";

const route = useRoute();

const currentTitle = computed(() => route.meta.title || "Dashboard");
const currentDescription = computed(
    () => route.meta.description || "Manage your workspace with the sidebar shell.",
);
</script>