<template>
    <AuthenticatedLayout>
        <div
            v-if="['admin', 'manager'].includes(userRole)"
            class="container-fluid py-5"
        >
            <h1 class="text-center mb-4">Social Media Managers</h1>
            <div class="mb-4 text-end">
                <button class="btn btn-success px-4" @click="openCreate">
                    <i class="bi bi-plus-lg me-2"></i> Create New Manager
                </button>
            </div>
            <div class="documents-table table-responsive p-4">
                <table
                    class="table table-hover align-middle custom-table w-100 mb-0"
                >
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="!managers || managers.length === 0">
                            <td colspan="3" class="text-center text-muted">
                                No managers found.
                            </td>
                        </tr>
                        <tr v-for="manager in managers" :key="manager.id">
                            <td>
                                <div class="fw-semibold">
                                    {{ manager.name }}
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small">
                                    {{ manager.email }}
                                </div>
                            </td>
                            <td class="d-flex gap-2">
                                <button
                                    class="btn btn-sm btn-outline-primary"
                                    @click="viewManager(manager)"
                                >
                                    📄 View Documents
                                </button>
                                <button
                                    class="btn btn-sm btn-outline-success"
                                    @click="openEdit(manager)"
                                >
                                    ✏️ Edit
                                </button>
                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    @click="deleteManager(manager)"
                                >
                                    🗑️ Delete
                                </button>
                                <button
                                    class="btn btn-sm btn-outline-success"
                                    @click="uploadDocument(manager)"
                                >
                                    ⬆️ Upload
                                </button>
                                <button
                                    class="btn btn-sm btn-outline-warning"
                                    @click="openFeedback(manager)"
                                >
                                    💬 Feedback
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Create Modal -->
            <div v-if="showCreate" class="modal-backdrop">
                <div class="modal-box">
                    <h4>Create Manager</h4>
                    <form @submit.prevent="submitCreate">
                        <div class="mb-3">
                            <label>Name</label>
                            <input
                                v-model="createForm.name"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input
                                v-model="createForm.email"
                                type="email"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="d-flex gap-2">
                            <button
                                class="btn btn-success"
                                :disabled="createForm.processing"
                            >
                                Create
                            </button>
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="showCreate = false"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Modal -->
            <div v-if="showEdit" class="modal-backdrop">
                <div class="modal-box">
                    <h4>Edit Manager</h4>
                    <form @submit.prevent="submitEdit">
                        <div class="mb-3">
                            <label>Name</label>
                            <input
                                v-model="editForm.name"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input
                                v-model="editForm.email"
                                type="email"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="d-flex gap-2">
                            <button
                                class="btn btn-primary"
                                :disabled="editForm.processing"
                            >
                                Update
                            </button>
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="showEdit = false"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Feedback Modal -->
            <div v-if="showFeedback" class="modal-backdrop">
                <div class="modal-box">
                    <h4>Give Feedback to {{ selectedManager?.name }}</h4>
                    <form @submit.prevent="submitFeedback">
                        <div class="mb-3">
                            <label class="form-label">Feedback Message</label>
                            <textarea
                                v-model="feedbackForm.message"
                                class="form-control"
                                rows="4"
                                required
                            ></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button
                                class="btn btn-success"
                                :disabled="feedbackForm.processing"
                            >
                                Submit Feedback
                            </button>
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="showFeedback = false"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-else class="container-fluid py-5 text-center text-danger">
            You do not have permission to view this page.
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";

defineProps({
    managers: {
        type: Array,
        default: () => [],
    },
    userRole: {
        type: String,
        default: "",
    },
});

// Modal state
const showCreate = ref(false);
const showEdit = ref(false);
const showFeedback = ref(false);
const selectedManager = ref(null);

// Forms
const createForm = useForm({ name: "", email: "" });
const editForm = useForm({ id: null, name: "", email: "" });
const feedbackForm = useForm({ manager_id: null, message: "" });

// CRUD handlers
function openCreate() {
    createForm.reset();
    showCreate.value = true;
}
function submitCreate() {
    createForm.post(route("socialmedia.store"), {
        onSuccess: () => (showCreate.value = false),
    });
}

function openEdit(manager) {
    editForm.id = manager.id;
    editForm.name = manager.name;
    editForm.email = manager.email;
    showEdit.value = true;
}
function submitEdit() {
    editForm.put(route("socialmedia.update", editForm.id), {
        onSuccess: () => (showEdit.value = false),
    });
}

function openFeedback(manager) {
    feedbackForm.manager_id = manager.id;
    feedbackForm.message = "";
    selectedManager.value = manager;
    showFeedback.value = true;
}
function submitFeedback() {
    feedbackForm.post(route("feedback.store"), {
        onSuccess: () => (showFeedback.value = false),
    });
}

function deleteManager(manager) {
    if (confirm(`Are you sure you want to delete ${manager.name}?`)) {
        router.delete(route("socialmedia.destroy", manager.id));
    }
}
function viewManager(manager) {
    alert(`View manager: ${manager.name}`);
}
function uploadDocument(manager) {
    alert(`Upload document for: ${manager.name}`);
}
</script>

<style scoped>
.container-fluid {
    max-width: 100vw;
    padding-left: 2vw;
    padding-right: 2vw;
}
.documents-table {
    box-shadow: 0 4px 24px rgba(60, 72, 100, 0.12),
        0 1.5px 4px rgba(60, 72, 100, 0.08);
    border-radius: 18px;
    background: #fff;
}
.custom-table {
    min-width: 900px;
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 2px 16px rgba(60, 72, 100, 0.1);
}
.table th,
.table td {
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
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
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
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
}
</style>
