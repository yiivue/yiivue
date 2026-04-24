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
  <div :class="cn('flex min-h-0 flex-1 flex-col gap-4 overflow-auto p-2', props.class)">
    <slot />
  </div>
</template>
