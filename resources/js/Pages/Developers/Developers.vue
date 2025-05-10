<template>
  <AuthenticatedLayout>
    <div class="container-fluid py-5 px-4">
      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <button class="btn btn-success px-4" @click="openCreate">
          <i class="bi bi-plus-lg me-2"></i> Create New Developer
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
            <tr v-for="developer in developers" :key="developer.id">
              <td class="fw-semibold text-dark">{{ developer.name }}</td>
              <td class="text-muted">{{ developer.email }}</td>
              <td>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                  <button class="btn btn-sm btn-outline-primary px-3" @click="viewDeveloper(developer)">
                    <i class="bi bi-eye"></i> View
                  </button>
                  <button class="btn btn-sm btn-outline-success px-3" @click="openEdit(developer)">
                    <i class="bi bi-pencil"></i> Edit
                  </button>
                  <button class="btn btn-sm btn-outline-danger px-3" @click="deleteDeveloper(developer)">
                    <i class="bi bi-trash"></i> Delete
                  </button>
                  <button class="btn btn-sm btn-outline-success px-3" @click="uploadDocument(developer)">
                    <i class="bi bi-upload"></i> Upload
                  </button>
                  <button class="btn btn-sm btn-outline-warning px-3" @click="openFeedback(developer)">
                    <i class="bi bi-chat-left-text"></i> Feedback
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Create Modal -->
      <div v-if="showCreate" class="modal-backdrop">
        <div class="modal-box">
          <h4>Create Developer</h4>
          <form @submit.prevent="submitCreate">
            <div class="mb-3">
              <label>Name</label>
              <input v-model="createForm.name" class="form-control" required />
            </div>
            <div class="mb-3">
              <label>Email</label>
              <input v-model="createForm.email" type="email" class="form-control" required />
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-success" :disabled="createForm.processing">Create</button>
              <button type="button" class="btn btn-secondary" @click="showCreate = false">Cancel</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Edit Modal -->
      <div v-if="showEdit" class="modal-backdrop">
        <div class="modal-box">
          <h4>Edit Developer</h4>
          <form @submit.prevent="submitEdit">
            <div class="mb-3">
              <label>Name</label>
              <input v-model="editForm.name" class="form-control" required />
            </div>
            <div class="mb-3">
              <label>Email</label>
              <input v-model="editForm.email" type="email" class="form-control" required />
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary" :disabled="editForm.processing">Update</button>
              <button type="button" class="btn btn-secondary" @click="showEdit = false">Cancel</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Feedback Modal -->
      <div v-if="showFeedback" class="modal-backdrop">
        <div class="modal-box">
          <h4>Give Feedback to {{ selectedDeveloper?.name }}</h4>
          <form @submit.prevent="submitFeedback">
            <div class="mb-3">
              <label class="form-label">Feedback Message</label>
              <textarea v-model="feedbackForm.message" class="form-control" rows="4" required></textarea>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-success" :disabled="feedbackForm.processing">Submit Feedback</button>
              <button type="button" class="btn btn-secondary" @click="showFeedback = false">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';

defineProps({
  developers: Array
});

// Modal state
const showCreate = ref(false);
const showEdit = ref(false);
const showFeedback = ref(false);
const selectedDeveloper = ref(null);

// Forms
const createForm = useForm({ name: '', email: '' });
const editForm = useForm({ id: null, name: '', email: '' });
const feedbackForm = useForm({ developer_id: null, message: '' });

// CRUD handlers
function openCreate() {
  createForm.reset();
  showCreate.value = true;
}
function submitCreate() {
  createForm.post(route('developers.store'), {
    onSuccess: () => showCreate.value = false
  });
}

function openEdit(developer) {
  editForm.id = developer.id;
  editForm.name = developer.name;
  editForm.email = developer.email;
  showEdit.value = true;
}
function submitEdit() {
  editForm.put(route('developers.update', editForm.id), {
    onSuccess: () => showEdit.value = false
  });
}

function openFeedback(developer) {
  feedbackForm.developer_id = developer.id;
  feedbackForm.message = '';
  selectedDeveloper.value = developer;
  showFeedback.value = true;
}
function submitFeedback() {
  feedbackForm.post(route('feedback.store'), {
    onSuccess: () => showFeedback.value = false
  });
}

function deleteDeveloper(developer) {
  if (confirm(`Are you sure you want to delete ${developer.name}?`)) {
    router.delete(route('developers.destroy', developer.id));
  }
}
function viewDeveloper(developer) {
  // Optionally show a modal or details inline
  alert(`Developer: ${developer.name}\nEmail: ${developer.email}`);
}
function uploadDocument(developer) {
  // Implement as needed
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
  color: #4ade80 !important;
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

/* Modal styles */
.modal-backdrop {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.3);
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-box {
  background: #fff;
  border-radius: 1rem;
  padding: 2rem;
  min-width: 320px;
  max-width: 90vw;
  box-shadow: 0 8px 32px rgba(0,0,0,0.15);
}
</style>
