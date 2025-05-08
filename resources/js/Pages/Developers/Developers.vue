<template>
  <AuthenticatedLayout>
    <div class="container-fluid py-5 px-4">
      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        
        <button class="btn btn-success px-4" @click="createDocument">
          <i class="bi bi-plus-lg me-2"></i> Create New Document
        </button>
      </div>

      <!-- Table -->
      <div class="card border-0 shadow-sm rounded-4 overflow-auto">
        <table class="table table-bordered table-striped text-center align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="min-width: 200px;">Name</th>
              <th style="min-width: 250px;">Email</th>
              <th style="min-width: 300px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="contributor in developers" :key="contributor.id">
              <td class="fw-semibold text-dark">{{ contributor.name }}</td>
              <td class="text-muted">{{ contributor.email }}</td>
              <td>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                  <button class="btn btn-sm btn-outline-primary px-3" @click="viewDeveloper(contributor)">
                    <i class="bi bi-eye"></i> View
                  </button>
                  <button class="btn btn-sm btn-outline-success px-3" @click="uploadDocument(contributor)">
                    <i class="bi bi-upload"></i> Upload
                  </button>
                  <button class="btn btn-sm btn-outline-warning px-3" @click="giveFeedback(contributor)">
                    <i class="bi bi-chat-left-text"></i> Feedback
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
  developers: Array
});

function viewDeveloper(developer) {
  alert(`Viewing documents for: ${developer.name}`);
}
function uploadDocument(developer) {
  alert(`Uploading document for: ${developer.name}`);
}
function giveFeedback(developer) {
  alert(`Providing feedback for: ${developer.name}`);
}
function createDocument() {
  alert('Redirect to document creation page/form');
}
</script>

<style scoped>
.table {
  border-collapse: separate;
  border-spacing: 0;
  width: 100%;
}

.table th,
.table td {
  padding: 1rem;
  vertical-align: middle;
  border: 1px solid #dee2e6;
}

.card {
  border-radius: 1rem;
}

/* Make action icons light green */
.btn-outline-primary .bi,
.btn-outline-success .bi,
.btn-outline-warning .bi {
  color: #4ade80 !important; /* Tailwind's green-300, adjust as needed */
}

@media (max-width: 768px) {
  .table {
    font-size: 0.9rem;
  }
  .d-flex.gap-3 {
    flex-direction: column;
    align-items: center;
  }
}
</style>
