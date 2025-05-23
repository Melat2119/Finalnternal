<script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import Sidebar from "@/Components/Sidebar.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";
// import useSideBarStore from "@/stores/sidebarStore";

// const sidebarStore = useSideBarStore();

const showingNavigationDropdown = ref(false);
const page = usePage();
</script>

<template>
  <div class="flex min-h-screen overflow-hidden bg-gray-50 relative">
    <div class="fixed left-0 top-0 z-20 bg-white">
      <Sidebar />
    </div>
    <div class="min-h-screen bg-gray-100 flex flex-col w-full lg:ml-64">
      <nav class="border-b border-gray-100 bg-white fixed top-0 right-0 left-0 lg:left-64 z-10">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex h-16 justify-between">
            <div class="flex items-center">
              <div
                @click="sidebarStore.toggleSideBar"
                class="cursor-pointer sm:hidden"
              >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
              </div>

              <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex md:flex items-center">
                <div v-if="isAdmin">
                  <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    Dashboard
                  </NavLink>
                </div>
              </div>
            </div>

            <!-- Search Bar -->
            <div class="hidden sm:flex items-center w-1/3 max-w-xl mx-auto">
              <div class="relative w-full">
                <input
                  type="text"
                  placeholder="Search..."
                  class="w-full p-2 pl-10 pr-4 ml-60 border rounded-full bg-gray-100 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green"
                />
                <svg class="absolute left-3  ml-60 top-1/2 transform -translate-y-1/2 text-gray-500 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a7 7 0 110 14 7 7 0 010-14zm0 0l7 7m-7-7l-7 7" />
                </svg>
              </div>
            </div>

            <div class="hidden sm:ms-6 sm:flex sm:items-center gap-4">
              <!-- Notifications dropdown -->
              <div class="flex items-center">
                <button type="button" class="inline-flex items-center rounded-md border border-transparent bg-white p-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                </button>
              </div>

              <Dropdown align="right" width="48">
                <template #trigger>
                  <button type="button" class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                    {{ $page.props.auth.user.name }}
                    <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                  </button>
                </template>

                <template #content>
                  <DropdownLink :href="route('profile.edit')">
                    Profile
                  </DropdownLink>
                  <DropdownLink :href="route('logout')" method="post" as="button">
                    Log Out
                  </DropdownLink>
                </template>
              </Dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
              <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                  <path :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                  <path :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
          <div class="space-y-1 pb-3 pt-2">
            <div v-if="isAdmin">
              <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                Dashboard
              </ResponsiveNavLink>
            </div>
          </div>

          <div class="border-t border-gray-200 pb-1 pt-4">
            <div class="px-4">
              <div class="text-base font-medium text-gray-800">
                {{ $page.props.auth.user.name }}
              </div>
              <div class="text-sm font-medium text-gray-500">
                {{ $page.props.auth.user.email }}
              </div>
            </div>
            <div class="mt-3 space-y-1">
              <ResponsiveNavLink :href="route('profile.edit')">
                Profile
              </ResponsiveNavLink>
              <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                Log Out
              </ResponsiveNavLink>
            </div>
          </div>
        </div>
      </nav>

      <main class="flex-1 mt-20 mx-4">
        <slot />
      </main>
    </div>
  </div>
</template>
