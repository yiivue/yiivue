<script setup>
import { computed, provide, ref } from "vue";
import { useMediaQuery } from "@vueuse/core";
import { cn } from "@/lib/utils";
import { SIDEBAR_INJECTION_KEY } from "./useSidebar";

const props = defineProps({
  defaultOpen: { type: Boolean, required: false, default: true },
  class: {
    type: [Boolean, null, String, Object, Array],
    required: false,
    skipCheck: true,
  },
});

const open = ref(props.defaultOpen);
const openMobile = ref(false);
const isMobile = useMediaQuery("(max-width: 767px)");
const showLabels = computed(() => open.value || isMobile.value);
const isCollapsed = computed(() => !showLabels.value);

function setOpen(value) {
  open.value = value;
}

function setOpenMobile(value) {
  openMobile.value = value;
}

function toggleSidebar() {
  if (isMobile.value) {
    openMobile.value = !openMobile.value;
    return;
  }

  open.value = !open.value;
}

provide(SIDEBAR_INJECTION_KEY, {
  open,
  openMobile,
  isMobile,
  showLabels,
  isCollapsed,
  setOpen,
  setOpenMobile,
  toggleSidebar,
});
</script>

<template>
  <div :class="cn('flex min-h-screen w-full bg-muted/30', props.class)">
    <slot />
  </div>
</template>
