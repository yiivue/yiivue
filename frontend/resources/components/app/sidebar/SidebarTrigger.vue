<script setup>
import { PanelLeft } from "lucide-vue-next";
import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { useSidebar } from "./useSidebar";

const props = defineProps({
  class: {
    type: [Boolean, null, String, Object, Array],
    required: false,
    skipCheck: true,
  },
});

const { toggleSidebar } = useSidebar();
</script>

<template>
  <Button
    variant="ghost"
    size="icon"
    :class="cn('size-9', props.class)"
    @click="toggleSidebar"
  >
    <PanelLeft class="size-4" />
    <span class="sr-only">Toggle Sidebar</span>
  </Button>
</template>
