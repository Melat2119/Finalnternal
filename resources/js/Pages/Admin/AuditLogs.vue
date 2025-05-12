<template>
  <main class="p-6 space-y-6">
    <h2 class="text-2xl font-semibold text-gray-700">🔎 Audit Logs</h2>

    <!-- Filter (optional) -->
    <div class="bg-white p-4 shadow rounded flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <label class="text-sm text-gray-500 block mb-1">Filter by User</label>
        <input
          v-model="filterUser"
          type="text"
          placeholder="Search by username..."
          class="border px-3 py-2 rounded w-full md:w-64"
        />
      </div>
    </div>

    <!-- Logs Table -->
    <div class="bg-white p-4 shadow rounded">
      <h3 class="text-lg font-semibold mb-2">🗂️ System Activities</h3>
      <table class="w-full text-left text-sm border">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 border">User</th>
            <th class="p-2 border">Action</th>
            <th class="p-2 border">Description</th>
            <th class="p-2 border">Date</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="log in filteredLogs"
            :key="log.id"
            class="border-t"
          >
            <td class="p-2 border">{{ log.user }}</td>
            <td class="p-2 border font-semibold">{{ log.action }}</td>
            <td class="p-2 border text-gray-600">{{ log.description }}</td>
            <td class="p-2 border">{{ log.timestamp }}</td>
          </tr>
        </tbody>
      </table>

      <div v-if="!filteredLogs.length" class="text-center text-sm text-gray-500 mt-4">
        No logs found.
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const logs = ref([])
const filterUser = ref('')

onMounted(async () => {
  const response = await axios.get('/api/admin/audit-logs')
  logs.value = response.data
})

const filteredLogs = computed(() => {
  if (!filterUser.value) return logs.value
  return logs.value.filter(log =>
    log.user.toLowerCase().includes(filterUser.value.toLowerCase())
  )
})
</script>
