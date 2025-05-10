<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md fixed h-full z-10">
      <div class="p-4 text-xl font-bold border-b">👨‍💼 Admin Panel</div>
      <nav class="p-4 space-y-4">
        <div class="hover:bg-gray-200 p-2 rounded cursor-pointer">📁 Document Overview</div>
        <div class="hover:bg-gray-200 p-2 rounded cursor-pointer">✉️ Letters Summary</div>
        <div class="hover:bg-gray-200 p-2 rounded cursor-pointer">🔎 Audit Logs</div>
        <div class="hover:bg-gray-200 p-2 rounded cursor-pointer">👥 Manage Users</div>
        <div class="hover:bg-gray-200 p-2 rounded cursor-pointer">⚙️ System Settings</div>
      </nav>
    </aside>

    <!-- Main content -->
    <div class="ml-64">
      <!-- Topbar -->
      <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold">Director Dashboard</h1>
        <div class="flex items-center space-x-4">
          <button class="text-xl">🔔</button>
          <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
        </div>
      </header>

      <!-- Dashboard Content -->
      <main class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-4 shadow rounded">
          <div class="text-sm text-gray-500">Total Documents</div>
          <div class="text-3xl font-bold">3,428</div>
        </div>
        <div class="bg-white p-4 shadow rounded">
          <div class="text-sm text-gray-500">Letters Sent</div>
          <div class="text-3xl font-bold">1,025</div>
        </div>
        <div class="bg-white p-4 shadow rounded">
          <div class="text-sm text-gray-500">Users</div>
          <div class="text-3xl font-bold">87</div>
        </div>
        <div class="bg-white p-4 shadow rounded">
          <div class="text-sm text-gray-500">Pending Approvals</div>
          <div class="text-3xl font-bold">14</div>
        </div>

        <!-- CHART BLOCK -->
        <div class="bg-white p-4 shadow rounded col-span-full">
          <div class="text-sm text-gray-500 mb-2">📊 Documents by Department</div>
          <div class="h-72">
            <Bar :data="chartData" :options="chartOptions" />
          </div>
        </div>

        <div class="bg-white p-4 shadow rounded col-span-full">
          <div class="text-sm text-gray-500 mb-2">System Activity (Last 24h)</div>
          <ul class="space-y-2 text-sm">
            <li>📥 User "Manager1" uploaded 'Budget_Report.xlsx'</li>
            <li>✅ Director approved letter 'Partnership Agreement'</li>
            <li>⚠️ Unauthorized access attempt detected</li>
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
  labels: ['HR', 'Finance', 'IT', 'Legal', 'Sales'],
  datasets: [
    {
      label: 'Documents Processed',
      backgroundColor: '#3b82f6',
      borderRadius: 4,
      data: [180, 240, 320, 150, 200]
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
