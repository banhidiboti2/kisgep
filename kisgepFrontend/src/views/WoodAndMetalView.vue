<template>
  <div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Fa és Fémipari Gépek</h1>
      <router-link to="/" class="back-button">Vissza</router-link>
    </div>

    <div v-if="loading" class="text-center py-8">
      <p>Betöltés...</p>
    </div>

    <div v-else-if="error" class="text-center py-8 text-red-600">
      <p>{{ error }}</p>
    </div>

    <div v-else class="grid grid-cols-3 gap-4">
      <div v-for="(item, index) in limitedItems" :key="index" class="product-container bg-white rounded shadow hover:shadow-md transition-shadow">
        <div class="product-inner border border-gray-300 p-4 text-center h-full flex flex-col">
          <div class="img-wrapper">
            <img :src="getProductImage(item)" alt="Gép" class="product-image">
          </div>
          <div class="product-details">
            <p class="font-semibold">{{ item.name || item.nev }}</p>
            <p>{{ item.description || item.leiras }}</p>
            <p>Ár: {{ item.price || item.ar }} Ft</p>
          </div>
          <button @click="addToBasket(item)" class="button mt-auto">Kosárba</button>
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
      error: null,
      fetchedData: false
    };
  },
  computed: {
    // Csak az első 12 termék megjelenítése
    limitedItems() {
      return this.items.slice(0, 12);
    }
  },
  methods: {
    addToBasket(item) {
      // Create a copy of the item with consistent property names and add image
      const basketItem = {
        id: item.id,
        name: item.name || item.nev,
        description: item.description || item.leiras,
        price: item.price || item.ar,
        image: this.getProductImage(item)
      };
      
      this.basket.push(basketItem);
      localStorage.setItem('basket', JSON.stringify(this.basket));
      
      // Show confirmation to user
      alert('Termék hozzáadva a kosárhoz!');
    },

    fetchProducts() {
      if (this.fetchedData) return; // Prevent duplicate calls
      
      this.loading = true;
      this.error = null;

      axios.get('http://127.0.0.1:8000/api/termekek', { withCredentials: false })
        .then(response => {
          console.log('API Response:', response.data);
          this.items = Array.isArray(response.data) ? response.data : [];
          this.loading = false;
          this.fetchedData = true;
        })
        .catch(error => {
          console.error('API Error:', error);
          this.error = 'Az adatok betöltése sikertelen. Kérjük próbálja újra később.';
          this.loading = false;
        });
    },

    getProductImage(item) {
      // Ha a kép base64 formátumban van
      if (item.kep && typeof item.kep === 'string') {
        // Ellenőrizzük, hogy a kép már tartalmaz-e data URI sémát
        if (item.kep.startsWith('data:image')) {
          return item.kep;
        } else {
          // Ha nyers base64 adat, hozzáadjuk a data URI sémát
          return `data:image/png;base64,${item.kep}`;
        }
      }
      
      // Ha van image_url, használjuk azt
      if (item.image_url) {
        return item.image_url;
      }
      
      // Alternatív megoldás: képet lekérni a termék ID alapján
      if (item.id) {
        return `http://127.0.0.1:8000/api/termekek/${item.id}/kep`;
      }
      
      // Ha egyik sem működik, használunk egy alapértelmezett placeholder képet
      return 'https://via.placeholder.com/200x200?text=Nincs+kép';
    },
  },

  created() {
    this.fetchProducts();
  }
};
</script>
  
<style scoped>
/* Minden stílus változatlan marad */
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
  grid-template-columns: repeat(3, 1fr);
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
}

.button {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
  margin-top: auto;
}
</style>