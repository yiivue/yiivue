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
  <section :class="cn('flex flex-col gap-2 px-1 py-2', props.class)">
    <slot />
  </section>
</template>
