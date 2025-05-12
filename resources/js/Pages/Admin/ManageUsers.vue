<template>
  <main class="p-6 space-y-6">
    <h2 class="text-2xl font-semibold text-gray-700">👥 Manage Users</h2>

    <div class="bg-white p-4 shadow rounded overflow-x-auto">
      <table class="w-full text-left text-sm border">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 border">Name</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Role</th>
            <th class="p-2 border">Created</th>
            <th class="p-2 border text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id" class="border-t">
            <td class="p-2 border">{{ user.name }}</td>
            <td class="p-2 border">{{ user.email }}</td>
            <td class="p-2 border">
              <select
                v-model="user.role"
                @change="updateRole(user)"
                class="border rounded px-2 py-1 text-sm"
              >
                <option value="admin">Admin</option>
                <option value="manager">Manager</option>
                <option value="employee">Employee</option>
              </select>
            </td>
            <td class="p-2 border">{{ user.created_at }}</td>
            <td class="p-2 border text-center">
              <button
                class="text-red-600 hover:underline text-sm"
                @click="deleteUser(user.id)"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="!users.length" class="text-center text-sm text-gray-500 mt-4">
        No users found.
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const users = ref([])

const fetchUsers = async () => {
  const res = await axios.get('/api/admin/users')
  users.value = res.data
}

const updateRole = async (user) => {
  await axios.put(`/api/admin/users/${user.id}`, {
    role: user.role
  })
}

const deleteUser = async (id) => {
  if (confirm('Are you sure you want to delete this user?')) {
    await axios.delete(`/api/admin/users/${id}`)
    fetchUsers()
  }
}

onMounted(() => {
  fetchUsers()
})
</script>
