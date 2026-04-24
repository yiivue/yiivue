<script setup>
import { cn } from "@/lib/utils";

const props = defineProps({
  class: {
    type: [Boolean, null, String, Object, Array],
    required: false,
    skipCheck: true,
  },
});
</script>

<template>
  <div :class="cn('flex min-h-screen min-w-0 flex-1 flex-col bg-background', props.class)">
    <slot />
  </div>
</template>
