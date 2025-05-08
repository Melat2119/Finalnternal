<template>
  <AuthenticatedLayout>
    <div class="container-fluid py-5">
      <h1 class="text-center mb-4">Social Media Managers</h1>
      <div class="documents-table table-responsive p-4">
        <table class="table table-hover align-middle custom-table w-100 mb-0">
          <thead class="table-light">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="manager in managers" :key="manager.id">
              <td>
                <div class="fw-semibold">{{ manager.name }}</div>
              </td>
              <td>
                <div class="text-muted small">{{ manager.email }}</div>
              </td>
              <td class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary" @click="viewManager(manager)">
                  📄 View Documents
                </button>
                <button class="btn btn-sm btn-outline-success" @click="uploadDocument(manager)">
                  ⬆️ Upload
                </button>
                <button class="btn btn-sm btn-outline-warning" @click="giveFeedback(manager)">
                  💬 Feedback
                </button>
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

// Receive managers as a prop from the controller
defineProps({
  managers: Array
});

function viewManager(manager) {
  alert(`View manager: ${manager.name}`);
}
function uploadDocument(manager) {
  alert(`Upload document for: ${manager.name}`);
}
function giveFeedback(manager) {
  alert(`Give feedback for: ${manager.name}`);
}
</script>

<style scoped>
.container-fluid {
  max-width: 100vw;
  padding-left: 2vw;
  padding-right: 2vw;
}
.documents-table {
  box-shadow: 0 4px 24px rgba(60,72,100,0.12), 0 1.5px 4px rgba(60,72,100,0.08);
  border-radius: 18px;
  background: #fff;
}
.custom-table {
  min-width: 900px;
  border-radius: 18px;
  background: #fff;
  box-shadow: 0 2px 16px rgba(60,72,100,0.10);
}
.table th, .table td {
  vertical-align: middle !important;
  border-bottom: 1px solid #e9ecef;
  padding: 0.75rem 1rem;
}
.table thead th {
  border-top: none;
  font-size: 1.05rem;
  font-weight: 600;
  letter-spacing: 0.02em;
}
.table-hover tbody tr:hover {
  background: #f6fafd;
  transition: background 0.2s ease;
}
.btn {
  font-size: 0.875rem;
  padding: 0.4rem 0.75rem;
  border-radius: 6px;
}
@media (max-width: 767px) {
  .custom-table {
    min-width: 500px;
    font-size: 0.95rem;
  }
  .documents-table {
    border-radius: 10px;
  }
}
</style>
