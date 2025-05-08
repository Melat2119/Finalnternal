<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4">
      <span class="navbar-brand mb-0 h3"> Document Categories</span>
  
      <div class="ms-auto">
        <form class="d-flex" @submit.prevent="onSearch">
          <input
            v-model="searchQuery"
            class="form-control me-2"
            type="search"
            placeholder="Search"
            aria-label="Search"
          />
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </nav>
  </template>
  
  <script>
  
  export default {
    data() {
      return {
        searchQuery: ''
      }
    },
    methods: {
      onSearch() {
        alert('Searching for: ' + this.searchQuery)
      }
    }
  }
  </script>
  