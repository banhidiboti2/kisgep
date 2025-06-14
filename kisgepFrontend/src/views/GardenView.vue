<template>
  <div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Kerti Gépek </h1>
      <router-link to="/" class="back-button">Vissza</router-link>
    </div>

    <div v-if="loading" class="text-center py-8">
      <p>Betöltés...</p>
    </div>

    <div v-else-if="error" class="text-center py-8 text-red-600">
      <p>{{ error }}</p>
    </div>

    <div v-else class="grid grid-cols-3 gap-4">
      <div v-for="(item, index) in items" :key="index" class="product-container bg-white rounded shadow hover:shadow-md transition-shadow">
        <div class="product-inner border border-gray-300 p-4 text-center h-full flex flex-col">
          <div class="img-wrapper">
            <img :src="getProductImage(item)" alt="Gép" class="product-image">
          </div>
          <div class="product-details">
            <p class="font-semibold">{{ item.name || item.nev }}</p>
            <p>{{ item.description || item.leiras }}</p>
            <p>Ár: {{ item.price || item.ar }} Ft</p>
          </div>
          <button 
            @click="addToBasket(item)" 
            class="button mt-auto"
            :class="{ 'in-basket': isInBasket(item.id) }">
            {{ isInBasket(item.id) ? 'Kosárban' : 'Kosárba' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>
import axios from 'axios';

export default {
  name: 'GardenView',
  data() {
    return {
      items: [],
      basket: JSON.parse(localStorage.getItem('basket')) || [],
      loading: true,
      error: null
    };
  },
  methods: {
    addToBasket(item) {
      const basketItem = {
        id: item.id,
        name: item.name || item.nev,
        description: item.description || item.leiras,
        price: item.price || item.ar,
        image: this.getProductImage(item)
      };
      
      if (!this.isInBasket(item.id)) {
        this.basket.push(basketItem);
        localStorage.setItem('basket', JSON.stringify(this.basket));
      }
    },
    
    isInBasket(itemId) {
      return this.basket.some(item => item.id === itemId);
    },
    
    fetchProducts() {
      this.loading = true;
      this.error = null;

      axios.get('http://127.0.0.1:8000/api/termekek', { withCredentials: false })
        .then(response => {
          console.log('API Response:', response.data);
          if (Array.isArray(response.data)) {
            this.items = response.data.slice(12, 24);
          } else if (response.data.data && Array.isArray(response.data.data)) {
            this.items = response.data.data.slice(12, 24);
          } else {
            console.error('Unexpected data format:', response.data);
            this.error = 'Váratlan adatformátum az API válaszában';
          }
          this.loading = false;
        })
        .catch(error => {
          console.error('Error fetching products:', error);
          this.error = 'Hiba történt a termékek betöltése közben.';
          this.loading = false;
        });
    },
    
    getProductImage(item) {
      if (item.kep && typeof item.kep === 'string') {
        if (item.kep.startsWith('data:image')) {
          return item.kep;
        } else {
          return `data:image/png;base64,${item.kep}`;
        }
      }
      
      if (item.image_url) {
        return item.image_url;
      }
      
      if (item.id) {
        return `http://127.0.0.1:8000/api/termekek/${item.id}/kep`;
      }
      
      return 'https://via.placeholder.com/200x200?text=Nincs+kép';
    },
  },
  
  created() {
    this.fetchProducts();
  }
};
</script>
  
<style scoped>
.product-container {
  transition: transform 0.2s;
}

.product-inner {
  display: flex;
  flex-direction: column;
}

.product-container:hover {
  transform: translateY(-5px);
}

.img-wrapper {
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 10px;
}

.product-image {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.product-details {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  margin-bottom: 10px;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.grid {
  display: grid;
}

.grid-cols-3 {
  grid-template-columns: repeat(1, 1fr);
}

@media (min-width: 640px) {
  .grid-cols-3 {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .grid-cols-3 {
    grid-template-columns: repeat(3, 1fr);
  }
}

.gap-4 {
  gap: 1rem;
}

.back-button {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
  margin-left: auto;
  border: none;
  outline: none;
  font-size: 1rem;
}

@media (max-width: 640px) {
  .flex {
    flex-direction: column;
    align-items: center;
    gap: 10px;
  }

  .back-button {
    margin-left: 0;
    margin-top: 10px;
  }
}

.button {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
  margin-top: auto;
  border: none;
  outline: none;
}

.button.in-basket {
  background-color: #4CAF50;
  color: white;
}
</style>