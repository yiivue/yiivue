<script setup>
import { cn } from "@/lib/utils";
import { useSidebar } from "./useSidebar";

const props = defineProps({
  class: {
    type: [Boolean, null, String, Object, Array],
    required: false,
    skipCheck: true,
  },
});

const { showLabels } = useSidebar();
</script>

<template>
  <div
    v-if="showLabels"
    :class="
      cn(
        'px-2 text-xs font-medium uppercase tracking-[0.18em] text-muted-foreground',
        props.class,
      )
    "
  >
    <slot />
  </div>
</template>
