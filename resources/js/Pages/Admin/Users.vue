<template>
  <main class="p-6 space-y-6">
    <h2 class="text-2xl font-semibold text-gray-700">👥 Manage Users</h2>
    <div class="bg-white p-4 shadow rounded">
      <table class="w-full text-left text-sm border">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 border">ID</th>
            <th class="p-2 border">Name</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Created At</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id" class="border-t">
            <td class="p-2 border">{{ user.id }}</td>
            <td class="p-2 border">{{ user.name }}</td>
            <td class="p-2 border">{{ user.email }}</td>
            <td class="p-2 border">{{ user.created_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
</template>

<script setup>
defineProps({ users: Array });
</script>
