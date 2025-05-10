<script setup>
import { ref } from 'vue';
import Sidebar from '@/Components/Sidebar.vue'; // Import the Sidebar component

const activities = [
  { time: '5 Minutes ago', desc: 'You have new order please check this out', color: 'bg-blue-500' },
  { time: '35 Minutes ago', desc: 'A Product has delivered!', color: 'bg-green-500' },
  { time: '44 Minutes ago', desc: 'You have new order please check this out', color: 'bg-blue-500' },
];

const summaryCards = [
  { title: 'Total Products', value: '50+', desc: 'Last 3 weeks', color: 'bg-blue-400' },
  { title: 'Total Customer', value: '3433+', desc: 'Last 3 weeks', color: 'bg-green-600' },
  { title: 'Total Sale', value: '3433+', desc: 'Last 3 weeks', color: 'bg-slate-700' },
  { title: 'Pending Orders', value: '3433+', desc: 'Last 3 weeks', color: 'bg-orange-500' },
];
</script>

<template>
  <div class="flex min-h-screen bg-gray">
    <!-- Sidebar -->
    <Sidebar />
    <!-- Main Content -->
    <main class="flex-1 p-8">
      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
          <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
        </div>
        <div class="flex items-center gap-4">
          <button class="relative">
            <i class="bi bi-bell text-2xl text-gray-600"></i>
            <span class="absolute -top-1 -right-2 bg-red-500 text-white rounded-full text-xs px-1">3</span>
          </button>
          <div class="flex items-center gap-2">
            <img src="/assets/user.png" alt="Jane Smith" class="h-9 w-9 rounded-full border-2 border-white shadow" />
            <span class="font-semibold text-gray-700">Jane Smith</span>
          </div>
        </div>
      </div>

      <!-- Welcome Alert -->
      <div class="mb-6">
        <div class="flex items-center bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
          <i class="bi bi-check-circle-fill mr-2 text-green-500"></i>
          <span class="font-medium">Login Successfully! Welcome to <span class="font-bold text-green-600">Omishtu</span></span>
        </div>
      </div>

      <!-- Dashboard Summary Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div v-for="card in summaryCards" :key="card.title" class="bg-white rounded-xl shadow p-5 flex flex-col gap-3">
          <div class="flex items-center justify-between">
            <div class="font-semibold text-gray-700">{{ card.title }}</div>
            <div :class="['rounded-full px-4 py-1 text-white font-bold', card.color]">{{ card.value }}</div>
          </div>
          <div class="text-gray-400 text-sm">{{ card.desc }}</div>
        </div>
      </div>

      <div class="flex flex-col lg:flex-row gap-8">
        <!-- Activities Timeline -->
        <div class="bg-white rounded-xl shadow p-6 flex-1">
          <h2 class="text-lg font-semibold mb-4">Activities</h2>
          <div>
            <ul>
              <li v-for="(activity, idx) in activities" :key="idx" class="flex gap-3 items-start mb-6">
                <span :class="['w-4 h-4 rounded-full mt-1', activity.color]"></span>
                <div>
                  <div class="font-medium">{{ activity.time }}</div>
                  <div class="text-gray-500 text-sm">{{ activity.desc }}</div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <!-- View Orders Button -->
        <div class="flex flex-col gap-4 w-full lg:w-1/3">
          <button class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow transition w-full">
            VIEW ORDERS
          </button>
          <!-- Example Recent Order Table -->
          <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Recent Order list</h2>
            <table class="w-full text-sm">
              <thead>
                <tr class="text-left text-gray-600">
                  <th class="pb-2">Dessert (100g serving)</th>
                  <th class="pb-2">Calories</th>
                  <th class="pb-2">Fat (g)</th>
                  <th class="pb-2">Carbs (g)</th>
                  <th class="pb-2">Protein (g)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Frozen Yogurt</td>
                  <td>159</td>
                  <td>6</td>
                  <td>24</td>
                  <td>4</td>
                </tr>
                <tr>
                  <td>Ice cream sandwich</td>
                  <td>237</td>
                  <td>9</td>
                  <td>37</td>
                  <td>4.3</td>
                </tr>
                <!-- Add more rows as needed -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
/* Hide scroll bars for sidebar for a cleaner look */
aside {
  scrollbar-width: none;
}
aside::-webkit-scrollbar {
  display: none;
}
</style>
