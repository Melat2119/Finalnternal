<template>
  <div class="sidebar bg-white shadow-sm border-end p-4 d-flex flex-column justify-content-between" style="width: 250px; min-height: 100vh;">
    <div>
      <!-- Logo / Brand -->
      <div class="d-flex align-items-center mb-4 ml-4">
        <img src="/assets/image.png" alt="Logo" class="me-2" style="width: 60px;" />
      </div>
      <!-- Navigation Links -->
      <ul class="nav flex-column">
        <li class="nav-item mb-2" v-for="link in links" :key="link.name">
          <Link
            :href="route(link.name)"
            class="nav-link d-flex align-items-center sidebar-link"
            :class="{ active: $page.url.startsWith('/' + link.urlStart) }"
          >
            <i :class="link.icon + ' me-2 text-primary'"></i>
            {{ link.label }}
          </Link>
        </li>
      </ul>
    </div>
    <!-- Optional Footer/Account Section -->
    <div class="mt-4">
      <hr />
      <Link href="/settings" class="nav-link d-flex align-items-center sidebar-link">
        <i class="bi bi-gear me-2 text-secondary"></i>
        Settings
      </Link>
      <Link href="/logout" class="nav-link d-flex align-items-center sidebar-link mt-2 text-danger">
        <i class="bi bi-box-arrow-right me-2"></i>
        Logout
      </Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const links = [
  { name: 'dashboard', label: 'Dashboard', icon: 'bi bi-house-door', urlStart: 'dashboard' },
  { name: 'sales.index', label: 'Sales', icon: 'bi bi-bar-chart-line', urlStart: 'sales' },
  { name: 'developers.index', label: 'Developers', icon: 'bi bi-code-slash', urlStart: 'developers' },
  { name: 'ui.index', label: 'UI/UX Designers', icon: 'bi bi-palette', urlStart: 'ui' },
  { name: 'socialmedia.index', label: 'Social Media Manager', icon: 'bi bi-share', urlStart: 'socialmedia' },
  { name: 'reception.index', label: 'Reception', icon: 'bi bi-person', urlStart: 'reception' },
]
</script>

<style scoped>
.sidebar-link {
  color: #555;
  border-radius: 0.5rem;
  padding: 0.5rem 0.75rem;
  transition: background 0.3s, color 0.3s;
}
.sidebar-link:hover {
  background-color: #f1f1f1;
  text-decoration: none;
}
.sidebar-link.active {
  background-color: #4bf242;
  color: #fff !important;
}
.sidebar-link.active i {
  color: #fff !important;
}
</style>
