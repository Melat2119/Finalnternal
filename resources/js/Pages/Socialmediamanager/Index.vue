<template>
  <AuthenticatedLayout>
    <div class="container-fluid py-5">
      <h1 class="text-center mb-4">Social Media Managers</h1>
      <div class="documents-table table-responsive">
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
              <td>
                <button class="btn btn-sm btn-primary me-1" @click="viewManager(manager)">View</button>
                <button class="btn btn-sm btn-success me-1" @click="uploadDocument(manager)">Upload</button>
                <button class="btn btn-sm btn-warning" @click="giveFeedback(manager)">Feedback</button>
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
  box-shadow: 0 4px 24px 0 rgba(60,72,100,.12), 0 1.5px 4px 0 rgba(60,72,100,.08);
  border-radius: 18px;
  background: #fff;
  padding: 0;
}
.custom-table {
  min-width: 900px;
  border-radius: 18px;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 2px 16px 0 rgba(60,72,100,.10);
}
.table th, .table td {
  vertical-align: middle !important;
  border-bottom: 1px solid #e9ecef;
}
.table thead th {
  border-top: none;
  font-size: 1.05rem;
  background: #f8f9fa;
  font-weight: 600;
  letter-spacing: 0.02em;
}
.table-hover tbody tr:hover {
  background: #f6fafd;
  transition: background 0.2s;
}
.badge {
  font-size: 0.95em;
  padding: 0.5em 1em;
  border-radius: 1em;
  font-weight: 500;
}
.bg-success-subtle {
  background: #e9fbe8;
  color: #3bb77e !important;
}
.bg-secondary-subtle {
  background: #f1f1f1;
  color: #888 !important;
}
.bg-primary-subtle {
  background: #e7f1ff;
  color: #0d6efd !important;
}
.bg-purple-subtle {
  background: #f6e6ff;
  color: #b36ff6 !important;
}
input[type="checkbox"] {
  width: 1.1em;
  height: 1.1em;
}
@media (max-width: 991px) {
  .custom-table {
    min-width: 700px;
  }
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
