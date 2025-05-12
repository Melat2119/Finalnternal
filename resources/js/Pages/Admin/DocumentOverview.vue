<template>
  <main class="p-6 space-y-6">
    <h2 class="text-2xl font-semibold text-gray-700">📁 Document Overview</h2>
    
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white p-4 shadow rounded">
        <div class="text-sm text-gray-500">Total Documents</div>
        <div class="text-2xl font-bold">{{ stats.total }}</div>
      </div>
      <div class="bg-white p-4 shadow rounded">
        <div class="text-sm text-gray-500">Approved Documents</div>
        <div class="text-2xl font-bold">{{ stats.approved }}</div>
      </div>
      <div class="bg-white p-4 shadow rounded">
        <div class="text-sm text-gray-500">Pending Documents</div>
        <div class="text-2xl font-bold">{{ stats.pending }}</div>
      </div>
      <div class="bg-white p-4 shadow rounded">
        <div class="text-sm text-gray-500">Rejected Documents</div>
        <div class="text-2xl font-bold">{{ stats.rejected }}</div>
      </div>
    </div>

    <!-- Document Table -->
    <div class="bg-white p-4 shadow rounded">
      <h3 class="text-lg font-semibold mb-2">📄 Document List</h3>
      <table class="w-full text-left text-sm border">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 border">Title</th>
            <th class="p-2 border">Department</th>
            <th class="p-2 border">Uploaded By</th>
            <th class="p-2 border">Status</th>
            <th class="p-2 border">Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="doc in documents" :key="doc.id" class="border-t">
            <td class="p-2 border">{{ doc.title }}</td>
            <td class="p-2 border">{{ doc.department }}</td>
            <td class="p-2 border">{{ doc.uploaded_by }}</td>
            <td class="p-2 border">
              <span
                :class="{
                  'text-green-600': doc.status === 'approved',
                  'text-yellow-600': doc.status === 'pending',
                  'text-red-600': doc.status === 'rejected'
                }"
              >
                {{ doc.status }}
              </span>
            </td>
            <td class="p-2 border">{{ doc.created_at }}</td>
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
  approved: 0,
  pending: 0,
  rejected: 0
})

const documents = ref([])

onMounted(async () => {
  const statsResponse = await axios.get('/api/admin/stats')
  stats.value.total = statsResponse.data.total_documents
  stats.value.approved = statsResponse.data.approved_documents
  stats.value.pending = statsResponse.data.pending_documents
  stats.value.rejected = statsResponse.data.rejected_documents

  const docResponse = await axios.get('/api/admin/documents')
  documents.value = docResponse.data
})
</script>