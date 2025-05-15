<template>
    <!-- <AuthenticatedLayout> -->
    <div class="container-fluid py-5 main-bg">
        <div class="dev-card mx-auto">
            <h1 class="fw-bold text-primary mb-4 text-center">
                UI/UX Designers & Documents
            </h1>
            <div
                v-if="!designers || designers.length === 0"
                class="alert alert-info text-center"
            >
                No designers found.
            </div>
            <div class="main-table-responsive">
                <table class="table table-bordered align-middle mb-0 dev-table">
                    <thead class="table-light">
                        <tr>
                            <th>Documents</th>
                            <th>Upload Document</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="designer in designers" :key="designer.id">
                            <td style="min-width: 350px">
                                <div
                                    v-if="
                                        designer.documents &&
                                        designer.documents.length
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
                                                <th>Status</th>
                                                <th>Approved By</th>
                                                <th>Approval Comment</th>
                                                <th>Uploaded By</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="doc in designer.documents"
                                                :key="
                                                    doc.id + '-' + designer.id
                                                "
                                            >
                                                <td>{{ doc.title }}</td>
                                                <td>
                                                    {{ doc.department }}
                                                </td>
                                                <td>{{ doc.type }}</td>
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
                                                    {{ doc.approved_by }}
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
                                                <td>{{ doc.uploaded_by }}</td>
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
                                    v-if="uploadForms[designer.id]"
                                    @submit.prevent="submitUpload(designer.id)"
                                    class="upload-form shadow-sm rounded p-2 bg-light"
                                >
                                    <input
                                        v-model="uploadForms[designer.id].title"
                                        class="form-control mb-1"
                                        placeholder="Document Title"
                                        required
                                    />
                                    <input
                                        v-model="
                                            uploadForms[designer.id].department
                                        "
                                        class="form-control mb-1"
                                        placeholder="Department"
                                    />
                                    <input
                                        v-model="uploadForms[designer.id].type"
                                        class="form-control mb-1"
                                        placeholder="Type"
                                    />
                                    <input
                                        type="file"
                                        class="form-control mb-1"
                                        @change="
                                            onFileChange($event, designer.id)
                                        "
                                        required
                                    />
                                    <button
                                        class="btn btn-outline-success w-100"
                                        :disabled="
                                            uploadForms[designer.id].processing
                                        "
                                    >
                                        <span
                                            v-if="
                                                uploadForms[designer.id]
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
                                        v-if="uploadForms[designer.id].success"
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
                                        @click="openEdit(designer)"
                                    >
                                        ✏️
                                    </button>
                                    <button
                                        class="btn btn-sm btn-outline-danger"
                                        @click="deleteDesigner(designer)"
                                    >
                                        🗑️
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

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
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import { ref, reactive, watchEffect } from "vue";
import { router, usePage } from "@inertiajs/vue3";

const designers = ref(usePage().props.designers);

const uploadForms = reactive({});
watchEffect(() => {
    designers.value.forEach((designer) => {
        if (!uploadForms[designer.id]) {
            uploadForms[designer.id] = reactive({
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

function onFileChange(event, designerId) {
    const file = event.target.files[0];
    uploadForms[designerId].file = file;
}
function submitUpload(designerId) {
    const form = uploadForms[designerId];
    form.processing = true;
    form.success = false;
    const formData = new FormData();
    formData.append("file", form.file);
    formData.append("title", form.title);
    formData.append("department", form.department);
    formData.append("type", form.type);
    router.post(route("ui.uploadDocument", designerId), formData, {
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

const showEditDoc = ref(false);
const editDocForm = reactive({
    id: null,
    title: "",
    department: "",
    type: "",
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
        status: doc.status,
        approval_comment: doc.approval_comment,
        approved_by: doc.approved_by,
        processing: false,
        success: false,
    });
    showEditDoc.value = true;
}

function submitEditDocument() {
    editDocForm.processing = true;
    editDocForm.success = false;
    const payload = {
        title: editDocForm.title,
        department: editDocForm.department,
        type: editDocForm.type,
        status: editDocForm.status,
        approval_comment: editDocForm.approval_comment,
        approved_by: editDocForm.approved_by,
    };
    router.put(route("documents.update", editDocForm.id), payload, {
        preserveScroll: true,
        onSuccess: () => {
            editDocForm.processing = false;
            editDocForm.success = true;
            setTimeout(() => {
                showEditDoc.value = false;
                editDocForm.success = false;
            }, 1200);
            window.location.reload();
        },
        onError: () => {
            editDocForm.processing = false;
        },
    });
}

function openEdit(designer) {
    // Optionally implement designer edit modal logic
}
function deleteDesigner(designer) {
    if (confirm(`Delete designer "${designer.name}"?`)) {
        router.delete(route("ui.destroy", designer.id), {
            onSuccess: () => {
                // Optionally refresh or update designers list
            },
        });
    }
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
