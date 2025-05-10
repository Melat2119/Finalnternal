<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
  name: '',
  email: '',
});

function submit() {
  form.post(route('developers.store'));
}
</script>

<template>
  <AuthenticatedLayout>
    <div class="container py-5">
      <h2>Create Developer</h2>
      <form @submit.prevent="submit" class="mt-4">
        <div class="mb-3">
          <label>Name</label>
          <input v-model="form.name" class="form-control" required />
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input v-model="form.email" type="email" class="form-control" required />
        </div>
        <button class="btn btn-success" :disabled="form.processing">Create</button>
      </form>
    </div>
  </AuthenticatedLayout>
</template>
