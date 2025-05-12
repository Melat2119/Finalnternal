<template>
  <AuthenticatedLayout>
    <div class="container-fluid py-5">
      <h1 class="text-center mb-6 text-3xl font-bold text-gray-700">📄 Sales Documents</h1>

      <div class="mb-6 flex justify-between items-center">
        <input
          v-model="search"
          type="text"
          placeholder="Search by client or title..."
          class="border rounded px-4 py-2 w-full max-w-md shadow-sm"
        />
        <button class="btn btn-success px-4 ms-4" @click="openCreate">
          <i class="bi bi-plus-lg me-2"></i> Create New Sale
        </button>
      </div>

      <div class="bg-white shadow rounded p-4">
        <table class="table table-hover align-middle w-full text-sm">
          <thead class="table-light">
            <tr>
              <th>Client</th>
              <th>Title</th>
              <th>Status</th>
              <th>Date</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredSales.length === 0">
              <td colspan="5" class="text-center text-muted py-3">No sales documents found.</td>
            </tr>
            <tr v-for="sale in filteredSales" :key="sale.id">
              <td class="fw-semibold">{{ sale.client_name }}</td>
              <td>{{ sale.title }}</td>
              <td>
                <span :class="statusBadge(sale.status)">{{ sale.status }}</span>
              </td>
              <td>{{ formatDate(sale.created_at) }}</td>
              <td class="text-center">
                <div class="btn-group gap-2 flex flex-wrap justify-center">
                  <button class="btn btn-sm btn-outline-primary" @click="openView(sale)">📄</button>
                  <button class="btn btn-sm btn-outline-success" @click="triggerFileInput(sale)">⬆️</button>
                  <button class="btn btn-sm btn-outline-secondary" @click="openEdit(sale)">✏️ </button>
                  <button class="btn btn-sm btn-outline-danger" @click="openDelete(sale)">🗑️ </button>
                  <button class="btn btn-sm btn-outline-warning" @click="openFeedback(sale)">💬 </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <input
          ref="fileInput"
          type="file"
          class="hidden"
          @change="handleFileChange"
        />
      </div>

      <!-- Modal -->
      <div v-if="showView" class="modal-backdrop">
        <div class="modal-box">
          <h4>View Sale Document</h4>
          <div class="mb-3"><b>Client:</b> {{ selectedSale?.client_name }}</div>
          <div class="mb-3"><b>Title:</b> {{ selectedSale?.title }}</div>
          <div class="mb-3"><b>Status:</b> {{ selectedSale?.status }}</div>
          <div class="mb-3"><b>Date:</b> {{ selectedSale?.created_at }}</div>
          <button class="btn btn-secondary" @click="showView = false">Close</button>
        </div>
      </div>

      <!-- Create Modal -->
      <div v-if="showCreate" class="modal-backdrop">
        <div class="modal-box">
          <h4>Create Sale</h4>
          <form @submit.prevent="submitCreate">
            <div class="mb-3">
              <label>Client</label>
              <input v-model="createForm.client_name" class="form-control" required />
            </div>
            <div class="mb-3">
              <label>Title</label>
              <input v-model="createForm.title" class="form-control" required />
            </div>
            <div class="mb-3">
              <label>Status</label>
              <input v-model="createForm.status" class="form-control" required />
            </div>
            <div class="mb-3">
              <label>Date</label>
              <input v-model="createForm.created_at" class="form-control" required />
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
          <h4>Edit Sale</h4>
          <form @submit.prevent="submitEdit">
            <div class="mb-3">
              <label>Client</label>
              <input v-model="editForm.client_name" class="form-control" required />
            </div>
            <div class="mb-3">
              <label>Title</label>
              <input v-model="editForm.title" class="form-control" required />
            </div>
            <div class="mb-3">
              <label>Salesperson</label>
              <input v-model="editForm.salesperson" class="form-control" required />
            </div>
            <div class="mb-3">
              <label>Type</label>
              <input v-model="editForm.type" class="form-control" required />
            </div>
            <div class="mb-3">
              <label>Validity Period</label>
              <input v-model="editForm.validity_period" type="date" class="form-control" />
            </div>
            <div class="mb-3">
              <label>Status</label>
              <input v-model="editForm.status" class="form-control" required />
            </div>
            <div class="mb-3">
              <label>Date</label>
              <input v-model="editForm.created_at" class="form-control" required />
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary" :disabled="editForm.processing">Update</button>
              <button type="button" class="btn btn-secondary" @click="showEdit = false">Cancel</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Delete Modal -->
      <div v-if="showDelete" class="modal-backdrop">
        <div class="modal-box">
          <h4>Delete Sale</h4>
          <p>Are you sure you want to delete <b>{{ selectedSale?.title }}</b>?</p>
          <div class="d-flex gap-2 mt-3">
            <button class="btn btn-danger" @click="submitDelete">Yes, Delete</button>
            <button class="btn btn-secondary" @click="showDelete = false">Cancel</button>
          </div>
        </div>
      </div>

      <!-- Feedback Modal -->
      <div v-if="showFeedback" class="modal-backdrop">
        <div class="modal-box">
          <h4>Give Feedback to {{ selectedSale?.title }}</h4>
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
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';

const props = defineProps({
  sales: {
    type: Array,
    default: () => []
  }
})

console.log('Sales data from controller:', props.sales) // Debug: log sales data in browser

const search = ref('')
const showCreate = ref(false)
const showEdit = ref(false)
const showDelete = ref(false)
const showView = ref(false)
const showFeedback = ref(false)
const selectedSale = ref(null)

const createForm = useForm({ client_name: '', title: '', status: '', created_at: '' })
const editForm = useForm({
  id: null,
  client_name: '',
  title: '',
  salesperson: '',
  type: '',
  status: '',
  validity_period: '',
  created_at: ''
})
const feedbackForm = useForm({ sale_id: null, message: '' })

const filteredSales = computed(() => {
  return props.sales.filter(s =>
    (s.client_name && s.client_name.toLowerCase().includes(search.value.toLowerCase())) ||
    (s.title && s.title.toLowerCase().includes(search.value.toLowerCase()))
  )
})

function statusBadge(status) {
  switch (status) {
    case 'pending': return 'badge bg-warning text-dark';
    case 'approved': return 'badge bg-success';
    case 'rejected': return 'badge bg-danger';
    default: return 'badge bg-secondary';
  }
}

function formatDate(date) {
  if (!date) return '';
  return new Date(date).toLocaleDateString(undefined, {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
}

function openCreate() {
  createForm.reset()
  showCreate.value = true
}
function openEdit(sale) {
  editForm.id = sale.id
  editForm.client_name = sale.client_name
  editForm.title = sale.title
  editForm.salesperson = sale.salesperson
  editForm.type = sale.type
  editForm.status = sale.status
  editForm.validity_period = sale.validity_period
  editForm.created_at = sale.created_at
  showEdit.value = true
}
function openDelete(sale) {
  selectedSale.value = sale
  showDelete.value = true
}
function openView(sale) {
  selectedSale.value = sale
  showView.value = true
}
function openFeedback(sale) {
  feedbackForm.sale_id = sale.id
  feedbackForm.message = ''
  selectedSale.value = sale
  showFeedback.value = true
}
function submitCreate() {
  createForm.post(route('sales.store'), {
    onSuccess: () => showCreate.value = false
  })
}
function submitEdit() {
  editForm.put(route('sales.update', editForm.id), {
    onSuccess: () => {
      showEdit.value = false
    }
  })
}
function submitDelete() {
  router.delete(route('sales.destroy', selectedSale.value.id), {
    onSuccess: () => showDelete.value = false
  })
}
function submitFeedback() {
  feedbackForm.post(route('feedback.store'), {
    onSuccess: () => {
      showFeedback.value = false
      feedbackForm.reset()
    }
  })
}
const fileInput = ref(null)
const saleForUpload = ref(null)

function triggerFileInput(sale) {
  saleForUpload.value = sale
  if (fileInput.value) fileInput.value.value = null // reset file input
  fileInput.value && fileInput.value.click()
}

function handleFileChange(event) {
  const file = event.target.files[0]
  if (!file || !saleForUpload.value) return
  const form = new FormData()
  form.append('file', file)
  form.append('sale_id', saleForUpload.value.id)
  // Adjust the route and backend as needed:
  router.post(route('sales.upload', saleForUpload.value.id), form, {
    onSuccess: () => {
      saleForUpload.value = null
    }
  })
}
</script>

<style scoped>
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
.hidden {
  display: none;
}
</style>