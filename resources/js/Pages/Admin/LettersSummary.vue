<template>
  <main class="p-6 space-y-6">
    <h2 class="text-2xl font-semibold text-gray-700">✉️ Letter Summary</h2>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white p-4 shadow rounded">
        <div class="text-sm text-gray-500">Total Letters</div>
        <div class="text-2xl font-bold">{{ stats.total }}</div>
      </div>
      <div class="bg-white p-4 shadow rounded">
        <div class="text-sm text-gray-500">Sent Letters</div>
        <div class="text-2xl font-bold">{{ stats.sent }}</div>
      </div>
      <div class="bg-white p-4 shadow rounded">
        <div class="text-sm text-gray-500">Received Letters</div>
        <div class="text-2xl font-bold">{{ stats.received }}</div>
      </div>
      <div class="bg-white p-4 shadow rounded">
        <div class="text-sm text-gray-500">Rejected Letters</div>
        <div class="text-2xl font-bold">{{ stats.rejected }}</div>
      </div>
    </div>

    <!-- Letters Table -->
    <div class="bg-white p-4 shadow rounded">
      <h3 class="text-lg font-semibold mb-2">📨 Recent Letters</h3>
      <table class="w-full text-left text-sm border">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 border">Subject</th>
            <th class="p-2 border">Sender</th>
            <th class="p-2 border">Receiver</th>
            <th class="p-2 border">Status</th>
            <th class="p-2 border">Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="letter in letters" :key="letter.id" class="border-t">
            <td class="p-2 border">{{ letter.subject }}</td>
            <td class="p-2 border">{{ letter.sender }}</td>
            <td class="p-2 border">{{ letter.receiver }}</td>
            <td class="p-2 border">
              <span
                :class="{
                  'text-green-600': letter.status === 'sent',
                  'text-blue-600': letter.status === 'received',
                  'text-red-600': letter.status === 'rejected'
                }"
              >
                {{ letter.status }}
              </span>
            </td>
            <td class="p-2 border">{{ letter.created_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const stats = ref({
  total: 0,
  sent: 0,
  received: 0,
  rejected: 0
})

const letters = ref([])

onMounted(async () => {
  const statsRes = await axios.get('/api/admin/letter-stats')
  stats.value = statsRes.data

  const listRes = await axios.get('/api/admin/letters')
  letters.value = listRes.data
})
</script>
