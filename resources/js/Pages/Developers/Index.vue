<template>
    <AuthenticatedLayout>
        <div class="container-fluid py-5">
            <h1 class="fw-bold text-primary mb-4">Developers & Documents</h1>
            <div
                v-if="!developers || developers.length === 0"
                class="alert alert-info text-center"
            >
                No developers found.
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Documents</th>
                            <th>Upload Document</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="developer in developers" :key="developer.id">
                            <td>
                                <div class="fw-semibold">
                                    {{ developer.name }}
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small">
                                    {{ developer.email }}
                                </div>
                            </td>
                            <td>
                                <div
                                    v-if="
                                        developer.documents &&
                                        developer.documents.length
                                    "
                                >
                                    <table
                                        class="table table-sm table-bordered mb-0"
                                    >
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="doc in developer.documents"
                                                :key="doc.id"
                                            >
                                                <td>{{ doc.title }}</td>
                                                <td>
                                                    <button
                                                        class="btn btn-link p-0"
                                                        @click="
                                                            downloadDocument(
                                                                doc
                                                            )
                                                        "
                                                        :disabled="
                                                            !doc.file_path
                                                        "
                                                        title="Download"
                                                    >
                                                        <i
                                                            class="bi bi-download"
                                                        ></i>
                                                        <span
                                                            class="visually-hidden"
                                                            >Download</span
                                                        >
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                            <td>
                                <form
                                    v-if="uploadForms[developer.id]"
                                    @submit.prevent="submitUpload(developer.id)"
                                    class="d-flex flex-column gap-2"
                                >
                                    <input
                                        v-model="
                                            uploadForms[developer.id].title
                                        "
                                        class="form-control"
                                        placeholder="Document Title"
                                        required
                                    />
                                    <input
                                        type="file"
                                        class="form-control"
                                        @change="
                                            onFileChange($event, developer.id)
                                        "
                                        required
                                    />
                                    <button
                                        class="btn btn-outline-success"
                                        :disabled="
                                            uploadForms[developer.id].processing
                                        "
                                    >
                                        <span
                                            v-if="
                                                uploadForms[developer.id]
                                                    .processing
                                            "
                                        >
                                            <span
                                                class="spinner-border spinner-border-sm"
                                            ></span>
                                            Uploading...
                                        </span>
                                        <span v-else>Upload</span>
                                    </button>
                                    <div
                                        v-if="uploadForms[developer.id].success"
                                        class="text-success small"
                                    >
                                        Uploaded!
                                    </div>
                                </form>
                            </td>
                            <td>
                                <div class="btn-group gap-2 flex flex-wrap">
                                    <button
                                        class="btn btn-sm btn-outline-primary"
                                        @click="openEdit(developer)"
                                    >
                                        ✏️ Edit
                                    </button>
                                    <button
                                        class="btn btn-sm btn-outline-danger"
                                        @click="deleteDeveloper(developer)"
                                    >
                                        🗑️ Delete
                                    </button>
                                    <button
                                        class="btn btn-sm btn-outline-warning"
                                        @click="openFeedback(developer)"
                                    >
                                        💬 Feedback
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Create Modal -->
            <Modal :show="showCreate" @close="showCreate = false">
                <template #default>
                    <h4>Create Developer</h4>
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
                </template>
            </Modal>

            <!-- Edit Modal -->
            <Modal :show="showEdit" @close="showEdit = false">
                <template #default>
                    <h4>Edit Developer</h4>
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
                </template>
            </Modal>

            <!-- Feedback Modal -->
            <Modal :show="showFeedback" @close="showFeedback = false">
                <template #default>
                    <h4>Give Feedback to {{ selectedDeveloper?.name }}</h4>
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
                </template>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, reactive, watchEffect } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import { router, usePage, useForm } from "@inertiajs/vue3";

const developers = ref(usePage().props.developers);

const uploadForms = reactive({});
watchEffect(() => {
    developers.value.forEach((dev) => {
        if (!uploadForms[dev.id]) {
            uploadForms[dev.id] = reactive({
                title: "",
                file: null,
                processing: false,
                success: false,
            });
        }
    });
});

function onFileChange(event, developerId) {
    const file = event.target.files[0];
    uploadForms[developerId].file = file;
}
function submitUpload(developerId) {
    const form = uploadForms[developerId];
    form.processing = true;
    form.success = false;
    const formData = new FormData();
    formData.append("file", form.file);
    formData.append("title", form.title);
    router.post(route("developers.uploadDocument", developerId), formData, {
        forceFormData: true,
        onSuccess: () => {
            form.processing = false;
            form.success = true;
            setTimeout(() => (form.success = false), 2000);
            form.title = "";
            form.file = null;
            window.location.reload();
        },
        onError: () => {
            form.processing = false;
        },
    });
}

function downloadDocument(doc) {
    if (doc.file_path) {
        window.open(doc.file_path, "_blank");
    }
}

// --- Create/Edit/Feedback Modal Logic ---
const showCreate = ref(false);
const showEdit = ref(false);
const showFeedback = ref(false);
const selectedDeveloper = ref(null);

const createForm = useForm({ name: "", email: "" });
const editForm = useForm({ id: null, name: "", email: "" });
const feedbackForm = useForm({ developer_id: null, message: "" });

function openCreate() {
    createForm.reset();
    showCreate.value = true;
}
function submitCreate() {
    createForm.post(route("developers.store"), {
        onSuccess: () => (showCreate.value = false),
    });
}

function openEdit(developer) {
    editForm.id = developer.id;
    editForm.name = developer.name;
    editForm.email = developer.email;
    showEdit.value = true;
}
function submitEdit() {
    editForm.put(route("developers.update", editForm.id), {
        onSuccess: () => (showEdit.value = false),
    });
}

function deleteDeveloper(developer) {
    if (confirm(`Delete developer "${developer.name}"?`)) {
        router.delete(route("developers.destroy", developer.id), {
            onSuccess: () => {
                // Optionally refresh or update developers list
            },
        });
    }
}

function openFeedback(developer) {
    feedbackForm.developer_id = developer.id;
    feedbackForm.message = "";
    selectedDeveloper.value = developer;
    showFeedback.value = true;
}
function submitFeedback() {
    feedbackForm.post(route("feedback.store"), {
        onSuccess: () => {
            showFeedback.value = false;
            feedbackForm.reset();
        },
    });
}
</script>

<style scoped>
.table {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(60, 72, 100, 0.12),
        0 1.5px 4px rgba(60, 72, 100, 0.08);
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
