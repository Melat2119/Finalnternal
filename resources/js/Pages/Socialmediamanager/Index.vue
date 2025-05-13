<template>
    <AuthenticatedLayout>
        <div class="container-fluid py-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fw-bold text-primary">Social Media Managers</h1>
                <button class="btn btn-success px-4" @click="openCreate">
                    <i class="bi bi-plus-lg me-2"></i> Create New Manager
                </button>
            </div>
            <div
                v-if="!managers || managers.length === 0"
                class="alert alert-info text-center"
            >
                No managers found.
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Documents</th>
                            <th>Upload Document</th>
                            <th>Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
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
                            <td>
                                <div
                                    v-if="
                                        manager.documents &&
                                        manager.documents.length
                                    "
                                >
                                    <table
                                        class="table table-sm table-bordered mb-0"
                                    >
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>File</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="doc in manager.documents"
                                                :key="doc.id"
                                            >
                                                <td>{{ doc.title }}</td>
                                                <td>
                                                    <a
                                                        :href="doc.file_path"
                                                        target="_blank"
                                                        class="link-primary"
                                                        >Download</a
                                                    >
                                                </td>
                                                <td>
                                                    <button
                                                        class="btn btn-sm btn-outline-primary me-1"
                                                        @click="
                                                            viewDocument(doc)
                                                        "
                                                    >
                                                        <i
                                                            class="bi bi-eye"
                                                        ></i>
                                                    </button>
                                                    <button
                                                        class="btn btn-sm btn-outline-secondary me-1"
                                                        @click="
                                                            editDocument(doc)
                                                        "
                                                    >
                                                        <i
                                                            class="bi bi-pencil"
                                                        ></i>
                                                    </button>
                                                    <button
                                                        class="btn btn-sm btn-outline-danger"
                                                        @click="
                                                            deleteDocument(
                                                                doc,
                                                                manager.id
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="bi bi-trash"
                                                        ></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-else class="text-muted small">
                                    No documents
                                </div>
                            </td>
                            <td>
                                <form
                                    v-if="uploadForms[manager.id]"
                                    @submit.prevent="submitUpload(manager.id)"
                                    class="d-flex flex-column gap-2"
                                >
                                    <input
                                        v-model="uploadForms[manager.id].title"
                                        class="form-control"
                                        placeholder="Document Title"
                                        required
                                    />
                                    <input
                                        type="file"
                                        class="form-control"
                                        @change="
                                            onFileChange($event, manager.id)
                                        "
                                        required
                                    />
                                    <button
                                        class="btn btn-outline-success"
                                        :disabled="
                                            uploadForms[manager.id].processing
                                        "
                                    >
                                        <span
                                            v-if="
                                                uploadForms[manager.id]
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
                                        v-if="uploadForms[manager.id].success"
                                        class="text-success small"
                                    >
                                        Uploaded!
                                    </div>
                                </form>
                            </td>
                            <td>
                                <form
                                    v-if="feedbackForms[manager.id]"
                                    @submit.prevent="submitFeedback(manager.id)"
                                    class="d-flex flex-column gap-2"
                                >
                                    <textarea
                                        v-model="
                                            feedbackForms[manager.id].message
                                        "
                                        class="form-control"
                                        rows="2"
                                        placeholder="Write feedback..."
                                        required
                                    ></textarea>
                                    <button
                                        class="btn btn-outline-warning"
                                        :disabled="
                                            feedbackForms[manager.id].processing
                                        "
                                    >
                                        <span
                                            v-if="
                                                feedbackForms[manager.id]
                                                    .processing
                                            "
                                        >
                                            <span
                                                class="spinner-border spinner-border-sm"
                                            ></span>
                                            Sending...
                                        </span>
                                        <span v-else>Submit Feedback</span>
                                    </button>
                                    <div
                                        v-if="feedbackForms[manager.id].success"
                                        class="text-success small"
                                    >
                                        Sent!
                                    </div>
                                </form>
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
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, reactive, watchEffect } from "vue";
import { useForm, router } from "@inertiajs/vue3";

const props = defineProps({
    managers: {
        type: Array,
        default: () => [],
    },
});

const showCreate = ref(false);
const createForm = useForm({ name: "", email: "" });

function openCreate() {
    createForm.reset();
    showCreate.value = true;
}
function submitCreate() {
    createForm.post(route("socialmedia.store"), {
        onSuccess: () => (showCreate.value = false),
    });
}

// --- Upload Document Logic ---
const uploadForms = reactive({});
const feedbackForms = reactive({});

watchEffect(() => {
    props.managers.forEach((manager) => {
        if (!uploadForms[manager.id]) {
            uploadForms[manager.id] = reactive({
                title: "",
                file: null,
                processing: false,
                success: false,
            });
        }
        if (!feedbackForms[manager.id]) {
            feedbackForms[manager.id] = reactive({
                message: "",
                processing: false,
                success: false,
            });
        }
    });
});

function onFileChange(event, managerId) {
    const file = event.target.files[0];
    uploadForms[managerId].file = file;
}
function submitUpload(managerId) {
    const form = uploadForms[managerId];
    form.processing = true;
    form.success = false;
    const formData = new FormData();
    formData.append("file", form.file);
    formData.append("title", form.title);
    formData.append("manager_id", managerId);
    router.post(route("socialmedia.upload", managerId), formData, {
        forceFormData: true,
        onSuccess: () => {
            form.processing = false;
            form.success = true;
            setTimeout(() => (form.success = false), 2000);
            form.title = "";
            form.file = null;
        },
        onError: () => {
            form.processing = false;
        },
    });
}

// --- Feedback Logic ---
function submitFeedback(managerId) {
    const form = feedbackForms[managerId];
    form.processing = true;
    form.success = false;
    router.post(
        route("feedback.store"),
        {
            manager_id: managerId,
            message: form.message,
        },
        {
            onSuccess: () => {
                form.processing = false;
                form.success = true;
                setTimeout(() => (form.success = false), 2000);
                form.message = "";
            },
            onError: () => {
                form.processing = false;
            },
        }
    );
}

// --- Document CRUD handlers (stubs, implement as needed) ---
function viewDocument(doc) {
    alert(`View document: ${doc.title}`);
}
function editDocument(doc) {
    alert(`Edit document: ${doc.title}`);
}
function deleteDocument(doc, managerId) {
    if (confirm(`Delete document "${doc.title}"?`)) {
        router.delete(
            route("socialmedia.document.destroy", [managerId, doc.id]),
            {
                onSuccess: () => {
                    // Optionally refresh or update manager documents
                },
            }
        );
    }
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
