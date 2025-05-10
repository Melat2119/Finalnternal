<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
const props = defineProps({ developer: Object });
</script>

<template>
  <AuthenticatedLayout>
    <div class="container py-5">
      <h2>Developer Details</h2>
      <div class="mt-4">
        <p><strong>Name:</strong> {{ developer.name }}</p>
        <p><strong>Email:</strong> {{ developer.email }}</p>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
