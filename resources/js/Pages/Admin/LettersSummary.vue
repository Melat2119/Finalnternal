<template>
  <main class="p-6 space-y-6">
    <h2 class="text-2xl font-semibold text-gray-700">✉️ Letter Summary</h2>

    <!-- Add Letter Button -->
    <div class="mb-4">
      <button @click="showPopup = true" class="bg-blue-600 text-white px-4 py-2 rounded">Add Letter</button>
    </div>

    <!-- Letter Creation Popup -->
    <div v-if="showPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
      <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg relative">
        <button @click="closePopup" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
        <h3 class="text-lg font-semibold mb-4">➕ Add Letter</h3>
        <form @submit.prevent="addLetter" class="space-y-4">
          <div class="border rounded p-4 bg-gray-50">
            <div class="mb-2">
              <label class="block text-sm font-medium mb-1">Subject</label>
              <input v-model="form.subject" type="text" class="border p-2 rounded w-full" required />
            </div>
            <div class="mb-2">
              <label class="block text-sm font-medium mb-1">Content</label>
              <textarea v-model="form.content" class="border p-2 rounded w-full" rows="3" placeholder="Letter content..."></textarea>
            </div>
            <div class="mb-2">
              <label class="block text-sm font-medium mb-1">Department</label>
              <input v-model="form.department" type="text" class="border p-2 rounded w-full" />
            </div>
            <div class="mb-2">
              <label class="block text-sm font-medium mb-1">Status</label>
              <input v-model="form.status" type="text" class="border p-2 rounded w-full" required />
            </div>
            <div class="mb-2">
              <label class="block text-sm font-medium mb-1">Created By</label>
              <select v-model="form.created_by" class="border p-2 rounded w-full">
                <option value="">Select User</option>
                <option v-for="user in users" :key="user.id" :value="user.name">{{ user.name }}</option>
              </select>
            </div>
          </div>
          <div class="flex justify-end mt-4">
            <button type="button" @click="closePopup" class="mr-2 px-4 py-2 rounded border">Cancel</button>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add Letter</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Letters Table -->
    <div class="bg-white p-4 shadow rounded">
      <h3 class="text-lg font-semibold mb-2">📨 Recent Letters</h3>
      <table class="w-full text-left text-sm border">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 border">Subject</th>
            <th class="p-2 border">Content</th>
            <th class="p-2 border">Department</th>
            <th class="p-2 border">Status</th>
            <th class="p-2 border">Created By</th>
            <th class="p-2 border">Date</th>
            <th class="p-2 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="letter in letters" :key="letter.id" class="border-t">
            <td class="p-2 border">
              <span v-if="editId !== letter.id">{{ letter.subject }}</span>
              <input v-else v-model="editForm.subject" class="border p-1 rounded w-full" />
            </td>
            <td class="p-2 border">
              <span v-if="editId !== letter.id">{{ letter.content }}</span>
              <input v-else v-model="editForm.content" class="border p-1 rounded w-full" />
            </td>
            <td class="p-2 border">
              <span v-if="editId !== letter.id">{{ letter.department }}</span>
              <input v-else v-model="editForm.department" class="border p-1 rounded w-full" />
            </td>
            <td class="p-2 border">
              <span v-if="editId !== letter.id">{{ letter.status }}</span>
              <input v-else v-model="editForm.status" class="border p-1 rounded w-full" />
            </td>
            <td class="p-2 border">
              <span v-if="editId !== letter.id">{{ letter.created_by }}</span>
              <select v-else v-model="editForm.created_by" class="border p-1 rounded w-full">
                <option value="">Select User</option>
                <option v-for="user in users" :key="user.id" :value="user.name">{{ user.name }}</option>
              </select>
            </td>
            <td class="p-2 border">{{ letter.created_at }}</td>
            <td class="p-2 border">
              <button v-if="editId !== letter.id" @click="startEdit(letter)" class="text-blue-600 mr-2">Edit</button>
              <button v-if="editId === letter.id" @click="updateLetter(letter.id)" class="text-green-600 mr-2">Save</button>
              <button v-if="editId === letter.id" @click="cancelEdit" class="text-gray-600 mr-2">Cancel</button>
              <button @click="deleteLetter(letter.id)" class="text-red-600">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const page = usePage()
const letters = ref(page.props.letters)
// Defensive: fallback to [] if users is undefined
const users = computed(() => page.props.users ?? [])

const showPopup = ref(false)
const form = ref({ subject: '', content: '', department: '', status: '', created_by: '' })
const editId = ref(null)
const editForm = ref({ subject: '', content: '', department: '', status: '', created_by: '' })

const addLetter = () => {
  router.post('/admin/letters', form.value, {
    onSuccess: () => {
      form.value = { subject: '', content: '', department: '', status: '', created_by: '' }
      editId.value = null
      showPopup.value = false
    }
  })
}

const closePopup = () => {
  showPopup.value = false
}

const startEdit = (letter) => {
  editId.value = letter.id
  editForm.value = { ...letter }
}

const cancelEdit = () => {
  editId.value = null
  editForm.value = { subject: '', content: '', department: '', status: '', created_by: '' }
}

const updateLetter = (id) => {
  router.put(`/admin/letters/${id}`, editForm.value, {
    onSuccess: () => {
      editId.value = null
    }
  })
}

const deleteLetter = (id) => {
  if (confirm('Are you sure you want to delete this letter?')) {
    router.delete(`/admin/letters/${id}`)
  }
}
</script>
