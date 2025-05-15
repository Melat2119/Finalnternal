<template>
    <!-- <AuthenticatedLayout> -->
    <div class="container-fluid py-5 main-bg">
        <div class="dev-card mx-auto">
            <h1 class="fw-bold text-primary mb-4 text-center">
                📱 Social Media Documents
            </h1>

            <div class="mb-6 flex justify-between items-center">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Search by manager, email, or document title..."
                    class="border rounded px-4 py-2 w-full max-w-md shadow-sm form-control"
                />
                <button
                    class="btn btn-success px-4 ms-4"
                    @click="openCreateManagerModal"
                >
                    <i class="bi bi-plus-lg me-2"></i> Create New Manager
                </button>
            </div>

            <div
                v-if="!allDocuments || allDocuments.length === 0"
                class="alert alert-info text-center"
            >
                No documents found.
            </div>

            <div class="main-table-responsive">
                <table
                    class="table table-bordered table-hover align-middle mb-0 dev-table"
                >
                    <thead class="table-light">
                        <tr>
                            <th>Manager Name</th>
                            <th>Manager Email</th>
                            <th>Document Title</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>File</th>
                            <th>Uploaded By</th>
                            <th>Approved By</th>
                            <th>Comment</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="docItem in allDocuments"
                            :key="docItem.doc.id"
                        >
                            <td class="fw-semibold">
                                {{ docItem.manager.name }}
                            </td>
                            <td>{{ docItem.manager.email }}</td>
                            <td>{{ docItem.doc.title }}</td>
                            <td>{{ docItem.doc.type }}</td>
                            <td>
                                <span
                                    :class="statusBadge(docItem.doc.status)"
                                    >{{ docItem.doc.status }}</span
                                >
                            </td>
                            <td>
                                {{ formatDate(docItem.doc.created_at) }}
                            </td>
                            <td>
                                <a
                                    v-if="docItem.doc.file_path"
                                    :href="
                                        route(
                                            'documents.download',
                                            docItem.doc.id
                                        )
                                    "
                                    class="btn btn-link p-0"
                                    title="Download"
                                >
                                    <i class="bi bi-download"></i>
                                </a>
                            </td>
                            <td>{{ docItem.doc.uploaded_by }}</td>
                            <td>{{ docItem.doc.approved_by }}</td>
                            <td>
                                {{ docItem.doc.approval_comment || "—" }}
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button
                                        class="btn btn-outline-primary"
                                        @click="
                                            openEditDocModal(
                                                docItem.doc,
                                                docItem.manager
                                            )
                                        "
                                        title="Edit Document"
                                    >
                                        ✏️
                                    </button>
                                    <button
                                        class="btn btn-outline-danger"
                                        @click="
                                            openDeleteDocModal(
                                                docItem.doc,
                                                docItem.manager
                                            )
                                        "
                                        title="Delete Document"
                                    >
                                        🗑️
                                    </button>
                                    <button
                                        class="btn btn-outline-warning"
                                        @click="
                                            openFeedbackModal(
                                                docItem.doc,
                                                docItem.manager
                                            )
                                        "
                                        title="Feedback"
                                    >
                                        💬
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Create Manager Modal -->
            <Modal :show="showCreateManager" @close="showCreateManager = false">
                <template #default>
                    <h4>Create New Manager</h4>
                    <form @submit.prevent="submitCreateManager">
                        <div class="mb-3">
                            <label>Name</label
                            ><input
                                v-model="createManagerForm.name"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label>Email</label
                            ><input
                                v-model="createManagerForm.email"
                                type="email"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="d-flex gap-2">
                            <button
                                class="btn btn-success"
                                :disabled="createManagerForm.processing"
                            >
                                Create</button
                            ><button
                                type="button"
                                class="btn btn-secondary"
                                @click="showCreateManager = false"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </template>
            </Modal>

            <!-- Edit Manager Modal -->
            <Modal :show="showEditManager" @close="showEditManager = false">
                <template #default>
                    <h4>Edit Manager: {{ editManagerForm.name }}</h4>
                    <form @submit.prevent="submitEditManager">
                        <div class="mb-3">
                            <label>Name</label
                            ><input
                                v-model="editManagerForm.name"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label>Email</label
                            ><input
                                v-model="editManagerForm.email"
                                type="email"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="d-flex gap-2">
                            <button
                                class="btn btn-primary"
                                :disabled="editManagerForm.processing"
                            >
                                Update</button
                            ><button
                                type="button"
                                class="btn btn-secondary"
                                @click="showEditManager = false"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </template>
            </Modal>

            <!-- Edit Document Modal -->
            <Modal :show="showEditDoc" @close="showEditDoc = false">
                <template #default>
                    <h4>Edit Document: {{ editDocForm.title }}</h4>
                    <form @submit.prevent="submitEditDocument">
                        <div class="mb-2">
                            <label class="small">Title</label
                            ><input
                                v-model="editDocForm.title"
                                class="form-control"
                            />
                        </div>
                        <div class="mb-2">
                            <label class="small">Type</label
                            ><input
                                v-model="editDocForm.type"
                                class="form-control"
                            />
                        </div>
                        <div class="mb-2">
                            <label class="small">Status</label
                            ><input
                                v-model="editDocForm.status"
                                class="form-control"
                            />
                        </div>
                        <div class="mb-2">
                            <label class="small">Uploaded By</label
                            ><input
                                v-model="editDocForm.uploaded_by"
                                class="form-control"
                            />
                        </div>
                        <div class="mb-2">
                            <label class="small">Approved By</label
                            ><input
                                v-model="editDocForm.approved_by"
                                class="form-control"
                            />
                        </div>
                        <div class="mb-2">
                            <label class="small">Approval Comment</label
                            ><input
                                v-model="editDocForm.approval_comment"
                                class="form-control"
                            />
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button
                                class="btn btn-primary"
                                :disabled="editDocForm.processing"
                            >
                                Save
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

            <!-- Delete Modals (Manager and Document) -->
            <Modal :show="showDeleteManager" @close="showDeleteManager = false">
                <template #default>
                    <h4>Delete Manager</h4>
                    <p>
                        Are you sure you want to delete manager
                        <b>{{ selectedManager?.name }}</b
                        >? This will also detach their documents.
                    </p>
                    <div class="d-flex gap-2 mt-3">
                        <button
                            class="btn btn-danger"
                            @click="submitDeleteManager"
                        >
                            Yes, Delete</button
                        ><button
                            class="btn btn-secondary"
                            @click="showDeleteManager = false"
                        >
                            Cancel
                        </button>
                    </div>
                </template>
            </Modal>
            <Modal :show="showDeleteDoc" @close="showDeleteDoc = false">
                <template #default>
                    <h4>Delete Document</h4>
                    <p>
                        Are you sure you want to delete document
                        <b>{{ selectedDoc?.title }}</b
                        >?
                    </p>
                    <div class="d-flex gap-2 mt-3">
                        <button
                            class="btn btn-danger"
                            @click="submitDeleteDocument"
                        >
                            Yes, Delete</button
                        ><button
                            class="btn btn-secondary"
                            @click="showDeleteDoc = false"
                        >
                            Cancel
                        </button>
                    </div>
                </template>
            </Modal>

            <!-- Feedback Modal -->
            <Modal :show="showFeedback" @close="showFeedback = false">
                <template #default>
                    <h4>Feedback for: {{ selectedDoc?.title }}</h4>
                    <form @submit.prevent="submitFeedback">
                        <div class="mb-3">
                            <label class="form-label">Message</label
                            ><textarea
                                v-model="feedbackForm.message"
                                class="form-control"
                                rows="3"
                                required
                            ></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button
                                class="btn btn-success"
                                :disabled="feedbackForm.processing"
                            >
                                Submit</button
                            ><button
                                type="button"
                                class="btn btn-secondary"
                                @click="showFeedback = false"
                            >
                                Cancel
                            </button>
                        </div>
                        <div
                            v-if="feedbackForm.success"
                            class="text-success mt-2"
                        >
                            Feedback Sent!
                        </div>
                    </form>
                </template>
            </Modal>
        </div>
    </div>
    <!-- </AuthenticatedLayout> -->
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import { ref, reactive, computed, watchEffect } from "vue";
import { router, usePage, useForm } from "@inertiajs/vue3";

const props = defineProps({
    managers: { type: Array, default: () => [] },
});

const search = ref("");

// Manager Modals & Forms
const showCreateManager = ref(false);
const showEditManager = ref(false);
const showDeleteManager = ref(false);
const selectedManager = ref(null);

const createManagerForm = useForm({ name: "", email: "" });
const editManagerForm = useForm({ id: null, name: "", email: "" });

// Document Modals & Forms
const showEditDoc = ref(false);
const showDeleteDoc = ref(false);
const selectedDoc = ref(null);

const editDocForm = useForm({
    id: null,
    title: "",
    type: "",
    status: "",
    uploaded_by: "",
    approved_by: "",
    approval_comment: "",
});

// New Document Upload to Any Manager
const showUploadNewDocToAnyManager = ref(false);
const newDocToAnyManagerForm = useForm({
    manager_id: "",
    title: "",
    type: "",
    file: null,
    success: false,
});

// Feedback Modal & Form
const showFeedback = ref(false);
const feedbackForm = useForm({
    document_id: null,
    message: "",
    success: false,
});

// Computed property to flatten managers and their documents for the single table
const allDocuments = computed(() => {
    let flatDocs = [];
    props.managers.forEach((manager) => {
        if (manager.documents && manager.documents.length) {
            manager.documents.forEach((doc) => {
                flatDocs.push({ manager: manager, doc: doc });
            });
        }
    });

    if (!search.value) return flatDocs;
    const searchTerm = search.value.toLowerCase();
    return flatDocs.filter(
        (item) =>
            item.manager.name.toLowerCase().includes(searchTerm) ||
            item.manager.email.toLowerCase().includes(searchTerm) ||
            (item.doc.title &&
                item.doc.title.toLowerCase().includes(searchTerm))
    );
});

function statusBadge(status) {
    const classes = {
        pending: "badge bg-warning text-dark",
        approved: "badge bg-success",
        rejected: "badge bg-danger",
    };
    return classes[status] || "badge bg-secondary";
}

function formatDate(dateString) {
    if (!dateString) return "N/A";
    return new Date(dateString).toLocaleDateString(undefined, {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
}

// Manager CRUD
function openCreateManagerModal() {
    createManagerForm.reset();
    showCreateManager.value = true;
}
function submitCreateManager() {
    createManagerForm.post(route("socialmedia.store"), {
        onSuccess: () => {
            showCreateManager.value = false;
            router.reload({ only: ["managers"] });
        },
    });
}
function openEditManagerModal(manager) {
    selectedManager.value = manager;
    editManagerForm.id = manager.id;
    editManagerForm.name = manager.name;
    editManagerForm.email = manager.email;
    showEditManager.value = true;
}
function submitEditManager() {
    editManagerForm.put(route("socialmedia.update", editManagerForm.id), {
        onSuccess: () => {
            showEditManager.value = false;
            router.reload({ only: ["managers"] });
        },
    });
}
function openDeleteManagerModal(manager) {
    selectedManager.value = manager;
    showDeleteManager.value = true;
}
function submitDeleteManager() {
    router.delete(route("socialmedia.destroy", selectedManager.value.id), {
        onSuccess: () => {
            showDeleteManager.value = false;
            router.reload({ only: ["managers"] });
        },
    });
}

// Document Actions
function openEditDocModal(doc, manager) {
    selectedDoc.value = doc;
    editDocForm.id = doc.id;
    editDocForm.title = doc.title;
    editDocForm.type = doc.type;
    editDocForm.status = doc.status;
    editDocForm.uploaded_by = doc.uploaded_by;
    editDocForm.approved_by = doc.approved_by;
    editDocForm.approval_comment = doc.approval_comment;
    editDocForm.success = false;
    showEditDoc.value = true;
}
function submitEditDocument() {
    editDocForm.put(route("documents.update", editDocForm.id), {
        onSuccess: () => {
            editDocForm.success = true;
            setTimeout(() => {
                showEditDoc.value = false;
                router.reload({ only: ["managers"] });
            }, 1000);
        },
        onError: (errors) => {
            console.error(errors);
            alert("Update failed. Check console.");
        },
    });
}

function openDeleteDocModal(doc, manager) {
    selectedDoc.value = doc;
    showDeleteDoc.value = true;
}
function submitDeleteDocument() {
    router.delete(route("documents.destroy", selectedDoc.value.id), {
        onSuccess: () => {
            showDeleteDoc.value = false;
            router.reload({ only: ["managers"] });
        },
    });
}

// Feedback
function openFeedbackModal(doc, manager) {
    selectedDoc.value = doc;
    feedbackForm.document_id = doc.id;
    feedbackForm.message = "";
    feedbackForm.success = false;
    showFeedback.value = true;
}
function submitFeedback() {
    feedbackForm.post(route("feedback.store"), {
        onSuccess: () => {
            feedbackForm.success = true;
            setTimeout(() => {
                showFeedback.value = false;
                feedbackForm.reset();
            }, 1500);
        },
    });
}

// Upload new document to any manager
function openUploadNewDocToAnyManagerModal() {
    newDocToAnyManagerForm.reset();
    newDocToAnyManagerForm.success = false;
    showUploadNewDocToAnyManager.value = true;
}

function handleNewDocToAnyManagerFileChange(event) {
    newDocToAnyManagerForm.file = event.target.files[0];
}

function submitNewDocumentToSelectedManager() {
    if (!newDocToAnyManagerForm.manager_id || !newDocToAnyManagerForm.file) {
        alert("Please select a manager and a file.");
        return;
    }
    newDocToAnyManagerForm.post(
        route("socialmedia.upload", newDocToAnyManagerForm.manager_id),
        {
            onSuccess: () => {
                newDocToAnyManagerForm.success = true;
                setTimeout(() => {
                    showUploadNewDocToAnyManager.value = false;
                    router.reload({ only: ["managers"] });
                }, 1500);
            },
            onError: (errors) => {
                console.error(errors);
                alert("Upload failed. Check console.");
            },
        }
    );
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
    padding: 2rem 1.5rem;
    max-width: 95vw;
}
.main-table-responsive {
    width: 100%;
    overflow-x: auto;
}
.dev-table {
    border-radius: 1rem;
    overflow: hidden;
    min-width: 1200px;
}
.table th,
.table td {
    vertical-align: middle !important;
    padding: 0.6rem;
}
.table thead th {
    font-weight: 600;
    background: #eaf1fb;
}
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1040;
    display: flex;
    align-items: center;
    justify-content: center;
}
.modal-box {
    background: #fff;
    border-radius: 0.5rem;
    padding: 1.5rem;
    min-width: 400px;
    max-width: 600px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}
.btn-link {
    text-decoration: none;
}
.btn-group-sm .btn {
    padding: 0.2rem 0.4rem;
    font-size: 0.8rem;
}
</style>
