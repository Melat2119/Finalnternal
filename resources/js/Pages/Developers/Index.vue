<template>
    <!-- <AuthenticatedLayout> -->
    <div class="container-fluid py-5 main-bg">
        <div class="dev-card mx-auto">
            <h1 class="fw-bold text-primary mb-4 text-center">
                Developers & Documents
            </h1>
            <div
                v-if="!developers || developers.length === 0"
                class="alert alert-info text-center"
            >
                No developers found.
            </div>
            <div class="main-table-responsive">
                <table class="table table-bordered align-middle mb-0 dev-table">
                    <thead class="table-light">
                        <tr>
                            <!-- Removed Name and Email columns -->
                            <th>Documents</th>
                            <th>Upload Document</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="developer in developers" :key="developer.id">
                            <!-- Removed Name and Email cells -->
                            <td style="min-width: 350px">
                                <div
                                    v-if="
                                        developer.documents &&
                                        developer.documents.length
                                    "
                                    class="docs-table-responsive"
                                >
                                    <table
                                        class="table table-sm table-bordered mb-0 docs-table"
                                    >
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Department</th>
                                                <th>Type</th>
                                                <th>File</th>
                                                <th>Uploaded By</th>
                                                <th>Status</th>
                                                <th>Approval Comment</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="doc in developer.documents"
                                                :key="
                                                    doc.id + '-' + developer.id
                                                "
                                            >
                                                <td>{{ doc.title }}</td>
                                                <td>
                                                    {{ doc.department }}
                                                </td>
                                                <td>{{ doc.type }}</td>
                                                <td>
                                                    <a
                                                        v-if="doc.file_path"
                                                        :href="
                                                            route(
                                                                'documents.download',
                                                                doc.id
                                                            )
                                                        "
                                                        class="btn btn-link p-0"
                                                        title="Download"
                                                    >
                                                        <i
                                                            class="bi bi-download"
                                                        ></i>
                                                        <span
                                                            class="visually-hidden"
                                                            >Download</span
                                                        >
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ doc.uploaded_by }}
                                                </td>
                                                <td>
                                                    <span
                                                        :class="{
                                                            'badge bg-success':
                                                                doc.status ===
                                                                'approved',
                                                            'badge bg-warning text-dark':
                                                                doc.status ===
                                                                'pending',
                                                            'badge bg-danger':
                                                                doc.status ===
                                                                'rejected',
                                                        }"
                                                    >
                                                        {{ doc.status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        :class="{
                                                            'text-success':
                                                                doc.approval_comment,
                                                            'text-muted':
                                                                !doc.approval_comment,
                                                        }"
                                                    >
                                                        {{
                                                            doc.approval_comment ||
                                                            "—"
                                                        }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button
                                                        class="btn btn-sm btn-outline-primary"
                                                        @click="
                                                            openEditDoc(doc)
                                                        "
                                                    >
                                                        ✏️
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                            <td style="min-width: 220px">
                                <form
                                    v-if="uploadForms[developer.id]"
                                    @submit.prevent="submitUpload(developer.id)"
                                    class="upload-form shadow-sm rounded p-2 bg-light"
                                >
                                    <input
                                        v-model="
                                            uploadForms[developer.id].title
                                        "
                                        class="form-control mb-1"
                                        placeholder="Document Title"
                                        required
                                    />
                                    <input
                                        v-model="
                                            uploadForms[developer.id].department
                                        "
                                        class="form-control mb-1"
                                        placeholder="Department"
                                    />
                                    <input
                                        v-model="uploadForms[developer.id].type"
                                        class="form-control mb-1"
                                        placeholder="Type"
                                    />
                                    <input
                                        type="file"
                                        class="form-control mb-1"
                                        @change="
                                            onFileChange($event, developer.id)
                                        "
                                        required
                                    />
                                    <button
                                        class="btn btn-outline-success w-100"
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
                                        class="text-success small text-center mt-1"
                                    >
                                        Uploaded!
                                    </div>
                                </form>
                            </td>
                            <td style="min-width: 160px">
                                <div
                                    class="btn-group gap-2 flex flex-col flex-wrap justify-content-center"
                                >
                                    <button
                                        class="btn btn-sm btn-outline-primary"
                                        @click="openEdit(developer)"
                                    >
                                        ✏️
                                    </button>
                                    <button
                                        class="btn btn-sm btn-outline-danger"
                                        @click="deleteDeveloper(developer)"
                                    >
                                        🗑️
                                    </button>
                                    <button
                                        class="btn btn-sm btn-outline-warning"
                                        @click="openFeedback(developer)"
                                    >
                                        💬
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
                        <div
                            v-if="
                                editForm.documents && editForm.documents.length
                            "
                            class="mb-3"
                        >
                            <label class="fw-bold mb-2">Documents</label>
                            <div
                                v-for="doc in editForm.documents"
                                :key="doc.id"
                                class="border rounded p-2 mb-2 bg-light"
                            >
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="small">Title</label>
                                        <input
                                            v-model="doc.title"
                                            class="form-control form-control-sm"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Department</label>
                                        <input
                                            v-model="doc.department"
                                            class="form-control form-control-sm"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Type</label>
                                        <input
                                            v-model="doc.type"
                                            class="form-control form-control-sm"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Uploaded By</label>
                                        <input
                                            v-model="doc.uploaded_by"
                                            class="form-control form-control-sm"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Status</label>
                                        <input
                                            v-model="doc.status"
                                            class="form-control form-control-sm"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small"
                                            >Approval Comment</label
                                        >
                                        <input
                                            v-model="doc.approval_comment"
                                            class="form-control form-control-sm"
                                        />
                                    </div>
                                </div>
                                <div class="mt-2 text-end">
                                    <button
                                        class="btn btn-sm btn-outline-primary"
                                        type="button"
                                        @click="submitEditDocument(doc)"
                                        :disabled="doc.processing"
                                    >
                                        <span v-if="doc.processing">
                                            <span
                                                class="spinner-border spinner-border-sm"
                                            ></span>
                                            Saving...
                                        </span>
                                        <span v-else>Save Document</span>
                                    </button>
                                    <span
                                        v-if="doc.success"
                                        class="text-success ms-2"
                                        >Saved!</span
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button
                                class="btn btn-primary"
                                :disabled="editForm.processing"
                            >
                                Update Developer
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
                        <div v-if="feedbackSuccess" class="text-success mt-2">
                            Feedback submitted!
                        </div>
                    </form>
                </template>
            </Modal>

            <!-- Edit Document Modal -->
            <Modal :show="showEditDoc" @close="showEditDoc = false">
                <template #default>
                    <h4>Edit Document</h4>
                    <form @submit.prevent="submitEditDocument">
                        <div class="mb-2">
                            <label class="small">Title</label>
                            <input
                                v-model="editDocForm.title"
                                class="form-control"
                            />
                        </div>
                        <div class="mb-2">
                            <label class="small">Department</label>
                            <input
                                v-model="editDocForm.department"
                                class="form-control"
                            />
                        </div>
                        <div class="mb-2">
                            <label class="small">Type</label>
                            <input
                                v-model="editDocForm.type"
                                class="form-control"
                            />
                        </div>
                        <div class="mb-2">
                            <label class="small">Uploaded By</label>
                            <input
                                v-model="editDocForm.uploaded_by"
                                class="form-control"
                            />
                        </div>
                        <div class="mb-2">
                            <label class="small">Status</label>
                            <input
                                v-model="editDocForm.status"
                                class="form-control"
                            />
                        </div>
                        <div class="mb-2">
                            <label class="small">Approval Comment</label>
                            <input
                                v-model="editDocForm.approval_comment"
                                class="form-control"
                            />
                        </div>
                        <div class="mb-2">
                            <label class="small">Approved By</label>
                            <input
                                v-model="editDocForm.approved_by"
                                class="form-control"
                            />
                        </div>
                        <div class="d-flex gap-2 mt-2">
                            <button
                                class="btn btn-primary"
                                :disabled="editDocForm.processing"
                            >
                                <span v-if="editDocForm.processing">
                                    <span
                                        class="spinner-border spinner-border-sm"
                                    ></span>
                                    Saving...
                                </span>
                                <span v-else>Save</span>
                            </button>
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="showEditDoc = false"
                            >
                                Cancel
                            </button>
                            <span
                                v-if="editDocForm.success"
                                class="text-success ms-2"
                                >Saved!</span
                            >
                        </div>
                    </form>
                </template>
            </Modal>
        </div>
    </div>
    <!-- </AuthenticatedLayout> -->
</template>

<script setup>
import { ref, reactive, watchEffect } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import { router, usePage, useForm } from "@inertiajs/vue3";

const developers = ref(usePage().props.developers);

// Add this to debug the data coming from backend
console.log("Developers from backend:", developers.value);
developers.value.forEach((dev) => {
    console.log(`Documents for developer ${dev.name}:`, dev.documents);
});

const uploadForms = reactive({});
watchEffect(() => {
    developers.value.forEach((dev) => {
        if (!uploadForms[dev.id]) {
            uploadForms[dev.id] = reactive({
                title: "",
                department: "",
                type: "",
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
    formData.append("department", form.department);
    formData.append("type", form.type);
    router.post(route("developers.uploadDocument", developerId), formData, {
        forceFormData: true,
        onSuccess: () => {
            form.processing = false;
            form.success = true;
            setTimeout(() => (form.success = false), 2000);
            form.title = "";
            form.department = "";
            form.type = "";
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
const editForm = useForm({ id: null, name: "", email: "", documents: [] });
const feedbackForm = useForm({ developer_id: null, message: "" });
const feedbackSuccess = ref(false);

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
    // Deep copy documents to avoid mutating original data
    editForm.documents = developer.documents
        ? developer.documents.map((doc) => ({
              ...doc,
              processing: false,
              success: false,
          }))
        : [];
    showEdit.value = true;
}
function submitEdit() {
    editForm.put(route("developers.update", editForm.id), {
        onSuccess: () => (showEdit.value = false),
    });
}

// Save a single document's edits
function submitEditDocument(doc = null) {
    // If called from the modal, use editDocForm; if called from inline, use doc param
    const target = doc || editDocForm;
    target.processing = true;
    target.success = false;
    const payload = {
        title: target.title,
        department: target.department,
        type: target.type,
        uploaded_by: target.uploaded_by,
        status: target.status,
        approval_comment: target.approval_comment,
        approved_by: target.approved_by,
    };
    router.put(route("documents.update", target.id), payload, {
        preserveScroll: true,
        onSuccess: () => {
            target.processing = false;
            target.success = true;
            setTimeout(() => {
                if (!doc) {
                    showEditDoc.value = false;
                    editDocForm.success = false;
                } else {
                    doc.success = false;
                }
            }, 1200);
            window.location.reload();
        },
        onError: () => {
            target.processing = false;
        },
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
    feedbackForm.reset();
    feedbackForm.developer_id = developer.id;
    selectedDeveloper.value = developer;
    showFeedback.value = true;
    feedbackSuccess.value = false;
}
function submitFeedback() {
    feedbackForm.post(route("feedback.store"), {
        onSuccess: () => {
            feedbackSuccess.value = true;
            feedbackForm.message = "";
            setTimeout(() => {
                showFeedback.value = false;
                feedbackSuccess.value = false;
            }, 1200);
        },
    });
}

// --- Edit Document Modal Logic ---
const showEditDoc = ref(false);
const editDocForm = reactive({
    id: null,
    title: "",
    department: "",
    type: "",
    uploaded_by: "",
    status: "",
    approval_comment: "",
    approved_by: "",
    processing: false,
    success: false,
});

function openEditDoc(doc) {
    Object.assign(editDocForm, {
        id: doc.id,
        title: doc.title,
        department: doc.department,
        type: doc.type,
        uploaded_by: doc.uploaded_by,
        status: doc.status,
        approval_comment: doc.approval_comment,
        approved_by: doc.approved_by,
        processing: false,
        success: false,
    });
    showEditDoc.value = true;
}
</script>

<style scoped>
.main-bg {
    background: linear-gradient(120deg, #f8fafc 0%, #e9f1fa 100%);
    min-height: 100vh;
}
.dev-card {
    background: #fff;
    border-radius: 1.5rem;
    box-shadow: 0 8px 32px rgba(60, 72, 100, 0.13),
        0 1.5px 4px rgba(60, 72, 100, 0.08);
    padding: 2.5rem 1.5rem;
    max-width: 98vw;
    margin-bottom: 2rem;
}
.main-table-responsive {
    width: 100%;
    overflow-x: auto;
    padding-bottom: 1rem;
}
.dev-table {
    border-radius: 1rem;
    overflow: hidden;
    min-width: 900px;
    background: #fafdff;
}
.docs-table-responsive {
    max-width: 700px;
    overflow-x: auto;
}
.docs-table {
    min-width: 650px;
    font-size: 0.92rem;
    background: #f8fafd;
    border-radius: 0.75rem;
}
.table th,
.table td {
    vertical-align: middle !important;
    border-bottom: 1px solid #e9ecef;
    padding: 0.5rem 0.5rem;
    word-break: break-word;
}
.table thead th {
    border-top: none;
    font-size: 1.01rem;
    font-weight: 600;
    letter-spacing: 0.01em;
    background: #eaf1fb;
}
.table-hover tbody tr:hover {
    background: #f6fafd;
    transition: background 0.2s ease;
}
.upload-form {
    background: #f6fafd;
    border: 1px solid #e3eaf3;
}
.btn {
    font-size: 0.875rem;
    padding: 0.4rem 0.75rem;
    border-radius: 6px;
}
.badge {
    font-size: 0.85em;
    padding: 0.35em 0.7em;
    border-radius: 0.5em;
}
@media (max-width: 1200px) {
    .docs-table {
        min-width: 500px;
        font-size: 0.89rem;
    }
    .main-table-responsive {
        padding-bottom: 2rem;
    }
}
@media (max-width: 900px) {
    .dev-card {
        padding: 1.2rem 0.2rem;
    }
    .dev-table {
        min-width: 700px;
    }
}
@media (max-width: 768px) {
    .main-table-responsive {
        padding-bottom: 2.5rem;
    }
    .docs-table {
        min-width: 400px;
        font-size: 0.85rem;
    }
    .dev-table {
        min-width: 500px;
    }
    .table th,
    .table td {
        padding: 0.35rem 0.35rem;
    }
}
@media (max-width: 576px) {
    .main-table-responsive {
        padding-bottom: 3rem;
    }
    .docs-table {
        min-width: 350px;
        font-size: 0.8rem;
    }
    .dev-table {
        min-width: 350px;
    }
    .table th,
    .table td {
        padding: 0.25rem 0.25rem;
    }
    .dev-card {
        padding: 0.5rem 0.1rem;
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
