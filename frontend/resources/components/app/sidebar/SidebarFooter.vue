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
  <div :class="cn('mt-auto flex shrink-0 flex-col gap-2 p-2', props.class)">
    <slot />
  </div>
</template>
