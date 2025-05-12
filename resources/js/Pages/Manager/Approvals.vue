<template>
  <main class="p-6 space-y-6">
    <h2 class="text-2xl font-semibold">🔁 Approval Requests</h2>
    <div class="bg-white p-4 shadow rounded">
      <table class="w-full text-sm border">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 border">Document</th>
            <th class="p-2 border">Requested By</th>
            <th class="p-2 border">Status</th>
            <th class="p-2 border">Date</th>
            <th class="p-2 border text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="approval in approvals" :key="approval.id" class="border-t">
            <td class="p-2 border">{{ approval.document?.name ?? approval.document_title }}</td>
            <td class="p-2 border">{{ approval.requested_by ? approval.requestedBy?.name : approval.requested_by }}</td>
            <td class="p-2 border">{{ approval.status }}</td>
            <td class="p-2 border">{{ approval.created_at }}</td>
            <td class="p-2 border text-center space-x-2">
              <button class="px-2 py-1 bg-green-500 text-white rounded text-sm" @click="approve(approval.id)">Approve</button>
              <button class="px-2 py-1 bg-red-500 text-white rounded text-sm" @click="reject(approval.id)">Reject</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
const props = defineProps({ approvals: Array })

function approve(id) {
  router.post(route('manager.approvals.approve', id))
}
function reject(id) {
  router.post(route('manager.approvals.reject', id))
}
</script>