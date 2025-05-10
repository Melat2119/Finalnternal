<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  developer: {
    type: Object,
    default: null
  }
});

const form = useForm({
  developer_id: props.developer ? props.developer.id : null,
  message: '',
});

function submit() {
  form.post(route('feedback.store'));
}
</script>

<template>
  <AuthenticatedLayout>
    <div class="container py-5">
      <h2>
        Give Feedback
        <span v-if="developer"> to {{ developer.name }}</span>
      </h2>
      <form @submit.prevent="submit" class="mt-4">
        <div class="mb-3">
          <label class="form-label">Feedback Message</label>
          <textarea v-model="form.message" class="form-control" rows="4" required></textarea>
        </div>
        <button class="btn btn-success" :disabled="form.processing">Submit Feedback</button>
      </form>
    </div>
  </AuthenticatedLayout>
</template>
