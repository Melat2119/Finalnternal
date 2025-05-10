<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({ developer: Object });

const form = useForm({
  name: props.developer.name,
  email: props.developer.email,
});

function submit() {
  form.put(route('developers.update', props.developer.id));
}
</script>

<template>
  <AuthenticatedLayout>
    <div class="container py-5">
      <h2>Edit Developer</h2>
      <form @submit.prevent="submit" class="mt-4">
        <div class="mb-3">
          <label>Name</label>
          <input v-model="form.name" class="form-control" required />
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input v-model="form.email" type="email" class="form-control" required />
        </div>
        <button class="btn btn-primary" :disabled="form.processing">Update</button>
      </form>
    </div>
  </AuthenticatedLayout>
</template>
