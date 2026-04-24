<script setup>
import { cn } from "@/lib/utils";
import { Sheet, SheetContent } from "@/components/ui/sheet";
import { useSidebar } from "./useSidebar";

const props = defineProps({
  class: {
    type: [Boolean, null, String, Object, Array],
    required: false,
    skipCheck: true,
  },
});

const { isMobile, open, openMobile, setOpenMobile } = useSidebar();
</script>

<template>
  <Sheet v-if="isMobile" :open="openMobile" @update:open="setOpenMobile">
    <SheetContent side="left" class="w-72 border-r p-0 [&>button]:hidden">
      <div class="flex h-full flex-col bg-background">
        <slot />
      </div>
    </SheetContent>
  </Sheet>

  <aside
    v-else
    :class="
      cn(
        'hidden border-r bg-background md:flex md:flex-col md:transition-[width] md:duration-200 md:ease-linear',
        open ? 'md:w-72' : 'md:w-[4.5rem]',
        props.class,
      )
    "
  >
    <div class="flex h-screen flex-1 flex-col overflow-hidden">
      <slot />
    </div>
  </aside>
</template>
