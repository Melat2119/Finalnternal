<template>
    <AuthenticatedLayout>
   <div class="developers-page">
      
      
       <main class="content">
           <header class="header">
               <h1>Developer Documents</h1>
               <button @click="uploadDocument">Upload Document</button>
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
                               <button @click="editDocument(document.id)">Edit</button>
                               <button @click="deleteDocument(document.id)">Delete</button>
                           </td>
                       </tr>
                   </tbody>
               </table>
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

const uploadDocument = () => {
   alert("Upload document feature coming soon!");
};
const editDocument = (id) => {
   alert(`Edit document with ID: ${id}`);
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
   background: #007bff;
   color: #fff;
   border: none;
   border-radius: 4px;
   cursor: pointer;
}

.header button:hover {
   background: #0056b3;
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
</style>
