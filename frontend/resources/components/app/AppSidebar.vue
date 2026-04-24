<script setup>
import { computed, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import {
  BookOpen,
  ChevronsUpDown,
  Home,
  LayoutDashboard,
  LogOut,
  Settings2,
  UserRound,
} from "lucide-vue-next";
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  useSidebar,
} from "@/components/app/sidebar";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import {
  clearAuthSession,
  getStoredUser,
  isAuthenticated,
  logout as logoutRequest,
} from "@/lib/auth";

const router = useRouter();
const route = useRoute();
const { isMobile, setOpenMobile, showLabels } = useSidebar();

const user = ref(getStoredUser());

const navigationItems = [
  {
    title: "Dashboard",
    to: "/dashboard",
    icon: Home,
  },
];

const userName = computed(() => user.value?.username || user.value?.email || "User");
const userEmail = computed(() => user.value?.email || "Signed in");
const userInitials = computed(() => {
  const parts = userName.value.split(" ").filter(Boolean);
  const initials = parts.map((part) => part[0]).join("").toUpperCase();

  return initials || "U";
});

function isActive(path) {
  if (path === "/dashboard") {
    return route.path === "/dashboard";
  }
  return route.path === path || route.path.startsWith(`${path}/`);
}

function closeMobileSidebar() {
  if (isMobile.value) {
    setOpenMobile(false);
  }
}

async function goTo(path) {
  closeMobileSidebar();
  await router.push(path);
}

async function logout() {
  try {
    if (isAuthenticated()) {
      await logoutRequest();
    }
  } catch (error) {
    console.error("Logout request failed:", error);
  } finally {
    clearAuthSession();
    closeMobileSidebar();
    await router.push("/login");
  }
}
</script>

<template>
  <Sidebar>
    <SidebarHeader class="border-b p-3">
      <router-link to="/dashboard"
        class="flex items-center gap-3 overflow-hidden rounded-xl border bg-background px-3 py-3 transition-colors hover:bg-accent/60"
        @click="closeMobileSidebar">
        <div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-primary text-primary-foreground">
          <LayoutDashboard class="size-5" />
        </div>

        <div v-if="showLabels" class="min-w-0">
          <p class="truncate text-sm font-semibold text-foreground">YiiVue Dashboard</p>
          <p class="truncate text-xs text-muted-foreground">Laravel-style shadcn shell</p>
        </div>
      </router-link>
    </SidebarHeader>

    <SidebarContent>
      <SidebarGroup>

        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem v-for="item in navigationItems" :key="item.to">
              <SidebarMenuButton as-child :is-active="isActive(item.to)">
                <router-link :to="item.to" @click="closeMobileSidebar">
                  <component :is="item.icon" class="size-4 shrink-0" />

                  <div v-if="showLabels" class="grid min-w-0 flex-1 text-left leading-tight">
                    <span class="truncate" :class="isActive(item.to) ? 'text-white/80' : 'text-muted-foreground'">{{ item.title }}</span>
                  </div>
                </router-link>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
    </SidebarContent>

    <SidebarFooter class="border-t p-2">
      <DropdownMenu>
        <DropdownMenuTrigger as-child>
          <SidebarMenuButton class="h-auto py-2">
            <Avatar class="size-8 shrink-0 border">
              <AvatarFallback>{{ userInitials }}</AvatarFallback>
            </Avatar>

            <div v-if="showLabels" class="grid min-w-0 flex-1 text-left leading-tight">
              <span class="truncate text-sm font-medium text-foreground">{{ userName }}</span>
              <span class="truncate text-xs text-muted-foreground">{{ userEmail }}</span>
            </div>

            <ChevronsUpDown v-if="showLabels" class="ml-auto size-4 text-muted-foreground" />
          </SidebarMenuButton>
        </DropdownMenuTrigger>

        <DropdownMenuContent align="end" side="top" class="w-56">
          <DropdownMenuLabel>My Account</DropdownMenuLabel>
          <DropdownMenuSeparator />

          <DropdownMenuItem @click="goTo('/dashboard/profile')">
            <UserRound class="size-4" />
            Profile
          </DropdownMenuItem>

          <DropdownMenuItem @click="goTo('/dashboard/settings')">
            <Settings2 class="size-4" />
            Settings
          </DropdownMenuItem>

          <DropdownMenuSeparator />

          <DropdownMenuItem class="text-destructive focus:text-destructive" @click="logout">
            <LogOut class="size-4" />
            Logout
          </DropdownMenuItem>
        </DropdownMenuContent>
      </DropdownMenu>
    </SidebarFooter>
  </Sidebar>
</template>
