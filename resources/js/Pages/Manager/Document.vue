<template>
  <main class="p-6 space-y-6">
    <h2 class="text-2xl font-semibold">📄 All Documents</h2>
    <div class="bg-white p-4 shadow rounded">
      <input type="text" v-model="search" placeholder="Search documents..." class="border px-4 py-2 rounded w-full mb-4" />
      <table class="w-full text-sm border">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 border">Title</th>
            <th class="p-2 border">Department</th>
            <th class="p-2 border">Status</th>
            <th class="p-2 border">Uploaded</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="doc in filteredDocs" :key="doc.id" class="border-t">
            <td class="p-2 border">{{ doc.title }}</td>
            <td class="p-2 border">{{ doc.department }}</td>
            <td class="p-2 border">{{ doc.status }}</td>
            <td class="p-2 border">{{ doc.created_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
</template>

<script setup>
import { ref, computed } from 'vue'
const props = defineProps({ documents: Array })
const search = ref('')

const filteredDocs = computed(() => {
  return props.documents.filter(doc =>
    doc.title.toLowerCase().includes(search.value.toLowerCase())
  )
})
</script>