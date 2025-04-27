<template>
    <div class="admin-container mx-auto p-4">
      <h1 class="text-2xl font-bold mb-4">Admin Panel - Termék feltöltés</h1>
      
      <div v-if="loading" class="text-center py-8">
        <p>Betöltés...</p>
      </div>
  
      <div v-else-if="error" class="text-center py-8 text-red-600">
        <p>{{ error }}</p>
      </div>
  
      <div v-else>
        <!-- Add Product Form -->
        <div class="bg-white p-6 rounded shadow mb-6">
          <h2 class="text-xl font-bold mb-4">Új termék feltöltése</h2>
          <form @submit.prevent="addProduct" class="space-y-4">
            <div>
              <label class="block mb-1">Név:</label>
              <input v-model="newProduct.name" required class="w-full p-2 border rounded">
            </div>
            <div>
              <label class="block mb-1">Leírás:</label>
              <textarea v-model="newProduct.description" class="w-full p-2 border rounded" rows="4"></textarea>
            </div>
            <div>
              <label class="block mb-1">Ár (Ft):</label>
              <input v-model.number="newProduct.price" type="number" required class="w-full p-2 border rounded">
            </div>
            <div>
              <label class="block mb-1">Kép URL:</label>
              <input v-model="newProduct.image_url" class="w-full p-2 border rounded">
            </div>
            <div v-if="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded my-4">
              {{ successMessage }}
            </div>
            <button type="submit" class="admin-button w-full" :disabled="isSubmitting">
              {{ isSubmitting ? 'Feltöltés folyamatban...' : 'Termék feltöltése' }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'AdminView',
    data() {
      return {
        loading: false,
        error: null,
        isSubmitting: false,
        successMessage: '',
        newProduct: {
          name: '',
          description: '',
          price: 0,
          image_url: ''
        }
      };
    },
    methods: {
      addProduct() {
        this.isSubmitting = true;
        this.successMessage = '';
        
        axios.post('http://127.0.0.1:8000/api/termekek', this.newProduct, { withCredentials: false })
          .then(response => {
            this.newProduct = {
              name: '',
              description: '',
              price: 0,
              image_url: ''
            };
            this.successMessage = 'Termék sikeresen hozzáadva!';
            this.isSubmitting = false;
          })
          .catch(error => {
            console.error('Error adding product:', error);
            this.error = 'Hiba történt a termék hozzáadása közben.';
            this.isSubmitting = false;
          });
      }
    }
  };
  </script>
  
  <style scoped>
  .admin-container {
    max-width: 800px;
    margin: 0 auto;
  }
  
  .admin-button {
    background-color: #3b82f6;
    color: white;
    padding: 0.75rem 1rem;
    border-radius: 0.25rem;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s;
    font-weight: bold;
  }
  
  .admin-button:hover:not(:disabled) {
    background-color: #2563eb;
  }
  
  .admin-button:disabled {
    background-color: #93c5fd;
    cursor: not-allowed;
  }
  </style>