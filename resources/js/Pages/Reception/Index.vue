<template>
    <AuthenticatedLayout>
        <div class="container-fluid py-5">
            <div class="dev-card mx-auto">
                <h1 class="fw-bold text-primary mb-4 text-center">
                    🛎️ Reception Letters & Documents
                </h1>
                <div class="mb-6 flex justify-between items-center">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search by reception, email, or letter title..."
                        class="form-control form-control-lg rounded-pill px-4 py-2 w-50 shadow-sm"
                    />
                    <button
                        class="btn btn-primary px-4 ms-4 rounded-pill fw-bold"
                        @click="openCreateReceptionModal"
                    >
                        <i class="bi bi-person-plus me-2"></i> New Reception
                    </button>
                </div>
                <form
                    v-if="props.receptions.length"
                    @submit.prevent="submitNewDocumentUpload"
                    class="upload-form shadow rounded-4 p-4 bg-light mb-4"
                >
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Reception</label>
                            <select
                                v-model="newDocForm.reception_id"
                                class="form-select rounded-pill"
                                required
                            >
                                <option disabled value="">
                                    Select Reception
                                </option>
                                <option
                                    v-for="r in props.receptions"
                                    :key="r.id"
                                    :value="r.id"
                                >
                                    {{ r.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Letter Title</label>
                            <input
                                v-model="newDocForm.title"
                                class="form-control rounded-pill"
                                required
                                placeholder="e.g. Welcome Letter"
                            />
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Type</label>
                            <input
                                v-model="newDocForm.type"
                                class="form-control rounded-pill"
                                placeholder="e.g. Letter"
                            />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">File</label>
                            <input
                                type="file"
                                @change="onFileChange"
                                class="form-control rounded-pill"
                                required
                            />
                        </div>
                        <div class="col-md-1">
                            <button
                                class="btn btn-primary w-100 rounded-pill"
                                :disabled="newDocForm.processing"
                            >
                                <span
                                    v-if="newDocForm.processing"
                                    class="spinner-border spinner-border-sm"
                                ></span>
                                <span v-else>Upload</span>
                            </button>
                        </div>
                    </div>
                    <div
                        v-if="newDocForm.success"
                        class="text-success small text-center mt-2"
                    >
                        <i class="bi bi-check-circle-fill"></i> Letter uploaded!
                    </div>
                </form>
                <div
                    v-if="!allDocuments.length"
                    class="alert alert-info text-center py-4"
                >
                    <i class="bi bi-inbox display-5 text-muted"></i>
                    <div class="mt-2">No letters or documents found.</div>
                </div>
                <div class="main-table-responsive">
                    <table
                        class="table table-bordered table-hover align-middle mb-0 reception-table"
                    >
                        <thead class="table-light">
                            <tr>
                                <th>Reception</th>
                                <th>Email</th>
                                <th>Letter Title</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>File</th>
                                <th>Uploaded By</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="docItem in allDocuments"
                                :key="docItem.doc.id"
                            >
                                <td class="fw-semibold text-primary">
                                    {{ docItem.reception.name }}
                                </td>
                                <td class="text-muted">
                                    {{ docItem.reception.email }}
                                </td>
                                <td class="fw-bold">{{ docItem.doc.title }}</td>
                                <td>{{ docItem.doc.type }}</td>
                                <td>
                                    <span
                                        :class="statusBadge(docItem.doc.status)"
                                    >
                                        {{ docItem.doc.status }}
                                    </span>
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
                                        title="Open Letter"
                                        target="_blank"
                                    >
                                        <i
                                            class="bi bi-file-earmark-pdf fs-5 text-danger"
                                        ></i>
                                    </a>
                                </td>
                                <td>{{ docItem.doc.uploaded_by }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            class="btn btn-outline-primary rounded-circle"
                                            @click="
                                                openEditDocModal(
                                                    docItem.doc,
                                                    docItem.reception
                                                )
                                            "
                                            title="Edit Letter"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button
                                            class="btn btn-outline-danger rounded-circle"
                                            @click="
                                                openDeleteDocModal(
                                                    docItem.doc,
                                                    docItem.reception
                                                )
                                            "
                                            title="Delete Letter"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Add modals for create/edit/delete as needed -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, computed, reactive } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    receptions: { type: Array, default: () => [] },
});

const search = ref("");
const allDocuments = computed(() => {
    let flatDocs = [];
    props.receptions.forEach((reception) => {
        if (reception.documents && reception.documents.length) {
            reception.documents.forEach((doc) => {
                flatDocs.push({ reception, doc });
            });
        }
    });
    if (!search.value) return flatDocs;
    const searchTerm = search.value.toLowerCase();
    return flatDocs.filter(
        (item) =>
            item.reception.name.toLowerCase().includes(searchTerm) ||
            item.reception.email.toLowerCase().includes(searchTerm) ||
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
const newDocForm = reactive({
    reception_id: "",
    title: "",
    type: "",
    file: null,
    processing: false,
    success: false,
});
function onFileChange(event) {
    newDocForm.file = event.target.files[0];
}
function submitNewDocumentUpload() {
    if (!newDocForm.reception_id || !newDocForm.file) {
        alert("Please select a reception and a file.");
        return;
    }
    newDocForm.processing = true;
    newDocForm.success = false;
    const formData = new FormData();
    formData.append("title", newDocForm.title);
    formData.append("type", newDocForm.type);
    formData.append("file", newDocForm.file);
    router.post(route("reception.upload", newDocForm.reception_id), formData, {
        forceFormData: true,
        onSuccess: () => {
            newDocForm.processing = false;
            newDocForm.success = true;
            setTimeout(() => (newDocForm.success = false), 2000);
            newDocForm.title = "";
            newDocForm.type = "";
            newDocForm.file = null;
            newDocForm.reception_id = "";
            router.reload({ only: ["receptions"] });
        },
        onError: () => {
            newDocForm.processing = false;
        },
    });
}
function openCreateReceptionModal() {
    // Implement modal logic for creating a new reception if needed
}
function openEditDocModal(doc, reception) {
    // Implement modal logic for editing a letter/document
}
function openDeleteDocModal(doc, reception) {
    // Implement modal logic for deleting a letter/document
}
</script>

<style scoped>
.reception-bg {
    background: #f8fafc;
    min-height: 100vh;
}
.dev-card,
.reception-card {
    background: #fff;
    border-radius: 1.5rem;
    box-shadow: 0 8px 32px rgba(60, 72, 100, 0.13),
        0 1.5px 4px rgba(60, 72, 100, 0.08);
    padding: 2.5rem 2rem;
    max-width: 1100px;
}
.main-table-responsive {
    width: 100%;
    overflow-x: auto;
}
.reception-table {
    border-radius: 1rem;
    overflow: hidden;
    min-width: 1100px;
    background: #fafdff;
}
.table th,
.table td {
    vertical-align: middle !important;
    padding: 0.7rem 0.7rem;
    word-break: break-word;
}
.table thead th {
    border-top: none;
    font-size: 1.07rem;
    font-weight: 600;
    letter-spacing: 0.01em;
}
.table-hover tbody tr:hover {
    background: #f6fafd;
    transition: background 0.2s ease;
}
.badge {
    font-size: 0.95em;
    padding: 0.35em 0.7em;
    border-radius: 0.5em;
}
@media (max-width: 1200px) {
    .reception-table {
        min-width: 800px;
        font-size: 0.95rem;
    }
}
@media (max-width: 900px) {
    .dev-card,
    .reception-card {
        padding: 1.2rem 0.2rem;
    }
    .reception-table {
        min-width: 600px;
    }
}
@media (max-width: 768px) {
    .main-table-responsive {
        padding-bottom: 2.5rem;
    }
    .reception-table {
        min-width: 400px;
        font-size: 0.92rem;
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
    .reception-table {
        min-width: 350px;
        font-size: 0.85rem;
    }
    .table th,
    .table td {
        padding: 0.25rem 0.25rem;
    }
    .dev-card,
    .reception-card {
        padding: 0.5rem 0.1rem;
    }
}
</style>
