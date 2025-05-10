<template>
    <div>
        <!-- ...existing code... -->
        <div v-if="user && user.roles.includes('admin')">
            <p>Admin-only content</p>
        </div>
        <div v-if="user && user.permissions.includes('edit articles')">
            <p>You can edit articles.</p>
        </div>
        <!-- ...existing code... -->
    </div>
</template>

<script setup>
// ...existing code...
// Assume 'user' is provided as a prop or from a global store and contains 'roles' and 'permissions' arrays
</script>
