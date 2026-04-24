import { inject } from "vue";

export const SIDEBAR_INJECTION_KEY = Symbol("sidebar");

export function useSidebar() {
  const context = inject(SIDEBAR_INJECTION_KEY, null);

  if (!context) {
    throw new Error("useSidebar must be used within SidebarProvider.");
  }

  return context;
}
