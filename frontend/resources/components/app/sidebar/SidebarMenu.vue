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
  <ul :class="cn('flex flex-col gap-1', props.class)">
    <slot />
  </ul>
</template>
