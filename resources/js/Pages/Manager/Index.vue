<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md fixed h-full z-10">
      <div class="p-4 text-xl font-bold border-b">📁 Omishtu JTS</div>
      <nav class="p-4 space-y-4">
        <div class="hover:bg-gray-200 p-2 rounded cursor-pointer">📄 Documents</div>
        <div class="hover:bg-gray-200 p-2 rounded cursor-pointer">✉️ Letters</div>
        <div class="hover:bg-gray-200 p-2 rounded cursor-pointer">🔁 Approvals</div>
        <div class="hover:bg-gray-200 p-2 rounded cursor-pointer">📊 Reports</div>
        <div class="hover:bg-gray-200 p-2 rounded cursor-pointer">🛠️ Settings</div>
      </nav>
    </aside>

    <!-- Main content -->
    <div class="ml-64">
      <!-- Topbar -->
      <header class="bg-white shadow p-4 flex justify-between items-center">
        <input
          type="text"
          placeholder="Search documents, letters..."
          class="border px-4 py-2 rounded w-1/3"
        />
        <div class="flex items-center space-x-4">
          <button class="text-xl">🔔</button>
          <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
        </div>
      </header>

      <!-- Dashboard Content -->
      <main class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-4 shadow rounded">
          <div class="text-sm text-gray-500">Pending Approvals</div>
          <div class="text-3xl font-bold">7</div>
        </div>
        <div class="bg-white p-4 shadow rounded">
          <div class="text-sm text-gray-500">New Letters Today</div>
          <div class="text-3xl font-bold">12</div>
        </div>
        <div class="bg-white p-4 shadow rounded">
          <div class="text-sm text-gray-500">Completed Approvals</div>
          <div class="text-3xl font-bold">25</div>
        </div>

        <!-- CHART BLOCK -->
        <div class="bg-white p-4 shadow rounded col-span-full">
          <div class="text-sm text-gray-500 mb-2">🔁 Approvals by Department</div>
          <div class="h-72">
            <Bar :data="chartData" :options="chartOptions" />
          </div>
        </div>

        <div class="bg-white p-4 shadow rounded col-span-full">
          <div class="text-sm text-gray-500 mb-2">Recent Activity</div>
          <ul class="space-y-2 text-sm">
            <li>✅ Document 'Project Plan.pdf' approved by Manager</li>
            <li>✉️ Letter 'Offer to ABC Ltd' sent</li>
            <li>📄 New file 'Contract_Agreement.docx' uploaded</li>
          </ul>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const chartData = {
  labels: ['HR', 'Finance', 'IT', 'Logistics'],
  datasets: [
    {
      label: 'Approvals Completed',
      backgroundColor: '#10b981',
      borderRadius: 5,
      data: [15, 8, 12, 9]
    }
  ]
}

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: true
    }
  },
  scales: {
    y: {
      beginAtZero: true
    }
  }
}
</script>

<style scoped>
body {
  font-family: 'Inter', sans-serif;
}
</style>
