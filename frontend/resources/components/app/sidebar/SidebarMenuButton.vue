<script setup>
import { Primitive } from "reka-ui";
import { cn } from "@/lib/utils";
import { useSidebar } from "./useSidebar";

const props = defineProps({
  isActive: { type: Boolean, required: false, default: false },
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false, default: "button" },
  class: {
    type: [Boolean, null, String, Object, Array],
    required: false,
    skipCheck: true,
  },
});

const { isCollapsed } = useSidebar();
</script>

<template>
  <Primitive
    :as="as"
    :as-child="asChild"
    :type="as === 'button' && !asChild ? 'button' : undefined"
    :class="
      cn(
        'flex h-10 w-full items-center gap-3 overflow-hidden rounded-lg text-sm font-medium outline-none transition-colors focus-visible:ring-2 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50',
        props.isActive
          ? 'bg-[#FF2D20] text-white shadow-lg shadow-[#FF2D20]/20'
          : 'text-muted-foreground hover:bg-accent/80 hover:text-foreground',
        isCollapsed ? 'justify-center px-2' : 'px-3',
        props.class,
      )
    "
  >
    <slot />
  </Primitive>
</template>
