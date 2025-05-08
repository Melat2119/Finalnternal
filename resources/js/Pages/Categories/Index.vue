<template>
  <AuthenticatedLayout>

 
  <div class="d-flex min-vh-100 bg-light">
    <!-- Sidebar -->
    <Sidebar />
    <template>
     <AuthenticatedLayout>
    <div class="developers-page">
        <aside class="sidebar">
            <h2>Menu</h2>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Documents</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </aside>
        <main class="content">
            <header class="header">
                <h1>Developer Documents</h1>
                <div>
                    <button @click="createDocument">Create Document</button>
                </div>
            </header>
            <div class="documents-table">
                <h2>Document List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Document Name</th>
                            <th>Created At</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="document in documents" :key="document.id">
                            <td>{{ document.name }}</td>
                            <td>{{ document.createdAt }}</td>
                            <td>{{ document.createdBy }}</td>
                            <td>
                                <button @click="viewDocument(document)">View</button>
                                <button @click="editDocument(document.id)">Edit</button>
                                <button @click="deleteDocument(document.id)">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- View Modal -->
            <div v-if="showModal" class="modal-overlay">
                <div class="modal-content">
                    <h3>Document Details</h3>
                    <p><strong>Name:</strong> {{ selectedDocument.name }}</p>
                    <p><strong>Created At:</strong> {{ selectedDocument.createdAt }}</p>
                    <p><strong>Created By:</strong> {{ selectedDocument.createdBy }}</p>
                    <button @click="closeModal">Close</button>
                </div>
            </div>
        </main>
    </div>
</AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const documents = ref([
    { id: 1, name: "Project Plan", createdAt: "2023-10-01", createdBy: "John Doe" },
    { id: 2, name: "API Documentation", createdAt: "2023-10-02", createdBy: "Jane Smith" },
    { id: 3, name: "UI Guidelines", createdAt: "2023-10-03", createdBy: "Alice Johnson" },
]);

const showModal = ref(false);
const selectedDocument = ref({});

const createDocument = () => {
    const name = prompt("Enter document name:");
    if (name) {
        documents.value.push({
            id: Date.now(),
            name,
            createdAt: new Date().toISOString().slice(0, 10),
            createdBy: "Current User"
        });
    }
};
const viewDocument = (doc) => {
    selectedDocument.value = doc;
    showModal.value = true;
};
const closeModal = () => {
    showModal.value = false;
};
const editDocument = (id) => {
    const doc = documents.value.find(d => d.id === id);
    if (doc) {
        const newName = prompt("Edit document name:", doc.name);
        if (newName) doc.name = newName;
    }
};
const deleteDocument = (id) => {
    if (confirm("Are you sure you want to delete this document?")) {
        documents.value = documents.value.filter(doc => doc.id !== id);
    }
};
</script>

<style scoped>
.developers-page {
    display: flex;
    font-family: Arial, sans-serif;
}

.sidebar {
    width: 200px;
    background: #f4f4f4;
    padding: 20px;
    border-right: 1px solid #ddd;
}

.sidebar h2 {
    margin-bottom: 10px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin-bottom: 10px;
}

.sidebar ul li a {
    text-decoration: none;
    color: #333;
}

.content {
    flex: 1;
    padding: 20px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header button {
    padding: 10px 20px;
    background: #28a745;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 10px;
}

.header button:hover {
    background: #218838;
}

.documents-table table {
    width: 100%;
    border-collapse: collapse;
}

.documents-table th, .documents-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.documents-table th {
    background: #f4f4f4;
}

.documents-table td button {
    margin-right: 5px;
    padding: 5px 10px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.documents-table td button:hover {
    background: #0056b3;
}

.documents-table td button:last-child {
    background: #dc3545;
}

.documents-table td button:last-child:hover {
    background: #a71d2a;
}

/* Modal styles */
.modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.modal-content {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    min-width: 300px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
</style>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4">
      <!-- Search Bar -->
      <div class="d-flex justify-content-end mb-4">
        <div class="input-group w-50 shadow-sm rounded-pill overflow-hidden">
          <span class="input-group-text bg-white border-0">
            <i class="bi bi-search text-muted"></i>
          </span>
          <input
            type="text"
            class="form-control border-0"
            placeholder="Search documents..."
          />
        </div>
      </div>

      <!-- Recent Documents -->
      <h3 class="text-success fw-bold text-center mb-3">Recent Documents</h3>
      <div id="recentCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner rounded-4 shadow-sm">
          <div
            class="carousel-item"
            :class="{ active: index === 0 }"
            v-for="(slide, index) in recentDocuments"
            :key="'recent-' + index"
          >
            <div class="d-flex justify-content-center gap-3 p-3">
              <img
                v-for="(img, i) in slide"
                :key="i"
                :src="img"
                class="rounded shadow"
                style="height: 100px; width: 100px; object-fit: cover;"
              />
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#recentCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#recentCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>

      <!-- Most Viewed -->
      <h3 class="text-success fw-bold text-center mb-3">Most Viewed</h3>
      <div id="viewedCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner rounded-4 shadow-sm">
          <div
            class="carousel-item"
            :class="{ active: index === 0 }"
            v-for="(slide, index) in mostViewed"
            :key="'viewed-' + index"
          >
            <div class="d-flex justify-content-center gap-3 p-3">
              <img
                v-for="(img, i) in slide"
                :key="i"
                :src="img"
                class="rounded shadow"
                style="height: 100px; width: 100px; object-fit: cover;"
              />
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#viewedCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#viewedCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>
  </div>
</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';


const recentDocuments = [
  ['/assets/doc1.jpg', '/assets/doc2.jpg', '/assets/doc3.jpg', '/assets/doc4.jpg'],
  ['/assets/doc5.jpg', '/assets/doc6.jpg', '/assets/doc7.jpg', '/assets/doc8.jpg']
]

const mostViewed = [
  ['/assets/register.jpg', '/assets/doc2.jpg', '/assets/doc3.jpg', '/assets/doc4.jpg'],
  ['/assets/doc5.jpg', '/assets/doc6.jpg', '/assets/doc7.jpg', '/assets/doc8.jpg']
]
</script>

<style scoped>
.carousel-inner {
  border-radius: 20px;
  overflow: hidden;
}
</style>
